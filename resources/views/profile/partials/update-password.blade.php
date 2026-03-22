<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Change Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    @if (session('status') === 'password-updated')
        <div class="mt-4 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Success!</span> Password updated.
        </div>
    @endif

    <form method="post" action="{{ route('profile.password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block font-medium text-sm text-gray-700">
                Current Password
            </label>
            <input
                type="password"
                name="current_password"
                id="current_password"
                class="border-gray-300 dark:bg-white/10 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                autocomplete="current-password"
            >
            @error('current_password', 'password_update')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700">
                New Password
            </label>
            <input
                type="password"
                name="password"
                id="password"
                class="border-gray-300 dark:bg-white/10 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                autocomplete="new-password"
            >
            @error('password', 'password_update')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- 3. Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
                Confirm Password
            </label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="border-gray-300 dark:bg-white/10 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                autocomplete="new-password"
            >
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Update Password') }}
            </button>
        </div>
    </form>
</section>
