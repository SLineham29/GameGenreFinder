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
}
