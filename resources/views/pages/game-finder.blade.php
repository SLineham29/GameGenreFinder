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

        $this->randomGame = Arr::random($this->games);

        error_log(print_r($this->randomGame, true));
    }
};
?>

<flux:main class="mx-auto space-y-6 max-w-2xl">

    <flux:header size="xl">Game Genre Finder</flux:header>

    <form class="space-y-2" wire:submit="lookForGames">
        <div>
            <flux:select wire:model="genre1" label="Genre 1" placeholder="Choose genre...">
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="genre2" label="Genre 2 (Optional)" placeholder="Choose genre...">
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="genre3" label="Genre 3 (Optional)" placeholder="Choose genre...">
                @forEach($genres as $genre)
                    <flux:select.option value="{{$genre['id']}}"> {{$genre['name']}} </flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:select wire:model="platform" label="Platform" placeholder="Choose platform...">
            @forEach($platforms as $platform)
                <flux:select.option value="{{$platform['id']}}"> {{$platform['name']}} </flux:select.option>
            @endforeach
        </flux:select>

        <flux:button type="submit">Search for Game</flux:button>
    </form>

</flux:main>
