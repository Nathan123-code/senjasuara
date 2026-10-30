<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Registration $registration) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran Tiket Senja Suara',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->emailHtml(),
        );
    }

    private function emailHtml(): string
    {
        $name = e($this->registration->name);
        $email = e($this->registration->email);
        $phone = e($this->registration->phone);
        $ticketType = e($this->registration->ticket_type);
        $quantity = e((string) $this->registration->quantity);
        $totalAmount = e(number_format($this->registration->total_amount, 0, ',', '.'));

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran Tiket</title>
</head>
<body style="margin:0;background:#f4efe8;color:#292521;font-family:Arial,sans-serif;">
    <div style="max-width:620px;margin:0 auto;padding:32px 16px;">
        <div style="background:#292521;border-radius:20px 20px 0 0;padding:28px 32px;color:#fff;">
            <p style="margin:0 0 8px;color:#f5b47b;font-size:12px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">
                Senja Suara Festival
            </p>
            <h1 style="margin:0;font-size:28px;">Pendaftaran Berhasil</h1>
        </div>
        <div style="background:#fff;border-radius:0 0 20px 20px;padding:32px;">
            <p style="margin-top:0;font-size:18px;">Halo, <strong>{$name}</strong>!</p>
            <p>Terima kasih. Pendaftaran tiket kamu sudah berhasil diterima.</p>

            <h2 style="margin-top:28px;font-size:18px;">Data pendaftar</h2>
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="padding:8px 0;color:#756e66;">Nama</td><td style="padding:8px 0;text-align:right;">{$name}</td></tr>
                <tr><td style="padding:8px 0;color:#756e66;">Email</td><td style="padding:8px 0;text-align:right;">{$email}</td></tr>
                <tr><td style="padding:8px 0;color:#756e66;">WhatsApp</td><td style="padding:8px 0;text-align:right;">{$phone}</td></tr>
            </table>

            <h2 style="margin-top:28px;font-size:18px;">Detail tiket</h2>
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="padding:8px 0;color:#756e66;">Jenis tiket</td><td style="padding:8px 0;text-align:right;">{$ticketType}</td></tr>
                <tr><td style="padding:8px 0;color:#756e66;">Jumlah</td><td style="padding:8px 0;text-align:right;">{$quantity}</td></tr>
                <tr><td style="padding:12px 0;border-top:1px solid #eee;color:#756e66;">Total pembayaran</td><td style="padding:12px 0;border-top:1px solid #eee;text-align:right;font-size:18px;font-weight:bold;">Rp{$totalAmount}</td></tr>
            </table>

            <p style="margin-bottom:0;">Simpan email ini sebagai bukti pendaftaran.</p>
        </div>
        <p style="color:#756e66;font-size:12px;text-align:center;">Salam, Tim Senja Suara</p>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
