<?php

use Livewire\Component;
use App\Services\IgdbClient;

new class extends Component
{
    public array $genres = [];
    public array $platforms = [];

    public ?int $genre1 = null;
    public ?int $genre2 = null;
    public ?int $genre3 = null;
    public ?int $platform = null;

    public function mount(IgdbClient $client): void
    {
        $this->genres = $client->getGenres();
        $this->platforms = $client->getPlatforms();
    }
};
?>

<flux:main class="mx-auto space-y-6 max-w-2xl">

    <flux:header size="xl">Game Genre Finder</flux:header>

    <form class="space-y-2">
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
