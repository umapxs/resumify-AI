<div>
    <div>
        <div class="w-full flex pb-10">
            {{-- <div class="w-3/6 mx-1">
                <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search users...">
            </div> --}}
            {{-- <div class="w-1/6 relative mx-1">
                <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="id">ID</option>
                    <option value="name">Question</option>
                    <option value="email">Answer</option>
                    <option value="created_at">Date</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div> --}}
            {{-- <div class="w-1/6 relative mx-1">
                <select wire:model="orderAsc" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="1">Ascending</option>
                    <option value="0">Descending</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div> --}}
            {{-- <div class="w-1/6 relative mx-1">
                <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div> --}}
        </div>
        <div class="tableWrapper">
            <table class="table-auto w-full mb-6">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Resumify</th>
                        <th class="px-4 py-2">English</th>
                        <th class="px-4 py-2">Portuguese</th>
                        <th class="px-4 py-2">Spanish</th>
                        {{-- <th class="px-4 py-2">Created At</th> --}}
                    </tr>
                </thead>
                <tbody>

                    @if($resumes->isEmpty() || $resumes->where('user_id', auth()->id())->isEmpty())
                        <tr>
                            <td colspan="4" class="border px-4 py-2 text-center">No Resumify records found.</td>
                        </tr>
                    @else
                        @foreach($resumes as $resume)
                            @if($resume->user_id === auth()->id())
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $resume->summarized }}</td>
                                    <td class="border px-4 py-2">{{ $resume->english_summarized }}</td>
                                    <td class="border px-4 py-2">{{ $resume->portuguese_summarized }}</td>
                                    <td class="border px-4 py-2">{{ $resume->spanish_summarized }}</td>
                                    <td class="border px-4 py-2">{{ $resume->created_at->diffForHumans() }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {!! $resumes->links() !!}
        </div>
    </div>
</div>
