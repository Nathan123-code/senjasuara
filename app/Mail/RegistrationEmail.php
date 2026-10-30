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
<body style="margin:0;background:#eeeae3;color:#292521;font-family:Arial,Helvetica,sans-serif;">
    <div style="width:100%;background:#eeeae3;padding:42px 12px;box-sizing:border-box;">
        <table role="presentation" style="width:100%;max-width:640px;margin:0 auto;border-spacing:0;">
            <tr>
                <td style="padding:0 0 16px;">
                    <table role="presentation" style="width:100%;border-spacing:0;background:#20251f;border-radius:22px 22px 0 0;overflow:hidden;">
                        <tr>
                            <td style="padding:34px 38px 38px;background:#20251f;color:#fff;">
                                <div style="margin-bottom:34px;color:#d9a86c;font-size:11px;font-weight:bold;letter-spacing:3px;text-transform:uppercase;">
                                    Senja Suara &nbsp;•&nbsp; 2024
                                </div>
                                <div style="width:48px;height:4px;margin-bottom:20px;background:#d9a86c;"></div>
                                <h1 style="margin:0;color:#fff;font-size:36px;font-weight:400;line-height:1.12;letter-spacing:-1px;">
                                    Kamu resmi<br><em style="color:#e8c89c;">terdaftar.</em>
                                </h1>
                                <p style="margin:20px 0 0;color:#b8beb4;font-size:14px;line-height:1.6;">
                                    Simpan email ini sebagai bukti pendaftaranmu di festival.
                                </p>
                            </td>
                            <td style="width:92px;padding:0;vertical-align:bottom;text-align:right;">
                                <div style="padding:0 28px 28px 0;color:#d9a86c;font-size:54px;line-height:1;">✦</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 16px;">
                    <table role="presentation" style="width:100%;border-spacing:0;background:#fff;border-radius:0 0 22px 22px;box-shadow:0 18px 45px rgba(41,37,33,.08);">
                        <tr>
                            <td style="padding:34px 38px 12px;">
                                <p style="margin:0 0 8px;color:#8c857c;font-size:11px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">Halo, {$name}</p>
                                <p style="margin:0;color:#292521;font-size:20px;line-height:1.4;">Terima kasih sudah memilih untuk <strong>merasakan senja bersama kami.</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:22px 38px 10px;">
                                <table role="presentation" style="width:100%;border-spacing:0;border:1px solid #e7dfd3;border-radius:14px;overflow:hidden;">
                                    <tr>
                                        <td style="padding:18px 20px;background:#f8f3ec;color:#8c6b43;font-size:11px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">Detail tiket</td>
                                        <td style="padding:18px 20px;background:#f8f3ec;color:#8c6b43;font-size:11px;text-align:right;">Senja Suara Festival</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:20px;color:#756e66;font-size:13px;border-top:1px solid #e7dfd3;">Jenis tiket</td>
                                        <td style="padding:20px;color:#292521;font-size:15px;font-weight:bold;text-align:right;border-top:1px solid #e7dfd3;">{$ticketType}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 20px 20px;color:#756e66;font-size:13px;">Jumlah tiket</td>
                                        <td style="padding:0 20px 20px;color:#292521;font-size:15px;font-weight:bold;text-align:right;">{$quantity}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:18px 20px;border-top:1px dashed #d9cdbd;color:#756e66;font-size:13px;">Total pembayaran</td>
                                        <td style="padding:18px 20px;border-top:1px dashed #d9cdbd;color:#b56e3b;font-size:20px;font-weight:bold;text-align:right;">Rp{$totalAmount}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:20px 38px 36px;">
                                <p style="margin:0 0 14px;color:#8c857c;font-size:11px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">Data pendaftar</p>
                                <table role="presentation" style="width:100%;border-spacing:0;">
                                    <tr><td style="padding:7px 0;color:#8c857c;font-size:13px;">Nama</td><td style="padding:7px 0;color:#292521;font-size:13px;text-align:right;">{$name}</td></tr>
                                    <tr><td style="padding:7px 0;color:#8c857c;font-size:13px;">Email</td><td style="padding:7px 0;color:#292521;font-size:13px;text-align:right;">{$email}</td></tr>
                                    <tr><td style="padding:7px 0;color:#8c857c;font-size:13px;">WhatsApp</td><td style="padding:7px 0;color:#292521;font-size:13px;text-align:right;">{$phone}</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:12px 20px 0;text-align:center;">
                    <p style="margin:0;color:#8c857c;font-size:12px;line-height:1.7;">Sampai jumpa di Lapangan Renon, Bali.<br><strong style="color:#292521;">Salam hangat, Tim Senja Suara</strong></p>
                    <p style="margin:22px 0 0;color:#aaa39a;font-size:10px;letter-spacing:1px;">MUSIC &nbsp;•&nbsp; FRIENDS &nbsp;•&nbsp; MOMENTS</p>
                </td>
            </tr>
        </table>
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
