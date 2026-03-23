<div>
  <div class="fixed bottom-4 right-4 z-50">
        <button wire:click="toggleChat"
                class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-lg transition duration-300 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.97 2.887a1 1 0 00-.364 1.118l1.519 4.674c.3.921-.755 1.688-1.54 1.118l-3.97-2.887a1 1 0 00-1.176 0l-3.97 2.887c-.784.57-1.838-.197-1.54-1.118l1.519-4.674a1 1 0 00-.364-1.118L2.012 9.4c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"></path>
            </svg>
        </button>

        <div x-show="$wire.isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="absolute bottom-16 right-0 w-80 h-[28rem] bg-white rounded-lg shadow-xl flex flex-col overflow-hidden">

            <div class="bg-indigo-600 text-white p-3 flex justify-between items-center">
                <h3 class="text-lg font-semibold">MerryMouse😁</h3>
                <div class="flex items-center space-x-3">
                    <button wire:click="clearChat" class="text-white hover:text-indigo-200" title="Clear Chat">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                    <button wire:click="toggleChat" class="text-white hover:text-indigo-200" title="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="chat-messages" class="flex-grow p-4 space-y-4 overflow-y-auto">
                @foreach ($messages as $message)
                    @if ($message['role'] === 'assistant')
                        <div class="flex justify-start">
                            <div class="bg-gray-100 rounded-lg p-3 max-w-[85%] text-sm text-gray-800 whitespace-pre-wrap prose prose-sm leading-relaxed">
                                @markdown($message['content'])
                            </div>
                        </div>
                    @else
                        <div class="flex justify-end">
                            <div class="bg-indigo-500 text-white rounded-lg p-3 max-w-[85%] text-sm">
                                {{ $message['content'] }}
                            </div>
                        </div>
                    @endif
                @endforeach

                <div wire:loading.flex wire:target="sendMessage" class="w-full justify-start">
                    <div class="bg-gray-100 rounded-lg p-3 max-w-[85%] text-sm text-gray-800 leading-relaxed flex items-center">
                        {{-- Livewire will magically append text chunks to this span --}}
                        <span wire:stream="bot-reply"></span>

                        {{-- A cool blinking cursor to show it's actively typing --}}
                        <span class="animate-pulse inline-block w-1.5 h-4 bg-indigo-400 ml-1 translate-y-0.5"></span>
                    </div>
                </div>
            </div>

            @if(count($messages) <= 1)
                <div x-data
                    x-on:wheel.prevent="$el.scrollLeft += $event.deltaY"
                    class="w-full max-w-full overflow-x-auto elegant-scrollbar bg-gray-50 border-t border-gray-200 px-3 py-2 shrink-0">

                    <div class="flex flex-nowrap gap-2 w-max">
                        @foreach($suggestedPrompts as $question => $answer)
                            <button type="button"
                                    wire:click="sendPredefinedMessage('{{ addslashes($question) }}')"
                                    class="shrink-0 whitespace-nowrap bg-white border border-indigo-200 text-indigo-600 hover:bg-indigo-50 hover:border-indigo-300 text-xs px-3 py-1.5 rounded-full transition-colors duration-150 shadow-sm disabled:opacity-50"
                                    wire:loading.attr="disabled">
                                {{ $question }}
                            </button>
                        @endforeach
                    </div>

                </div>
            @endif

            <div class="shrink-0 p-3 bg-gray-50 border-t border-gray-200">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <input type="text"
                        wire:model="userInput"
                        placeholder="Type your message..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 disabled:bg-gray-100"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage">

                    <button type="submit"
                            class="bg-indigo-600 text-white p-2 rounded-lg hover:bg-indigo-700 transition duration-150 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                            wire:target="sendMessage">
                        <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
    .elegant-scrollbar::-webkit-scrollbar {
        height: 6px; /* Very thin */
    }
    .elegant-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .elegant-scrollbar::-webkit-scrollbar-thumb {
        background-color: #c7d2fe; /* Tailwind indigo-200 */
        border-radius: 10px;
    }
    .elegant-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #818cf8; /* Tailwind indigo-400 */
    }
    </style>

    <script>
    document.addEventListener('livewire:initialized', () => {
        const chatWindow = document.getElementById('chat-messages');

        const scroll = () => {
            if (chatWindow && document.querySelector('[x-show]').style.display !== 'none') {
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        };

        // Scroll when Livewire natively updates the DOM
        Livewire.hook('morph.updated', ({ component }) => {
            if (component.name === 'chatbot') {
                scroll();
            }
        });

        Livewire.on('messages-updated', scroll);
        scroll();

        // NEW: This watches the chat window for changes during the live stream
        // and forces the scrollbar to stay at the bottom as new words appear!
        if (chatWindow) {
            const observer = new MutationObserver(() => {
                // Only auto-scroll if the user hasn't manually scrolled up to read history
                if (chatWindow.scrollHeight - chatWindow.scrollTop <= chatWindow.clientHeight + 100) {
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                }
            });

            // Watch for new text nodes being added by the stream
            observer.observe(chatWindow, { childList: true, subtree: true, characterData: true });
        }
    });
    </script>
</div>
