<x-guest-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Join Organization') }}
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
        <div class="py-10 mx-auto max-w-7xl">
            <div role="alert">
                <div class="px-4 py-2 font-bold text-white bg-indigo-500 rounded-t">
                    Joining an existing Organization
                </div>
                <div class="px-4 py-2 text-indigo-700 bg-indigo-100 border border-t-0 border-indigo-400 rounded-b">
                    <p class="font-bold">Invited to join an organization?</p>
                    <p class="text-sm">To join an existing organization, click the "accept invitation" button in the team invitation mail.</p>

                    <p class="text-sm">Didn't get a team invitation mail? Ask a member of an existing organization to invite you to their team.</p>
                    <div class="flex items-center justify-end p-2">
                        <a href="{{ route('billing') }}">
                            <x-jet-secondary-button>
                                {{ __('Upgrade') }}
                            </x-jet-secondary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
