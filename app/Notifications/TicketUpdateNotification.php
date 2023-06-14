<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdateNotification extends Notification
{
    use Queueable;

    public $ticket;
    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if($this->ticket->status == 'approved'){
            $line = 'Now, everyone can see your ticket.';
        }
        elseif($this->ticket->status == 'rejected'){
            $line = 'Please see through the rules and edit your ticket for further verification.';
        }
        $recieverName = ucfirst($notifiable->name);
        return (new MailMessage)
                    ->greeting("Hello! {$recieverName},")
                    ->line('Your ticket has been '.$this->ticket->status.'. '.$line)
                    ->action('Click here to see your Ticket', route('ticket.show', $this->ticket->id))
                    ->line('Thank you for using iTicket!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
