<x-admin-layout title="Admin Management">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Head Admin Tools</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Admin Management</h1>
                    <p class="mt-2 max-w-3xl text-sm text-gray-600 dark:text-gray-300">
                        Create new admin accounts and monitor admin activity from one place. This page is only available to the head admin account.
                    </p>
                </div>
                <div class="rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-white/5 dark:text-gray-300">
                    Total admins: <span class="font-semibold text-gray-900 dark:text-white">{{ $admins->count() }}</span>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-8 xl:grid-cols-[1.1fr_1.4fr]">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Create Admin</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">New admins get standard admin access. Head-admin access remains restricted.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.management.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="FirstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                            <input id="FirstName" name="FirstName" type="text" value="{{ old('FirstName') }}" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                        <div>
                            <label for="LastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last name</label>
                            <input id="LastName" name="LastName" type="text" value="{{ old('LastName') }}" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                    </div>

                    <div>
                        <label for="admin_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                        <input id="admin_username" name="admin_username" type="text" value="{{ old('admin_username') }}" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input id="password" name="password" type="password" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                    </div>

                    <button type="submit" class="inline-flex rounded-full bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                        Create Admin Account
                    </button>
                </form>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Admin Accounts</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View who has access and their most recent tracked activity.</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach ($admins as $admin)
                        <article class="rounded-2xl border border-gray-200 p-4 dark:border-gray-800">
                            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $admin->FirstName }} {{ $admin->LastName }}</h3>
                                        @if ($admin->isHeadAdmin())
                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-200">Head Admin</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $admin->email }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Username: {{ $admin->admin_username }}</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-white/5 dark:text-gray-300">
                                    <p>Tracked actions: <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($admin->activities_count) }}</span></p>
                                    <p class="mt-1">
                                        Last activity:
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ optional($admin->latestActivity?->created_at)->format('d M Y H:i') ?: 'No activity yet' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Admin Activity Log</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Monitor logins, product changes, support actions, and admin account creation.</p>
                </div>

                <form method="GET" action="{{ route('admin.management.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    <div>
                        <label for="admin_id" class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Admin</label>
                        <select id="admin_id" name="admin_id" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                            <option value="">All admins</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->getKey() }}" @selected($adminFilter === $admin->getKey())>{{ $admin->FirstName }} {{ $admin->LastName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="action" class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Action</label>
                        <select id="action" name="action" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                            <option value="">All actions</option>
                            @foreach ($availableActions as $action)
                                <option value="{{ $action }}" @selected($actionFilter === $action)>{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="inline-flex rounded-full border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10">
                            Filter
                        </button>
                        <a href="{{ route('admin.management.index') }}" class="inline-flex rounded-full border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <th class="px-4 py-3">When</th>
                            <th class="px-4 py-3">Admin</th>
                            <th class="px-4 py-3">Action</th>
                            <th class="px-4 py-3">Details</th>
                            <th class="px-4 py-3">Target</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="px-4 py-4 text-gray-600 dark:text-gray-300">{{ optional($activity->created_at)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">
                                    {{ $activity->admin?->FirstName }} {{ $activity->admin?->LastName }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">{{ $activity->action }}</span>
                                </td>
                                <td class="px-4 py-4 text-gray-600 dark:text-gray-300">{{ $activity->description }}</td>
                                <td class="px-4 py-4 text-gray-600 dark:text-gray-300">
                                    @if ($activity->targetAdmin)
                                        {{ $activity->targetAdmin->FirstName }} {{ $activity->targetAdmin->LastName }}
                                    @elseif (! empty($activity->metadata['product_name']))
                                        {{ $activity->metadata['product_name'] }}
                                    @elseif (! empty($activity->metadata['order_id']))
                                        Order #{{ $activity->metadata['order_id'] }}
                                    @elseif (! empty($activity->metadata['message_id']))
                                        Message #{{ $activity->metadata['message_id'] }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No admin activity has been logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>
        </section>
    </section>
</x-admin-layout>
