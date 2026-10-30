# Senja Suara Festival

Senja Suara Festival adalah website pendaftaran tiket konser yang dibuat menggunakan Laravel. Website ini menyediakan halaman pendaftaran dengan tampilan sederhana dan responsif sehingga pengunjung dapat mendaftarkan diri dengan mudah.

Fitur utama website ini adalah form pendaftaran tiket yang meminta nama lengkap, alamat email, nomor WhatsApp, jenis tiket, dan jumlah tiket. Pengunjung dapat memilih jenis tiket Early Bird, Presale 2, atau VIP Experience. Sistem akan menghitung total pembayaran secara otomatis berdasarkan jenis dan jumlah tiket yang dipilih.

Data pendaftaran yang dikirim oleh pengunjung akan divalidasi dan disimpan ke dalam database. Setelah pendaftaran berhasil, sistem akan mengirimkan email konfirmasi kepada alamat email pendaftar. Email tersebut berisi data pendaftar dan detail tiket yang dipilih.

Project ini menggunakan Laravel, PHP, Blade, Tailwind CSS, Vite, dan database yang didukung oleh Laravel. Aplikasi dapat dijalankan secara lokal menggunakan `php artisan serve` dan dapat dikonfigurasi untuk mengirim email melalui layanan SMTP.
