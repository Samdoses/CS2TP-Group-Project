<x-header></x-header>

<div class="min-h-screen flex flex-col bg-gray-200/50 dark:bg-gray-800/50">
    <x-layout>
    <x-video-background lightOpacity="opacity-100" darkOpacity="opacity-100" />
        <main class="flex-grow flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex w-full max-w-3xl flex-col justify-center gap-6">
                <div class="rounded-3xl border border-gray-300 bg-white p-8 text-gray-800 shadow-2xl dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />
                    <br>

                    <x-auth-session-status class="text-center" :status="session('status')" />

                    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <flux:input
                                    name="first_name"
                                    :label="__('First Name')"
                                    :value="old('first_name')"
                                    type="text"
                                    required
                                    autofocus
                                    autocomplete="given-name"
                                    :placeholder="__('First Name')"
                                />
                            </div>
                            <div>
                                <flux:input
                                    name="last_name"
                                    :label="__('Last Name')"
                                    :value="old('last_name')"
                                    type="text"
                                    required
                                    autocomplete="family-name"
                                    :placeholder="__('Last Name')"
                                />
                            </div>
                        </div>

                        <flux:input
                            name="email"
                            :label="__('Email address')"
                            :value="old('email')"
                            type="email"
                            required
                            autocomplete="email"
                            placeholder="email@example.com"
                        />

                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            :placeholder="__('Password')"
                            viewable
                        />

                        <flux:input
                            name="password_confirmation"
                            :label="__('Confirm password')"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            :placeholder="__('Confirm password')"
                            viewable
                        />

                        <div class="flex items-center justify-end">
                            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                                {{ __('Create account') }}
                            </flux:button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('login.store') }}" class="mt-6 flex flex-col gap-6">
                        @csrf

                        <div class="flex flex-col gap-2">
                            <flux:button variant="filled" href="{{ route('google.login') }}" class="w-full border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                                {{ __('Log in with Google') }}
                            </flux:button>
                        </div>
                    </form>

                    <br>
                    <div class="mb-8 space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse dark:text-zinc-400">
                        <span>{{ __('Already have an account?') }}</span>
                        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
                    </div>
                </div>
            </div>
        </main>
    </x-layout>
</div>

<x-footer></x-footer>

