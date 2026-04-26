<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Kasih Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login-regis.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body>

<!-- tampilan bagian kiri -->
<div class="auth-visual">
    <div class="visual-brand">
        <span class="logo-script">Kasih</span>
        <span class="logo-sans">Collection</span>
    </div>
    <p class="visual-tagline">Bergabunglah dan temukan koleksi terbaru kami.</p>
</div>

<!-- form register kanan -->
<div class="auth-panel">
    <div class="auth-card">

        <h1 class="auth-title">Buat Akun</h1>
        <p class="auth-subtitle">Daftar untuk mulai berbelanja</p>
        <div class="auth-divider"></div>

        @if($errors->any())
            <div class="auth-alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="field-group">
                <label class="field-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="field-input"
                       placeholder="Nama kamu" value="{{ old('name') }}" required>
            </div>

            <div class="field-group">
                <label class="field-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="field-input"
                       placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" class="field-input"
                           placeholder="Min. 8 karakter" required>
                    <button type="button" class="toggle-eye" onclick="togglePassword('password', this)">👁</button>
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="confirmPassword">Konfirmasi Password</label>
                <div class="password-wrap">
                    <input type="password" id="confirmPassword" name="password_confirmation"
                           class="field-input" placeholder="Ulangi password" required>
                    <button type="button" class="toggle-eye" onclick="togglePassword('confirmPassword', this)">👁</button>
                </div>
            </div>

            <button type="submit" class="btn-auth">Buat Akun</button>
        </form>

        <div class="auth-link-row">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

        <a href="/" class="btn-back">← Kembali ke Toko</a>

    </div>
</div>

</body>
</html>
