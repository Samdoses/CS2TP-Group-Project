<x-admin-layout title="Admin Login" :show-nav="false">
    <section class="max-w-6xl mx-auto px-4 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 dark:border-gray-800 dark:bg-gray-900">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide dark:text-gray-400">Admin Access</p>
                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Welcome back</h1>
                <p class="mt-3 text-gray-600 dark:text-gray-300">
                    Sign in with your admin credentials to manage products, users, messages, returns, and delivery updates.
                </p>

                <div class="mt-6 rounded-xl bg-gray-50 border border-gray-200 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Login field:</span> email or username</p>
                    <p class="text-sm text-gray-700 mt-1 dark:text-gray-300"><span class="font-semibold">Tip:</span> Use the same host each time (127.0.0.1 or localhost).</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Sign In</h2>

                @if ($errors->any())
                    <div class="mt-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email or Username</label>
                        <input
                            id="login"
                            name="login"
                            type="text"
                            value="{{ old('login') }}"
                            required
                            autofocus
                            placeholder="admin or admin@example.com"
                            class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white"
                        >
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Keep me signed in
                    </label>

                    <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 transition dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                        Sign In to Admin Dashboard
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-admin-layout>
