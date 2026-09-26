<?php

use Livewire\Component;
use App\Services\IgdbClient;
use Illuminate\Support\Arr;

new class extends Component
{
    public array $genres = [];
    public array $platforms = [];
    public array $games = [];
    public ?array $randomGame = null;
    public bool $gameFound = false;

    public ?int $genre1 = null;
    public ?int $genre2 = null;
    public ?int $genre3 = null;
    public ?int $platform = null;

    public function mount(IgdbClient $client): void
    {
        $this->genres = $client->getGenres();
        $this->platforms = $client->getPlatforms();
    }

    public function lookForGames(IgdbClient $client): void
    {
        $this->validate([
            'genre1' => 'required|integer',
            'platform' => 'required|integer',
        ]);

        $this->games = $client->getGames([$this->genre1, $this->genre2, $this->genre3], $this->platform);

        if(count($this->games) > 0) {
            $this->randomGame = Arr::random($this->games);
        }
        $this->gameFound = true;
    }
};
?>

<flux:main class="mx-auto space-y-5">

    <flux:heading size="xl" class="text-center font-bold">Game Genre Finder</flux:heading>

    <form class="space-y-6" wire:submit="lookForGames">
        <div class="grid gap-5 grid-cols-3">
            <flux:select wire:model="genre1" label="Genre 1" placeholder="Choose genre...">
                <flux:select.option/>
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="genre2" label="Genre 2 (Optional)" placeholder="Choose genre...">
                <flux:select.option/>
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="genre3" label="Genre 3 (Optional)" placeholder="Choose genre...">
                <flux:select.option/>
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:select wire:model="platform" label="Platform" placeholder="Choose platform...">
            <flux:select.option/>
            @forEach($platforms as $platform)
                <flux:select.option value="{{$platform['id']}}"> {{$platform['name']}} </flux:select.option>
            @endforeach
        </flux:select>

        <flux:button type="submit">Search for Game</flux:button>
    </form>

    @if($gameFound)
        @if($randomGame)
            <div>
                <flux:heading class="mb-4">You may enjoy playing:</flux:heading>
                <flux:card class="space-y-3 gap-6">
                    <flux:heading size="xl" class="text-center">{{ $randomGame['name'] }}</flux:heading>
                    <img src="{{ $randomGame['cover'] }}" alt="{{ $randomGame['name'] }} cover image"
                         class="mx-auto h-64 w-44 shrink-0 rounded-lg"
                    >
                    <flux:text class="text-justify">{{$randomGame['summary']}}</flux:text>
                    <flux:text>Developer: {{$randomGame['developer']}}</flux:text>
                    <flux:text>Release Date: {{ date("d-m-Y", $randomGame['releaseDate']) }}</flux:text>
                    <flux:text>Available Platforms: {{ $randomGame['platforms'] }}</flux:text>
                </flux:card>
            </div>
        @else
            <flux:heading>Could not find a game with the given filters, try using fewer / less random genres.</flux:heading>
        @endif
    @endif
</flux:main>
