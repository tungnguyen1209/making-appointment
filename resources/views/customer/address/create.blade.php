<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Address') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('customer.address.create') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Detail -->
        <div class="mt-4">
            <x-input-label for="details" :value="__('Detail')" />
            <x-textarea-input id="details" class="block mt-1 w-full" type="details" name="details" :value="old('details')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('details')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
