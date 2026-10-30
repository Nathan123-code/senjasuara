<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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
            replyTo: array_filter([
                config('mail.reply_to.address')
                    ? new Address(
                        config('mail.reply_to.address'),
                        config('mail.reply_to.name')
                    )
                    : null,
            ]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->emailHtml(),
            text: 'emails.registration-text',
        );
    }

    private function emailHtml(): string
    {
        $name = e($this->registration->name);
        $email = e($this->registration->email);
        $phone = e($this->registration->phone);
        $ticketType = e(match ($this->registration->ticket_type) {
            'early-bird' => 'Early Bird',
            'presale' => 'Presale 2',
            'vip' => 'VIP Experience',
            default => $this->registration->ticket_type,
        });
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
<body style="margin:0;background-color:#f2efe9;color:#2a2a2a;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2efe9;padding:40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background-color:#fff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.08);">
                    <tr>
                        <td style="background-color:#2b193d;background-image:linear-gradient(135deg,#2b193d 0%,#823055 50%,#e2764b 100%);padding:50px 30px;text-align:center;">
                            <h1 style="color:#fff;margin:0;font-size:34px;font-weight:bold;letter-spacing:3px;text-transform:uppercase;">Senja Suara</h1>
                            <div style="width:50px;height:3px;background-color:#f9d371;margin:15px auto;"></div>
                            <p style="color:#f5e1c8;margin:0;font-size:13px;letter-spacing:4px;text-transform:uppercase;">Festival Musik 2024</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 35px;">
                            <h2 style="margin:0 0 15px;font-size:22px;color:#2b193d;">Halo, {$name}! &#127749;</h2>
                            <p style="margin:0 0 25px;font-size:15px;line-height:1.6;color:#5a5550;">
                                Terima kasih telah memilih untuk merayakan keindahan senja bersama kami. Pendaftaranmu telah sukses! Kami sudah mengamankan tempatmu untuk bernyanyi dan mengukir kenangan di bawah langit sore.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fff9f2;border-left:4px solid #e2764b;border-radius:8px;margin-bottom:30px;">
                                <tr>
                                    <td style="padding:20px 25px;">
                                        <p style="margin:0 0 15px;color:#e2764b;font-size:12px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;">Detail Pesananmu</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
                                            <tr>
                                                <td style="padding-bottom:10px;color:#7a7570;">Kategori Tiket</td>
                                                <td style="padding-bottom:10px;font-weight:bold;color:#2a2a2a;text-align:right;">{$ticketType}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:15px;color:#7a7570;">Jumlah Tiket</td>
                                                <td style="padding-bottom:15px;font-weight:bold;color:#2a2a2a;text-align:right;">{$quantity} Tiket</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-top:1px dashed #dcd5cc;padding-top:15px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#7a7570;font-weight:bold;">Total Pembayaran</td>
                                                <td style="font-weight:bold;color:#a94242;text-align:right;font-size:18px;">Rp{$totalAmount}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 15px;color:#2b193d;font-size:16px;font-weight:bold;">Data Pendaftar</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;color:#5a5550;margin-bottom:25px;">
                                <tr>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;">Nama Lengkap</td>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;font-weight:bold;color:#2a2a2a;text-align:right;">{$name}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;">Alamat Email</td>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;font-weight:bold;color:#2a2a2a;text-align:right;">{$email}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;">No. WhatsApp</td>
                                    <td style="padding:10px 0;border-bottom:1px solid #f2efe9;font-weight:bold;color:#2a2a2a;text-align:right;">{$phone}</td>
                                </tr>
                            </table>
                            <p style="margin:0;font-size:13px;line-height:1.5;color:#8a8580;text-align:center;background-color:#f7f5f0;padding:15px;border-radius:8px;">
                                &#128161; Harap simpan email ini dan tunjukkan saat penukaran gelang tiket di meja registrasi <em>venue</em>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#2b193d;padding:25px 30px;text-align:center;">
                            <p style="margin:0 0 8px;color:#fff;font-size:14px;font-weight:bold;">Sampai jumpa di Lapangan Renon, Bali!</p>
                            <p style="margin:0;color:#9c8aab;font-size:11px;letter-spacing:2px;">MUSIC &bull; FRIENDS &bull; MOMENTS</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
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
