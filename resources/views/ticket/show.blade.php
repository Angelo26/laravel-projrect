
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ticket details') }}
            </h2>
        </div>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="text-white w-40">
                        
                        <p class="mb-4 text-center text-xl"> {{ $ticket->title }} </>
                        <p class="mb-4 ml-4 mr-4"> {{ $ticket->description }} </p>
                        @if($ticket->attachment)
                            <div class="mb-2 ml-4 underline">
                                <a href="{{ '/storage/'.$ticket->attachment }}" target="_blank">Atttachment</a>
                            </div>
                        @endif
                        @if(auth()->user()->checkAdmin or $ticket->user_id == auth()->user()->id)
                            <p class="ml-4 mb-2 text-right"> Status: {{ ucfirst($ticket->status) }} </p>
                        @endif

                        @if($ticket->created_at >= $ticket->updated_at)
                            <p class="text-right"> Created {{ $ticket->created_at->diffForHumans() }} </p>
                        @else
                        <p class="text-right"> Upadated {{ $ticket->updated_at->diffForHumans() }} </p>
                        @endif
                     </div>
                </div>
                <div class="flex w-full justify-end mt-4">
                    
                    @if(auth()->user()->checkAdmin)
                        <div>
                            <form class="ml-2" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="approved">
                                <x-primary-button>Approve</x-primary-button>
                            </form>
                        </div>
                        <div>
                            <form class="ml-2" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="rejected">
                                <x-danger-button>Reject</x-danger-button>
                            </form>  
                        </div>
                    @endif
                    @if(auth()->user()->checkAdmin or $ticket->user_id == auth()->user()->id)
                        <div class="ml-2">
                            <a href="{{ route('ticket.edit', $ticket->id) }}">
                                <x-primary-button>Edit</x-primary-button>
                            </a>
                        </div>
                        <div class="ml-2">
                            <form method="post" action="{{ route('ticket.destroy', $ticket->id) }}">
                                @method('delete')
                                @csrf
                                <x-danger-button>Delete</x-danger-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
