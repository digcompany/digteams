<x-jet-form-section submit="updateTeamDomain">
    <x-slot name="title">
        {{ __('Organization Name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The Organization\'s domain.') }}
    </x-slot>

    <x-slot name="form">

        <!-- Organization Name -->
        <div class="col-span-6 sm:col-span-4">
            <div class="inline-flex flex-row items-center w-full space-x-2">
                <x-jet-label for="domain" value="{{ __('Organization Domain') }}" />
                <a target="_blank" href="{{ route('docs.index', ['file' => 'teamdomains' ]) }}">
                    @svg('phosphor-info-duotone', 'h-4 w-4 text-blue-500 hover:text-indigo-700')
                </a>
            </div>
            <div class="inline-flex flex-row items-center w-full space-x-2">

                <x-jet-input id="domain" type="text" class="block w-full mt-1" wire:model.defer="state.domain"
                    :disabled="! Gate::check('update', $team)" />

                <a class="inline-flex flex-row items-center space-x-1 text-xs text-blue-500 hover:text-indigo-700" target="_blank" href="{{ $team->url }}">
                    @svg('fas-arrow-up-right-from-square', 'h-5 w-5') <span>Visit</span>
                </a>


            </div>

            <x-jet-input-error for="domain" class="mt-2" />
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
    @endif
</x-jet-form-section>
