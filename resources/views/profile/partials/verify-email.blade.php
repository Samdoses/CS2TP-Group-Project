<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <section class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Verify Email Change
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                We have sent a 6-digit verification code to your <strong>current</strong> email address. 
                Please enter it below to confirm the update to your new email.
            </p>
        </header>
    
        <form method="post" action="{{ route('profile.verify-email.store') }}" class="mt-6 space-y-6">
            @csrf
    
            <div>
                <label for="code" class="block font-medium text-sm text-gray-700">Verification Code</label>
                <input 
                    id="code" 
                    name="code" 
                    type="text" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2" 
                    required 
                    autofocus 
                    placeholder="123456"
                >
                @error('code')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Verify & Update Email
                </button>
    
                {{-- Cancel Link --}}
                <a href="{{ route('profile.index') }}" class="text-gray-600 text-sm hover:underline">
                    Cancel
                </a>
            </div>
        </form>
    </section>

</body>
</html>