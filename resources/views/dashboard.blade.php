<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <x-application-logo class="block h-12 w-auto" />

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        ResumifyAI is a powerful web application leveraging OpenAI API to summarize user inputs. Simplify information absorption and boost your productivity.
                    </p>
                </div>

                <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                                <a>Dashboard</a>
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <p class="font-thin">Total Resumifies</p>
                                <h1 class="text-2xl mt-2 font-black">
                                    {{ $totalResumes }}
                                </h1>
                            </div>

                            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <p class="font-thin">Average Resumify  Length (Characters)</p>
                                <h1 class="text-2xl">
                                    {{ $averageLength ?: 0 }}
                                </h1>
                            </div>
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md mt-8">
                            <p class="font-thin">Latest Resumify (Last 7 Days)</p>
                            <h1 class="text-2xl">
                                {{ $resumesCount }}
                            </h1>
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md mt-8">
                            <p class="font-thin">Resumify Efficiency</p>
                            <h1 class="text-2xl">
                                {{ $efficiencyPercentage }}%
                            </h1>
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
            const remainingChars = 1000 - text.length;

            charCount.textContent = `${text.length}/1000 Characters`;

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
