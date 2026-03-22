<x-header></x-header>
<x-layout>
<script src="https://unpkg.com/lucide@latest"></script>

<div class="min-h-screen bg-slate-50 font-sans text-slate-900 overflow-x-hidden transition-colors duration-300 dark:bg-slate-900">

    <div class="relative py-16 sm:py-24 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-gradient-to-b from-orange-500/20 dark:from-violet-500/20 to-transparent pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-slate-800 dark:text-white mb-6 tracking-tight leading-tight">
                Build Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-600 dark:from-violet-600 dark:to-indigo-800 text-stroke">Dream PC</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Feeling nervous? Don't be! We're here to hold your hand through every click, screw, and plug. It's just like LEGOs, but expensive!
            </p>
        </div>
    </div>

    <main class="container mx-auto px-4 -mt-10 pb-20 max-w-5xl relative z-20">

        <section class="grid md:grid-cols-2 gap-4 mb-12">
            <div class="bg-white p-6 rounded-3xl shadow-xl shadow-slate-200/60 dark:shadow-slate-950/60 border border-slate-100">
                <h3 class="font-bold text-lg mb-4 text-slate-800 flex items-center gap-2 dark:text-white">
                    <i data-lucide="wrench" class="w-5 h-5 text-amber-500"></i> Toolkit
                </h3>
                <div class="grid gap-2">
                    @foreach(['Phillips head', 'Flat head', 'Cable ties', 'Scissors'] as $tool)
                    <div x-data="{ checked: false }" @click="checked = !checked"
                         class="flex items-center gap-3 p-3 rounded-xl transition-all border select-none cursor-pointer"
                         :class="checked ? 'bg-green-50 border-green-100' : 'bg-slate-50 dark:bg-slate-900/50 border-transparent dark:border-slate-700'">
                        <div class="h-6 w-6 rounded-lg border-2 flex items-center justify-center shrink-0"
                             :class="checked ? 'bg-green-500 border-green-500' : 'border-slate-300 bg-white dark:bg-slate-800 dark:border-slate-600'">
                            <i x-show="checked" data-lucide="check" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-bold" :class="checked ? 'text-slate-400 line-through' : 'text-slate-700 dark:text-slate-200'">{{ $tool }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-xl shadow-slate-200/60 dark:shadow-slate-950/60 border border-slate-100">
                <h3 class="font-bold text-lg mb-4 text-slate-800 flex items-center gap-2 dark:text-white">
                    <i data-lucide="shield-check" class="w-5 h-5 text-amber-500"></i> Sanity Check
                </h3>
                <div class="grid gap-2">
                    @foreach(['GPU Fits?', 'CPU Compatible?', 'Flat table?', 'Warm drink? ☕'] as $check)
                    <div x-data="{ checked: false }" @click="checked = !checked"
                         class="flex items-center gap-3 p-3 rounded-xl transition-all border select-none cursor-pointer"
                         :class="checked ? 'bg-green-50 border-green-100' : 'bg-slate-50 dark:bg-slate-900/50 border-transparent dark:border-slate-700'">
                        <div class="h-6 w-6 rounded-lg border-2 flex items-center justify-center shrink-0"
                             :class="checked ? 'bg-green-500 border-green-500' : 'border-slate-300 bg-white dark:bg-slate-800 dark:border-slate-600'">
                            <i x-show="checked" data-lucide="check" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-bold" :class="checked ? 'text-slate-400 line-through' : 'text-slate-700 dark:text-slate-200'">{{ $check }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="space-y-8">

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="h-12 w-12 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-black text-xl">1</span>
                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight dark:text-white">Prep the Case</h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">Let's get your PC case ready for its new organs.</p>
                    <ul class="space-y-4">
                        <li class="flex gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 text-sm">
                            <i data-lucide="unlock" class="w-5 h-5 text-amber-500 shrink-0"></i>
                            <span class="dark:text-slate-300"><strong>Open it up:</strong> Remove both side panels. If it's glass, lay it on a rug.</span>
                        </li>
                        <li class="flex gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 text-sm">
                            <i data-lucide="layout" class="w-5 h-5 text-amber-500 shrink-0"></i>
                            <span class="dark:text-slate-300"><strong>The I/O Shield:</strong> Snap the metal plate into the back. You'll hear 4 clicks.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 dark:bg-violet-500/10 blur-[100px]"></div>
                <div class="p-8 sm:p-10 relative z-10">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="h-12 w-12 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-orange-500/30">2</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">The Motherboard</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                            <h4 class="font-bold text-amber-400 mb-2 flex items-center gap-2"><i data-lucide="cpu" class="w-4 h-4"></i> CPU</h4>
                            <p class="text-sm text-slate-300">Match the <strong>gold triangle</strong>. Zero force—let it fall into the socket. Lock the arm.</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                            <h4 class="font-bold text-amber-400 mb-2 flex items-center gap-2"><i data-lucide="thermometer" class="w-4 h-4"></i> The Cooler</h4>
                            <p class="text-sm text-slate-300">Peel the plastic sticker! Apply pea-sized paste and plug fan into <code class="text-amber-400 font-mono">CPU_FAN</code>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-amber-600 rounded-[2.5rem] shadow-2xl p-8 sm:p-10 text-white text-center">
                <i data-lucide="rocket" class="w-12 h-12 mx-auto mb-6 opacity-50"></i>
                <h2 class="text-3xl font-black mb-4">7. Blast Off!</h2>
                <p class="text-orange-100 mb-8 max-w-md mx-auto">Flip the PSU switch to 'I', hold your breath, and press the power button.</p>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 font-black text-xl border border-white/20">
                    😊 If it lights up... YOU DID IT! 😊
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    lucide.createIcons();

</script>
</x-layout>
<x-footer></x-footer>
