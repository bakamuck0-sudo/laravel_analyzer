<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" <h3 class="text-xl font-bold mb-4">Новый Анализ Сайта</h3>

<form method="POST" action="{{ route('analyze.store') }}">
    @csrf <div>
        <label for="url" class="block font-medium text-sm text-gray-700">URL Сайта</label>
        <input id="url" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="url" placeholder="https://example.com" required autofocus />

        @error('url')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            Анализировать
        </button>
    </div>
</form>

@if (session('status'))
    <div class="mt-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif>
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
