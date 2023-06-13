<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user    = auth()->user();
        $tickets = Ticket::latest()->get();
        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([ 
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => auth()->id(),
        ]);

        if($request->file('attachment')){
            $path = Storage::disk('public')->put('attachments', $request->file('attachment'));
            $ticket->update(['attachment' => $path]);
        }
        return redirect()->route('ticket.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
    
        $statusValid = array('approved', 'rejected');
        if(in_array($request->status, $statusValid)){
            if(auth()->user()->checkAdmin){
                $ticket->update(['status' => $request->status]);
                return redirect()->back();
            }
        }
        else{
            $ticket->update($request->except('attachment'));
            if($request->file('attachment')){
                if($currentAttachment = $ticket->attachment){
                    Storage::disk('public')->delete($currentAttachment);
                }
                $path = Storage::disk('public')->put('attachments', $request->file('attachment'));
                $ticket->update(['attachment' => $path]);
            }
            return redirect()->route('ticket.show', compact('ticket'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('ticket.index');
    }

    public function verify()
    {
        $tickets = Ticket::latest()->get();
        return view('ticket.verify', compact('tickets'));
    }
}
