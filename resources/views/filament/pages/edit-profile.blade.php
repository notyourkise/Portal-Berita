<x-filament-panels::page>
    <form wire:submit="updateProfile">
        {{ $this->form }}
        
        <div class="mt-6">
            <x-filament::button type="submit" color="primary" icon="heroicon-o-check">
                Save Changes
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
