@extends('layouts.guest')

@section('title', 'Masuk')

@push('styles')
<style>
    /* ─── Typography ─────────────────────────────────────────── */
    .card-heading { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 26px; color: var(--text-primary); margin-bottom: 6px; }
    .card-subheading { color: var(--text-secondary); font-size: 14px; margin-bottom: 32px; }

    /* ─── Form Fields ────────────────────────────────────────── */
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block; margin-bottom: 8px;
        font-size: 13px; font-weight: 500; color: var(--text-secondary);
        letter-spacing: 0.03em;
    }
    .input-wrapper { position: relative; }
    .input-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        font-size: 16px; pointer-events: none; opacity: 0.5; transition: opacity 0.2s;
    }
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
    .form-input:focus + .input-icon,
    .input-wrapper:focus-within .input-icon { opacity: 0.9; }
    .input-icon { left: auto; right: 14px; left: 14px; }

    /* toggle password */
    .toggle-pw {
        position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--text-muted);
        font-size: 16px; padding: 4px; transition: color 0.2s;
    }
    .toggle-pw:hover { color: var(--text-secondary); }

    /* ─── Error Alert ─────────────────────────────────────────── */
    .alert-error {
        background: var(--error-bg); border: 1px solid rgba(255,79,106,0.25);
        border-radius: 10px; padding: 12px 16px;
        color: #FF7A8F; font-size: 13px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 10px;
        animation: shake 0.4s ease;
    }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        20%,60% { transform: translateX(-6px); }
        40%,80% { transform: translateX(6px); }
    }
    .field-error { color: var(--error); font-size: 12px; margin-top: 6px; display: block; }

    /* ─── Remember + Forgot ──────────────────────────────────── */
    .row-between { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
    .checkbox-label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-secondary); cursor: pointer; }
    .checkbox-label input[type="checkbox"] { accent-color: var(--primary); width: 15px; height: 15px; cursor: pointer; }
    .link-subtle { font-size: 13px; color: var(--primary-light); text-decoration: none; transition: color 0.2s; }
    .link-subtle:hover { color: #fff; }

    /* ─── Submit Button ──────────────────────────────────────── */
    .btn-primary {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none; border-radius: 12px;
        color: #fff; font-family: 'Outfit', sans-serif;
        font-size: 15px; font-weight: 600;
        cursor: pointer; letter-spacing: 0.02em;
        transition: all 0.25s ease;
        box-shadow: 0 4px 20px rgba(108,99,255,0.35);
        position: relative; overflow: hidden;
    }
    .btn-primary::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        opacity: 0; transition: opacity 0.25s;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(108,99,255,0.5); }
    .btn-primary:hover::before { opacity: 1; }
    .btn-primary:active { transform: translateY(0); }

    /* ─── Divider ────────────────────────────────────────────── */
    .divider { display: flex; align-items: center; gap: 12px; margin: 28px 0; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
    .divider span { font-size: 12px; color: var(--text-muted); white-space: nowrap; }

    /* ─── Register Link ──────────────────────────────────────── */
    .register-prompt { text-align: center; font-size: 14px; color: var(--text-secondary); }
    .register-prompt a {
        color: var(--primary-light); text-decoration: none; font-weight: 500;
        transition: color 0.2s;
    }
    .register-prompt a:hover { color: #fff; }
</style>
@endpush

@section('content')
    <h1 class="card-heading">Selamat Datang Kembali 👋</h1>
    <p class="card-subheading">Masuk untuk mengelola menu restoran Anda</p>

    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="alert-error" role="alert">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" novalidate>
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="input-wrapper">
                <span class="input-icon">✉️</span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-input"
                    value="{{ old('email') }}"
                    placeholder="nama@contoh.com"
                    autocomplete="email"
                    autofocus
                    required
                >
            </div>
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <span class="input-icon">🔒</span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Tampilkan password" id="toggle-pw-btn">
                    👁️
                </button>
            </div>
            @error('password')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="row-between">
            <label class="checkbox-label" for="remember">
                <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Ingat saya
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" id="btn-login" class="btn-primary">
            Masuk ke Dashboard
        </button>
    </form>

    <div class="divider"><span>Belum punya akun?</span></div>

    <p class="register-prompt">
        <a href="{{ route('register') }}">Daftar sekarang — gratis</a>
    </p>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn   = document.getElementById('toggle-pw-btn');
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁️';
            }
        }

        // Button loading state
        document.querySelector('form').addEventListener('submit', function () {
            const btn = document.getElementById('btn-login');
            btn.textContent = 'Memproses…';
            btn.disabled = true;
            btn.style.opacity = '0.8';
        });
    </script>
@endsection
