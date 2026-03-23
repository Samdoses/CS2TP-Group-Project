<x-header></x-header>
<x-layout>

    <div class="relative min-h-screen w-full overflow-hidden bg-gray-200/50 dark:bg-gray-800/50">
        <x-video-background lightOpacity="opacity-10" darkOpacity="opacity-40" />

    <div class= "relative z-10 text-gray-800 font-sans flex flex-col min-h-screen">
    <main class="grow pt-8 sm:pt-12 md:pt-16">

        <div class="bg-gray-200/50 dark:bg-[#1f2937]/50">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-3xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                        Your Dream Build. <span class="text-happy-green">Without the Guesswork.</span>
                    </h1>
                    <p class="mt-5 max-w-xl mx-auto text-base sm:text-lg md:text-xl text-gray-500">
                        Happy Hardware is an e-commerce platform designed for students, professionals, and gamers who seek high performance on a budget.
                    </p>
                </div>
            </div>
        </div>

        <div class="relative z-10 bg-happy-gray py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900">
                            Why Happy Hardware?
                        </h2>
                        <p class="mt-4 text-base sm:text-lg text-gray-500">
                            Custom PC building can be intimidating. Complex jargon, compatibility issues, and rising costs make it hard to start.
                        </p>
                        <p class="mt-4 text-base sm:text-lg text-gray-500">
                            We differentiate ourselves by providing a <strong>welcoming UI and comprehensive support</strong>. From our intuitive Parts Picker to our AI Chatbot, we ensure you can build your first PC with confidence.
                        </p>
                        <div class="mt-8">
                            <a href="/part-picker" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700">
                                Try the Part Picker
                            </a>
                        </div>
                    </div>
                    <div class="mt-8 lg:mt-0 flex justify-center">
                        <div class="h-64 w-full bg-white rounded-lg shadow-lg overflow-hidden border-4 border-happy-yellow">
                            <img src="{{ asset('images/pc_parts.jpg') }}" alt="Happy Hardware Components" class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 border-t border-gray-200 bg-gray-50 py-16 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Meet Team 27</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-gray-600 dark:text-gray-300 sm:text-xl">
                        The students behind the platform, combining frontend creativity with backend integrity.
                    </p>
                </div>

                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>

                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Aisha Jama</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>

                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Aishah Hussain</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Fullstack,Backend,Frontend,Develop,Owner,Shareholder,Employee,CEO,Senior Enginner,Doctor & DB</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>
                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Samuel D'Souza</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Frontend / UI</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>
                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Zain Khan</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                     <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>

                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Harjot Singh</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Fullstack Dev</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>
                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Thomas Thackham</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>

                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Mohamoud Mohamoud</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Backend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-white rounded-2xl border border-gray-200 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-700 shadow-inner dark:bg-slate-700 dark:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>

                            </div>
                            <h3 class="mt-6 text-sm font-semibold text-gray-900 dark:text-white">Yusuf Saif</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-sm text-gray-600 dark:text-gray-300">Backend Development</dd>
                            </dl>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        <br><br>
    </main>
    </div>
    </div>
</x-layout>
<x-footer></x-footer>

