<x-filament-panels::page>
    <form wire:submit="updatePassword">
        {{ $this->form }}
        
        <div class="mt-6">
            <x-filament::button type="submit" color="primary" icon="heroicon-o-check">
                Update Password
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
