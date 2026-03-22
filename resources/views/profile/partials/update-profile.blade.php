<h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Profile Information</h2>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                   class="mt-1 dark:bg-white/10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2">
            @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                   class="mt-1 block dark:bg-white/10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2">
            @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full dark:bg-white/10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">


                Update Profile
            </button>
        </div>
    </div>
</form>
