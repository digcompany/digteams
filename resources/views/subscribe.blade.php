<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="py-6">
                    Form
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://js.strip.com/v3/"></script>
    @endpush
</x-app-layout>