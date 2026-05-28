<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class WeeklyBranchDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $branchData;

    /**
     * Create a new message instance.
     */
    public function __construct($branchData)
    {
        $this->branchData = $branchData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Branch Data Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.branch_data_weekly',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.branch_data_weekly', ['branchData' => $this->branchData]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Laporan_Cabang.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
