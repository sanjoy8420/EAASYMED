<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;

class AppointmentInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     */
    public function build()
{
    // Generate the PDF
    $pdf = PDF::loadView('invoices.appointment', ['appointment' => $this->appointment]);

    // Define email content directly
    $emailContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Appointment Invoice</title>
        </head>
        <body>
            <p>Dear {$this->appointment->name},</p>
            <p>Thank you for your payment. Please find your invoice attached.</p>
            <p>Regards,</p>
            <p>Easy Med Team</p>
        </body>
        </html>
    ";

    return $this->subject('Appointment Invoice')
        ->html($emailContent) // Directly use the email content as HTML
        ->attachData($pdf->output(), 'invoice_' . $this->appointment->id . '.pdf');
}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
