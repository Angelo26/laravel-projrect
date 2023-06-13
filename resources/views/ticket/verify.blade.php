@if(auth()->user()->checkAdmin)
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Verify Tickets') }}
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-full p-6 flex justify-between flex-wrap text-gray-900 dark:text-gray-100">
                        
                        @forelse ($tickets as $ticket)
                            <div>
                                
                                <div class="text-white p-4 border border-white">
                                    <p>{{ $ticket->title }}</p>
                                    <p>{{ $ticket->updated_at->diffForHumans() }}</p>

                                    <div class="flex">
                                        <form class="m-2" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="approved">
                                            <x-primary-button>Approve</x-primary-button>
                                        </form>
                                        <form class="ml-2" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="rejected">
                                            <x-danger-button>Reject</x-danger-button>
                                        </form>
                                            
                                    </div>
                                </div>
                                    <a href="{{ route('ticket.show', $ticket->id) }}"></a>
                            </div>
                        @empty
                            <div class="w-full flex justify-center">
                                <p class="text-white">No ticket found.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout> 
@else
    <script>window.location = "{{ route('ticket.index') }}";</script>
@endif

