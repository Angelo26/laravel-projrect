
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
                        <div>
                            <a href="{{ route('ticket.show', $ticket->id) }}">
                                <div class="text-white p-4 border border-white">
                                    <p>{{ $ticket->title }}</p>
                                    <p>{{ $ticket->updated_at->diffForHumans() }}</p>
                                    <p>Status: {{ $ticket->status }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="w-full flex justify-center">
                            <p class="text-white">You haven't created any ticket yet.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
