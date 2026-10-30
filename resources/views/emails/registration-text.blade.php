Konfirmasi Pendaftaran Tiket Senja Suara

Halo, {{ $registration->name }}!

Pendaftaran tiket kamu sudah berhasil diterima.

Data pendaftar:
- Nama: {{ $registration->name }}
- Email: {{ $registration->email }}
- WhatsApp: {{ $registration->phone }}

Detail tiket:
- Jenis tiket: {{ $registration->ticket_type }}
- Jumlah: {{ $registration->quantity }}
- Total pembayaran: Rp{{ number_format($registration->total_amount, 0, ',', '.') }}

Simpan email ini sebagai bukti pendaftaran.

Salam,
Tim Senja Suara
