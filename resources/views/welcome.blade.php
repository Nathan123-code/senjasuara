<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Daftar tiket untuk konser Senja Suara Festival.">
        <title>Senja Suara Festival — Form Pendaftaran Tiket</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main class="page-shell">
            <header class="site-header">
                <a class="brand" href="{{ url('/') }}" aria-label="Senja Suara Festival">
                    <span class="brand-mark">SS</span>
                    <span>Senja Suara</span>
                </a>
                <a class="header-link" href="#detail-acara">Detail acara <span aria-hidden="true">↗</span></a>
            </header>

            <section class="hero" id="detail-acara">
                <div class="hero-copy">
                    <div class="eyebrow"><span class="live-dot"></span> Pendaftaran dibuka</div>
                    <h1>Feel the Sound.<br><em>Absolute Cinema.</em></h1>
                    <p class="hero-description">Rayakan musik, teman, dan momen yang tidak akan terulang di festival musik paling hangat tahun ini.</p>

                    <div class="event-meta">
                        <div class="meta-item">
                            <span class="meta-icon" aria-hidden="true">✦</span>
                            <div><small>Tanggal</small><strong>Sabtu, 24 Agustus 2024</strong></div>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon" aria-hidden="true">⌖</span>
                            <div><small>Lokasi</small><strong>Lapangan Renon, Bali</strong></div>
                        </div>
                    </div>

                    <div class="artist-strip">
                        <span>Line up pilihan</span>
                        <strong>Hindia</strong><i></i><strong>Raisa</strong><i></i><strong>Reality Club</strong>
                    </div>
                </div>

                <div class="registration-card" id="daftar">
                    <div class="card-heading">
                        <div>
                            <span class="card-kicker">Amankan tempatmu</span>
                            <h2>Daftar sekarang</h2>
                        </div>
                        <span class="step-badge">01 <span>/ 01</span></span>
                    </div>

                    @if (session('success'))
                        <p role="status">{{ session('success') }}</p>
                    @endif

                    <form method="POST" action="{{ route('registrations.store') }}">
                        @csrf
                        <div id="saved-identity" class="saved-identity" hidden>
                            <p>Data pendaftar terakhir tersedia di perangkat ini.</p>
                            <button type="button" id="use-saved-identity">Gunakan data terakhir</button>
                            <button type="button" id="clear-saved-identity">Hapus data tersimpan</button>
                        </div>
                        <div class="field-grid">
                            <label class="field full-field">
                                <span>Nama lengkap</span>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Naya Putri" autocomplete="name" required>
                                @error('name')<small class="field-error">{{ $message }}</small>@enderror
                            </label>
                            <label class="field">
                                <span>Email aktif</span>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="naya@email.com" autocomplete="email" required>
                                @error('email')<small class="field-error">{{ $message }}</small>@enderror
                            </label>
                            <label class="field">
                                <span>Nomor WhatsApp</span>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xx xxxx xxxx" autocomplete="tel" required>
                                @error('phone')<small class="field-error">{{ $message }}</small>@enderror
                            </label>
                        </div>

                        <fieldset class="ticket-options">
                            <legend>Pilih jenis tiket</legend>
                            <label class="ticket-option">
                                <input type="radio" name="ticket_type" value="early-bird" data-price="150000" @checked(old('ticket_type', 'early-bird') === 'early-bird')>
                                <span class="ticket-content"><strong>Early Bird</strong><small>Terbatas • Akses festival</small></span>
                                <span class="ticket-price">Rp150K</span>
                            </label>
                            <label class="ticket-option">
                                <input type="radio" name="ticket_type" value="presale" data-price="250000" @checked(old('ticket_type') === 'presale')>
                                <span class="ticket-content"><strong>Presale 2</strong><small>Akses festival + lanyard</small></span>
                                <span class="ticket-price">Rp250K</span>
                            </label>
                            <label class="ticket-option">
                                <input type="radio" name="ticket_type" value="vip" data-price="500000" @checked(old('ticket_type') === 'vip')>
                                <span class="ticket-content"><strong>VIP Experience</strong><small>Fast lane + area eksklusif</small></span>
                                <span class="ticket-price">Rp500K</span>
                            </label>
                        </fieldset>

                        <div class="form-footer">
                            <label class="quantity-control">
                                <span>Jumlah</span>
                                <span class="quantity-input">
                                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="10" required aria-label="Jumlah tiket">
                                </span>
                            </label>
                            <div class="total">
                                <span>Total pembayaran</span>
                                <strong id="total-price">Rp150.000</strong>
                            </div>
                        </div>

                        <label class="consent">
                            <input type="checkbox" name="consent" value="1" required @checked(old('consent'))>
                            <span>Saya menyetujui <a href="#syarat">syarat &amp; ketentuan</a> pendaftaran.</span>
                        </label>
                        <label class="remember-identity">
                            <input type="checkbox" id="remember-identity" name="remember_identity" value="1">
                            <span>Ingat nama, email, dan nomor WhatsApp saya di perangkat ini</span>
                        </label>
                        @error('ticket_type')<small class="field-error">{{ $message }}</small>@enderror
                        @error('quantity')<small class="field-error">{{ $message }}</small>@enderror
                        @error('consent')<small class="field-error">{{ $message }}</small>@enderror
                        <button class="submit-button" type="submit">Lanjut ke pembayaran <span aria-hidden="true">→</span></button>
                    </form>
                </div>
            </section>

            <footer class="page-footer">
                <span>© 2024 Senja Suara Festival</span>
                <span class="footer-note"><span class="secure-icon">✓</span> Pembayaran aman &amp; terpercaya</span>
            </footer>
        </main>
    </body>
</html>
