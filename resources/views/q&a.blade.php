<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Q&A') }}
        </h2>
    </x-slot>

    <style>
        .tableWrapper {
            overflow-x:auto;
            overflow-x: scroll;
            width: 100%;
        }

    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                                <a>Q&A</a>
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <form method="POST" action="{{ route('QnA.store', ['redirect' => 'Q&A']) }}">
                                @csrf
                                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">

                                    <!-- Input -->
                                    <div class="flex flex-row">
                                        <div class="w-full p-8">
                                            <div>
                                                <label class="block font-medium text-md text-gray-700" for="input_text">
                                                    Question
                                                </label>
                                                <div class="mt-6 relative">
                                                    <textarea
                                                        name="input_text"
                                                        class="p-6 w-full border-gray-200 text-md focus:outline-none focus:ring-black shadow-sm mt-1 block"
                                                        id="input_text"
                                                        rows="4"
                                                        maxlength="200"
                                                        placeholder="What would you like to ask?">{{ session('input_text') }}</textarea>
                                                        <p id="char_count" class="text-sm text-black mt-2 bottom-0 left-0">0/200 Characters</p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="flex items-center justify-end px-4 py-3 bg-white text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">

                                    <div x-data="{ shown: false, timeout: null }"
                                        x-init="window.livewire.find('ktTV58Y40TMRKelpGBgr').on('saved', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000);  })"
                                        x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms=""
                                        style="display: none;" class="text-sm text-gray-600 mr-3"
                                        >
                                        Saved.
                                    </div>

                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 mb-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            wire:loading.attr="disabled"
                                            wire:target="photo"
                                        >
                                        Ask
                                    </button>
                                </div>
                            </form>
                            <div class="bg-white px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <h2 class="block font-medium text-md text-gray-700 mb-6">Answer</h2>
                                <hr class="mb-6">
                                @if(session()->has('answer'))
                                    @php
                                        $answer = session('answer');
                                        $answerText = trim(str_replace('Answer:', '', $answer));
                                    @endphp

                                    <p class="font-medium text-green-500">{{ $answerText }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center mb-4 mt-16">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                                <a>Question's Table</a>
                            </h2>
                        </div>
                        <div class="bg-white px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md mt-8">
                            <livewire:qn-a-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const textarea = document.getElementById('input_text');
        const charCount = document.getElementById('char_count');

        textarea.addEventListener('input', function() {
            const text = textarea.value;
            const remainingChars = 200 - text.length;

            charCount.textContent = `${text.length}/200 Characters`;

            if (remainingChars <= 100) {
                charCount.style.color = 'red';
            } else {
                charCount.style.color = 'black';
            }
        });

        // Trigger the input event on page load to update the character count
        textarea.dispatchEvent(new Event('input'));
    </script>

</x-app-layout>