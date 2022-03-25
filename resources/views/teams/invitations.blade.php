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
                    <p class="py-4 font-bold">Invited to join an organization?</p>
                    <p>To join an existing organization, click the "accept invitation" button in the team invitation mail.</p>

                    <p>Didn't get a team invitation mail? Ask a member of an existing organization to invite you to their team.</p>

                    <p class="py-4">
                        Why not try  <a class="underline" href="{{ route('teams.create') }}">creating</a> an organization of your own?
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
