<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>

    <script>
        (function () {
            try {
                var storedTheme = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var useDark = storedTheme ? storedTheme === 'dark' : prefersDark;
                if (useDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (error) {
                // Fallback to system preference if localStorage is blocked.
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
    <style>
        .dark body { background-color: #0f172a; color: #e5e7eb; }
        .dark .bg-white { background-color: #111827 !important; }
        .dark .bg-gray-50 { background-color: #1f2937 !important; }
        .dark .bg-gray-100 { background-color: #111827 !important; }
        .dark .bg-gray-200 { background-color: #1f2937 !important; }
        .dark .bg-gray-300 { background-color: #374151 !important; }
        .dark .bg-slate-50 { background-color: #111827 !important; }
        .dark .bg-slate-100 { background-color: #1f2937 !important; }
        .dark .text-gray-900 { color: #f3f4f6 !important; }
        .dark .text-gray-800 { color: #e5e7eb !important; }
        .dark .text-gray-700 { color: #d1d5db !important; }
        .dark .text-gray-600 { color: #9ca3af !important; }
        .dark .text-gray-500 { color: #9ca3af !important; }
        .dark .text-slate-900 { color: #f3f4f6 !important; }
        .dark .text-slate-800 { color: #e5e7eb !important; }
        .dark .text-slate-700 { color: #d1d5db !important; }
        .dark .text-slate-600 { color: #9ca3af !important; }
        .dark .text-slate-500 { color: #9ca3af !important; }
        .dark .border-gray-200 { border-color: #374151 !important; }
        .dark .border-gray-300 { border-color: #4b5563 !important; }
        .dark .border-slate-100 { border-color: #374151 !important; }
        .dark .border-slate-200 { border-color: #4b5563 !important; }
        .dark .shadow-lg, .dark .shadow-md, .dark .shadow-sm {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35) !important;
        }

        /* this is for the build guide and site map it turns tailwind colours from amber to violet/indigo*/
        .dark .bg-amber-600 { background-color: #7c3aed !important; }
        .dark .bg-orange-500 { background-color: #8b5cf6 !important; }
        .dark .text-amber-500 { color: #a78bfa !important; }
        .dark .text-amber-400 { color: #c4b5fd !important; }

        .dark .from-orange-500\/20 { --tw-gradient-from: rgba(139, 92, 246, 0.2) !important; }
        .dark .from-orange-500 { --tw-gradient-from: #8b5cf6 !important; }
        .dark .to-amber-600 { --tw-gradient-to: #6d28d9 !important; }
    </style>
    @livewireStyles
    <link rel="icon" href="{{ asset('mouse.jpeg') }}">
</head>
<body class="bg-gray-100 text-gray-900 transition-colors duration-300 dark:bg-slate-900 dark:text-gray-100">

    <main>
        {{ $slot }}
    </main>



    @livewireScripts
    <livewire:chatbot />
    <script>
        window.toggleTheme = function () {
            var root = document.documentElement;
            var willBeDark = !root.classList.contains('dark');
            root.classList.toggle('dark', willBeDark);
            localStorage.setItem('theme', willBeDark ? 'dark' : 'light');
        };
    </script>
</body>
</html>
