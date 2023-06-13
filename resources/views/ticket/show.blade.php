
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

                        @if($ticket->created_at >= $ticket->updated_at)
                            <p class="text-right"> Created {{ $ticket->created_at->diffForHumans() }} </p>
                        @else
                        <p class="text-right"> Upadated {{ $ticket->updated_at->diffForHumans() }} </p>
                        @endif
                     </div>
                </div>
                <div class="flex w-full justify-end mt-4">
                    <div class="mr-4">
                        <a href="{{ route('ticket.edit', $ticket->id) }}">
                            <x-primary-button>Edit</x-primary-button>
                        </a>
                    </div>
                    <div class="ml-4">
                        <form method="post" action="{{ route('ticket.destroy', $ticket->id) }}">
                            @method('delete')
                            @csrf
                            <x-danger-button>Delete</x-danger-button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
