<?php

use Livewire\Component;

new class extends Component
{
    public array $OAuth = [];
    public string $accessToken = 'Fetching...';

    public function mount(): void
    {
        $this->getOAuthData();
    }

    public function getOAuthData(): void
    {
        try {
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => config('services.igdb.client_id'),
                'client_secret' => config('services.igdb.client_secret'),
                'grant_type' => 'client_credentials',
            ]);
            $this->OAuth = $response->json();
            $this->accessToken = $response->json('access_token') ?? 'no token given';
        }
        catch (Exception $e) {
            $this->accessToken = $e->getMessage();
        }
    }
};
?>

<div>

    <flux:heading>IGDB OAuth Result</flux:heading>

    <flux:text>{{ $accessToken }}</flux:text>

@livewireScripts
@fluxScripts()
</div>
