
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Recent Tickets') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6 flex justify-between flex-wrap text-gray-900 dark:text-gray-100">
                    
                    @forelse ($tickets as $ticket)
                        <div class="text-white w-40 border border-white">
                            <a href="{{ route('ticket.show', $ticket->id) }}">{{ $ticket->title }}
                                <p>{{ $ticket->updated_at->diffForHumans() }}</p>
                            </a>
                        </div>
                        
                    @empty
                        <p class="text-white">You don't have any ticket yet.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
