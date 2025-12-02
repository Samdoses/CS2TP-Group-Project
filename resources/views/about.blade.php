<x-header></x-header>
<x-layout>
    <body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

    <nav class="fixed w-full top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <div class="h-10 w-10 bg-gray-300 rounded flex items-center justify-center border-2 border-happy-green">
                        <span class="text-xs font-bold text-gray-600">LOGO</span>
                    </div>
                    <span class="ml-3 font-bold text-xl tracking-tight">Happy Hardware</span>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-gray-500 hover:text-happy-green px-3 py-2 rounded-md text-sm font-medium">Store</a>
                    <a href="#" class="text-gray-900 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">About Us</a>
                    <a href="#" class="text-gray-500 hover:text-happy-green px-3 py-2 rounded-md text-sm font-medium">Contact Us</a>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Account</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Basket</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-16">

        <div class="bg-white">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                        Your Dream Build. <span class="text-happy-green">Without the Guesswork.</span>
                    </h1>
                    <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                        Happy Hardware is an e-commerce platform designed for students, professionals, and gamers who seek high performance on a budget. 
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-happy-gray py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                            Why Happy Hardware?
                        </h2>
                        <p class="mt-4 text-lg text-gray-500">
                            Custom PC building can be intimidating. Complex jargon, compatibility issues, and rising costs make it hard to start.
                        </p>
                        <p class="mt-4 text-lg text-gray-500">
                            We differentiate ourselves by providing a <strong>welcoming UI and comprehensive support</strong>. From our intuitive Parts Picker to our AI Chatbot, we ensure you can build your first PC with confidence. [cite: 47]
                        </p>
                        <div class="mt-8">
                            <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700">
                                Try the Part Picker
                            </a>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0 flex justify-center">
                        <div class="h-64 w-full bg-white rounded-lg shadow-lg flex items-center justify-center border-4 border-happy-yellow">
                            <span class="text-gray-400 italic">Image: Happy Hardware Components</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white py-16 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Meet Team 27</h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        The students behind the platform, combining frontend creativity with backend integrity.
                    </p>
                </div>
                
                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    
                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Aisha Jama</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Aishah Hussain</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Backend Development & DB</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Samuel D'Souza</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Frontend / UI</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Zain Khan</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                     <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Harjot Singh</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Backend Dev / UI</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Thomas Thackham</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Frontend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Mohamoud Mohamoud</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Backend Development</dd>
                            </dl>
                        </div>
                    </li>

                    <li class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex-shrink-0"></div>
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">Yusuf Saif</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dt class="sr-only">Role</dt>
                                <dd class="text-gray-500 text-sm">Backend Development</dd>
                            </dl>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </main>
</x-layout>
<x-footer></x-footer>