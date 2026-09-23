@extends('layouts.guest')

@section('title', 'Daftar')

@push('styles')
<style>
    .card-heading { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 26px; color: var(--text-primary); margin-bottom: 6px; }
    .card-subheading { color: var(--text-secondary); font-size: 14px; margin-bottom: 32px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: var(--text-secondary); letter-spacing: 0.03em; }
    .input-wrapper { position: relative; }
    .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 15px; pointer-events: none; opacity: 0.5; transition: opacity 0.2s; }
    .form-input {
        width: 100%; padding: 13px 16px 13px 44px;
        background: rgba(255,255,255,0.05); border: 1px solid var(--border);
        border-radius: 12px; color: var(--text-primary); font-family: 'Inter', sans-serif;
        font-size: 14px; outline: none;
        transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
    }
    .form-input::placeholder { color: var(--text-muted); }
    .form-input:focus {
        border-color: var(--border-active); background: rgba(108,99,255,0.06);
        box-shadow: 0 0 0 3px rgba(108,99,255,0.12);
    }
    .input-wrapper:focus-within .input-icon { opacity: 0.9; }
    .field-error { color: var(--error); font-size: 12px; margin-top: 6px; display: block; }
    .alert-error {
        background: var(--error-bg); border: 1px solid rgba(255,79,106,0.25);
        border-radius: 10px; padding: 12px 16px;
        color: #FF7A8F; font-size: 13px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 10px;
    }

    /* Password strength meter */
    .strength-bar { height: 4px; border-radius: 2px; margin-top: 8px; background: rgba(255,255,255,0.08); overflow: hidden; }
    .strength-fill { height: 100%; border-radius: 2px; width: 0; transition: width 0.4s ease, background 0.4s ease; }
    .strength-label { font-size: 11px; margin-top: 5px; }

    .btn-primary {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, var(--accent), #c94b7a);
        border: none; border-radius: 12px;
        color: #fff; font-family: 'Outfit', sans-serif;
        font-size: 15px; font-weight: 600;
        cursor: pointer; letter-spacing: 0.02em;
        transition: all 0.25s ease;
        box-shadow: 0 4px 20px rgba(255,107,157,0.35);
        margin-top: 8px;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,107,157,0.5); }
    .btn-primary:active { transform: translateY(0); }
    .login-prompt { text-align: center; font-size: 14px; color: var(--text-secondary); margin-top: 24px; }
    .login-prompt a { color: var(--primary-light); text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .login-prompt a:hover { color: #fff; }
</style>
@endpush

@section('content')
    <h1 class="card-heading">Buat Akun Baru ✨</h1>
    <p class="card-subheading">Mulai kelola menu restoran Anda hari ini</p>

    @if ($errors->any())
        <div class="alert-error" role="alert">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" novalidate>
        @csrf

        {{-- Name --}}
        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-wrapper">
                <span class="input-icon">👤</span>
                <input id="name" type="text" name="name" class="form-input"
                    value="{{ old('name') }}" placeholder="Nama Anda"
                    autocomplete="off" autofocus required>
            </div>
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="input-wrapper">
                <span class="input-icon">✉️</span>
                <input id="email" type="email" name="email" class="form-input"
                    value="{{ old('email') }}" placeholder="nama@contoh.com"
                    autocomplete="off" required>
            </div>
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <span class="input-icon">🔒</span>
                <input id="password" type="password" name="password" class="form-input"
                    placeholder="Min. 8 karakter (huruf besar, kecil, angka)"
                    autocomplete="off" required
                    oninput="checkStrength(this.value)">
            </div>
            <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
            <span class="strength-label" id="strength-label" style="color: var(--text-muted);"></span>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-wrapper">
                <span class="input-icon">🔑</span>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="form-input" placeholder="Ulangi password" autocomplete="off" required>
            </div>
        </div>

        <button type="submit" id="btn-register" class="btn-primary">
            Buat Akun Sekarang
        </button>
    </form>

    <p class="login-prompt">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </p>

    <script>
        function checkStrength(pw) {
            const fill  = document.getElementById('strength-fill');
            const label = document.getElementById('strength-label');
            let score = 0;
            if (pw.length >= 8)    score++;
            if (/[A-Z]/.test(pw))  score++;
            if (/[a-z]/.test(pw))  score++;
            if (/[0-9]/.test(pw))  score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            const levels = [
                { pct: '0%',   color: '',              text: '' },
                { pct: '20%',  color: '#FF4F6A',        text: '⚠️ Sangat lemah' },
                { pct: '40%',  color: '#FF9F47',        text: '🔸 Lemah' },
                { pct: '60%',  color: '#FFD447',        text: '🔹 Cukup' },
                { pct: '80%',  color: '#00D9A5',        text: '✅ Kuat' },
                { pct: '100%', color: '#6C63FF',        text: '🔥 Sangat kuat' },
            ];
            const l = levels[score];
            fill.style.width = l.pct;
            fill.style.background = l.color;
            label.textContent = l.text;
            label.style.color = l.color;
        }

        document.querySelector('form').addEventListener('submit', function () {
            const btn = document.getElementById('btn-register');
            btn.textContent = 'Membuat akun…';
            btn.disabled = true;
            btn.style.opacity = '0.8';
        });
    </script>
@endsection
