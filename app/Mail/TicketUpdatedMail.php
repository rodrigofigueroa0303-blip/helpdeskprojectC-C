<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public string $messageLine;

    public function __construct(Ticket $ticket, string $messageLine)
    {
        $this->ticket = $ticket;
        $this->messageLine = $messageLine;
    }

    public function build()
    {
        return $this
            ->subject('Actualizacion de Ticket: ' . $this->ticket->subject)
            ->markdown('emails.tickets.updated', [
                'ticket' => $this->ticket,
                'messageLine' => $this->messageLine,
            ]);
    }
}