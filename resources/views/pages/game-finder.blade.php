<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<flux:main class="mx-auto space-y-6 max-w-2xl">

    <flux:header size="xl">Game Genre Finder</flux:header>

    <form class="space-y-2">
        <div>
            <flux:select label="Genre 1"/>
            <flux:select label="Genre 2"/>
            <flux:select label="Genre 3"/>
        </div>

        <flux:select label="Platform"/>

        <flux:button type="submit">Search for Game</flux:button>
    </form>

</flux:main>
