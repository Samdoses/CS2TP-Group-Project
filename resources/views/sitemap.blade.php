<x-header></x-header>
<x-layout>

<script src="https://unpkg.com/lucide@latest"></script>

<div class="min-h-screen pb-32 transition-colors duration-300 bg-slate-50 dark:bg-[#0f0a1a]">

    <div class="max-w-6xl mx-auto px-6 pt-16 md:pt-24 pb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-4">
                <h1 class="text-5xl sm:text-6xl md:text-8xl font-black tracking-tighter text-slate-900 dark:text-white" style="font-family: 'Syne', sans-serif;">
                    Sitemap
                </h1>
            </div>
            <div class="md:text-left">
                <p class="text-slate-500 dark:text-violet-300/60 max-w-[280px] border border-2 rounded-2xl pl-5 border-orange-500 dark:border-violet-500  leading-relaxed font-medium italic text-sm md:text-base">
                    "The blueprint to your hardware journey. Every button built for speed."
                </p>
            </div>
        </div>
        <div class="w-full h-px bg-gradient-to-r from-orange-500 dark:from-violet-500 via-transparent to-transparent mt-12 opacity-30"></div>
    </div>

    <main class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="flex flex-col space-y-4">
                <div class="flex items-center gap-4 ml-1">
                    <span class="flex-none w-8 h-8 rounded-lg bg-orange-500 dark:bg-violet-600 text-white flex items-center justify-center font-black text-xs shadow-lg shadow-orange-500/20">01</span>
                    <h2 class="text-lg font-bold tracking-tight text-slate-800 dark:text-white uppercase italic" style="font-family: 'Syne', sans-serif;">Discovery</h2>
                </div>

                <div class="grid grid-cols-1 gap-3 w-full">
                    <a href="/" class="group w-full p-5 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <i data-lucide="home" class="w-5 h-5 text-orange-500 dark:text-violet-400"></i>
                                <span class="font-bold text-slate-700 dark:text-slate-200">Home Page</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>

                    <a href="/store" class="group w-full p-5 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <i data-lucide="shopping-cart" class="w-5 h-5 text-orange-500 dark:text-violet-400"></i>
                                <span class="font-bold text-slate-700 dark:text-slate-200">Hardware Store</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="flex items-center gap-4 ml-1">
                    <span class="flex-none w-8 h-8 rounded-lg bg-orange-500 dark:bg-violet-600 text-white flex items-center justify-center font-black text-xs shadow-lg shadow-orange-500/20">02</span>
                    <h2 class="text-lg font-bold tracking-tight text-slate-800 dark:text-white uppercase italic" style="font-family: 'Syne', sans-serif;">Tools</h2>
                </div>

                <div class="grid grid-cols-1 gap-3 w-full">
                    <a href="/part-picker" class="group w-full p-5 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <i data-lucide="cpu" class="w-5 h-5 text-orange-500 dark:text-violet-400"></i>
                                <span class="font-bold text-slate-700 dark:text-slate-200">Part Picker</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>

                    <a href="/build-guide" class="group w-full p-5 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <i data-lucide="book-open" class="w-5 h-5 text-orange-500 dark:text-violet-400"></i>
                                <span class="font-bold text-slate-700 dark:text-slate-200">Assembly Guide</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="flex items-center gap-4 ml-1">
                    <span class="flex-none w-8 h-8 rounded-lg bg-orange-500 dark:bg-violet-600 text-white flex items-center justify-center font-black text-xs shadow-lg shadow-orange-500/20">03</span>
                    <h2 class="text-lg font-bold tracking-tight text-slate-800 dark:text-white uppercase italic" style="font-family: 'Syne', sans-serif;">Support</h2>
                </div>

                <div class="grid grid-cols-1 gap-3 w-full">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="/faq" class="group flex flex-col items-center text-center p-2 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm">
                            <i data-lucide="help-circle" class="w-5 h-5 text-orange-500 dark:text-violet-400 mb-2"></i>
                            <div class="font-bold text-xs sm:text-sm text-slate-700 dark:text-slate-200">FAQ</div>
                        </a>
                        <a href="/contact" class="group flex flex-col items-center text-center p-2 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm">
                            <i data-lucide="mail" class="w-5 h-5 text-orange-500 dark:text-violet-400 mb-2"></i>
                            <div class="font-bold text-xs sm:text-sm text-slate-700 dark:text-slate-200">Contact</div>
                        </a>
                    </div>

                    <a href="/about" class="group w-full p-5 bg-white dark:bg-[#160f29] border border-slate-200 dark:border-violet-900/30 rounded-2xl hover:border-orange-400 dark:hover:border-violet-500 transition-all no-underline shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <i data-lucide="users" class="w-5 h-5 text-orange-500 dark:text-violet-400"></i>
                                <span class="font-bold text-slate-700 dark:text-slate-200">About Us</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-16 group relative bg-[#2d241e] dark:bg-[#1a1333] rounded-[2rem] md:rounded-[3rem] p-8 md:p-12 overflow-hidden border border-white/5 shadow-2xl">
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-orange-500/50 dark:bg-violet-500/20 blur-[100px]"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="flex-none relative">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-3xl bg-gradient-to-br from-orange-400 to-orange-600 dark:from-violet-500 dark:to-violet-700 flex items-center justify-center shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                        <i data-lucide="mouse-pointer-2" class="w-8 h-8 md:w-10 md:h-10 text-white"></i>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-green-500 border-4 border-slate-900 flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-2xl md:text-3xl font-black text-white mb-2" style="font-family: 'Syne', sans-serif;">System Assistant Chatbot</h3>
                    <p class="text-slate-400 dark:text-violet-200/50 text-base md:text-lg leading-relaxed">
                        Need advice? <span class="text-white font-bold">Merry Mouse</span> is ready. Look for the star icon.
                    </p>
                </div>

                <a href="/contact" class="w-full md:w-auto px-8 py-4 bg-gray-50 text-slate-900 font-black rounded-xl hover:bg-orange-500 hover:text-white transition-all flex items-center justify-center gap-3 no-underline uppercase tracking-tighter text-sm">
                    Open Ticket
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </main>
</div>

<script>
    lucide.createIcons();
</script>

</x-layout>
<x-footer></x-footer>
