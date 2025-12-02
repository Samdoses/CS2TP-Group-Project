<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('initial views.partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                {{-- <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">{{ __('Repository') }}</flux:navlist.item> --}}
                {{-- <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">{{ __('Documentation') }}</flux:navlist.item> --}}
                
                <flux:navlist.item icon="magnifying-glass" :href="route('search')" wire:navigate>{{ __('Search') }}</flux:navlist.item>
                <flux:navlist.item icon="cog-6-tooth" :href="route('settings.edit')" wire:navigate>{{ __('Settings') }}</flux:navlist.item>
                <flux:navlist.item icon="information-circle" :href="route('help')" wire:navigate>{{ __('Help') }}</flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        <main class="flex-1">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>