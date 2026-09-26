<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IgdbClient
{

    public function getOAuth(): String
    {
        if($accessToken = Cache::get('igdb_access_token')){
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
}
