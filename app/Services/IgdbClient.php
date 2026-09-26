<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IgdbClient
{
    private string $apiUrl = 'https://api.igdb.com/v4';

    public function getOAuth(): String
    {
        if($accessToken = Cache::get('igdb_access_token')) {
            return $accessToken;
        }

        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => config('services.igdb.client_id'),
            'client_secret' => config('services.igdb.client_secret'),
            'grant_type' => 'client_credentials',
        ])->json();

        Cache::put('igdb_access_token', $response['access_token'], now()->addSeconds($response['expires_in']));

        return $response['access_token'];
    }

    public function getGenres(): array
    {
        return Cache::remember('igdb_genres', now()->addDay(), function () {
            return Http::withHeaders([
                'Client-ID' => config('services.igdb.client_id'),
                'Authorization' => 'Bearer ' . $this->getOAuth(),
            ])
            ->withBody('fields id,name; sort name asc; limit 500;', 'text/plain')
            ->post("{$this->apiUrl}/genres")
            ->throw()
            ->json();
        });
    }

    public function getPlatforms(): array
    {
        return Cache::remember('igdb_platforms', now()->addDay(), function () {
            return Http::withHeaders([
                'Client-ID' => config('services.igdb.client_id'),
                'Authorization' => 'Bearer ' . $this->getOAuth(),
            ])
                ->withBody('fields id,name; sort name asc; limit 500;', 'text/plain')
                ->post("{$this->apiUrl}/platforms")
                ->throw()
                ->json();
        });
    }

    public function getGames(array $genreIds, int $platformId): array
    {
        $genres = array_values(array_unique(array_filter($genreIds)));
        $genreList = implode(',', $genres);

        $games =  Http::withHeaders([
            'Client-ID' => config('services.igdb.client_id'),
            'Authorization' => 'Bearer ' . $this->getOAuth(),
        ])
            ->withBody("fields name,cover.url,platforms.name,involved_companies.company.name,involved_companies.developer,first_release_date,summary; where platforms=({$platformId}) & genres=({$genreList}); limit 500;"
                        , 'text/plain')
            ->post("{$this->apiUrl}/games")
            ->throw()
            ->json();

        return collect($games)
            ->map(function (array $game) {

                // Need to find which involved company is the actual developer of the game.
                $developer = collect($game['involved_companies'] ?? [])
                    ->firstWhere('developer', true)['company']['name'] ?? 'Unknown Developer';

                return [
                    'name' => $game['name'] ?? 'Unknown Name',
                    'cover' => $game['cover']['url'] ?? "",
                    'release_date' => $game['first_release_date'] ?? '',
                    'summary' => $game['summary'] ?? 'No summary provided.',
                    'platforms' => $game['platforms'] ?? 'Unknown Platforms',
                    'developer' => $developer,
                ];
            })->all();
    }
}
