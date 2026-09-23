<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Menu — Sistem manajemen menu restoran modern">
    <title>@yield('title', 'My Menu') — Sistem Manajemen Menu</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6C63FF;
            --primary-light: #8B85FF;
            --primary-dark: #5046E4;
            --accent: #FF6B9D;
            --bg-deep: #0A0A1A;
            --bg-card: rgba(255, 255, 255, 0.04);
            --border: rgba(255, 255, 255, 0.08);
            --border-active: rgba(108, 99, 255, 0.5);
            --text-primary: #F0F0FF;
            --text-secondary: #9090B0;
            --text-muted: #5A5A7A;
            --success: #00D9A5;
            --error: #FF4F6A;
            --error-bg: rgba(255, 79, 106, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(108, 99, 255, 0.15) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(255, 107, 157, 0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(0, 217, 165, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        .orb {
            position: fixed; border-radius: 50%; filter: blur(80px);
            opacity: 0.35; pointer-events: none; z-index: 0;
            animation: floatOrb 8s ease-in-out infinite;
        }
        .orb-1 { width: 450px; height: 450px; background: var(--primary); top: -180px; left: -120px; animation-delay: 0s; }
        .orb-2 { width: 350px; height: 350px; background: var(--accent); bottom: -120px; right: -80px; animation-delay: 3s; }
        .orb-3 { width: 220px; height: 220px; background: var(--success); top: 45%; left: 58%; animation-delay: 1.5s; }
        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%  { transform: translate(20px, -30px) scale(1.05); }
            66%  { transform: translate(-10px, 20px) scale(0.97); }
        }
        .grid-overlay {
            position: fixed; inset: 0;
            background-image: linear-gradient(rgba(108,99,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(108,99,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px; pointer-events: none; z-index: 0;
        }
        .auth-wrapper {
            position: relative; z-index: 10; width: 100%;
            padding: 24px; display: flex; flex-direction: column; align-items: center;
        }
        .brand {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 32px; text-decoration: none;
        }
        .brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 26px;
            box-shadow: 0 0 28px rgba(108,99,255,0.45);
        }
        .brand-name {
            font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 28px;
            background: linear-gradient(135deg, #fff 0%, #a8a4ff 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .auth-card {
            width: 100%; max-width: 460px;
            background: var(--bg-card);
            backdrop-filter: blur(32px); -webkit-backdrop-filter: blur(32px);
            border: 1px solid var(--border); border-radius: 24px; padding: 44px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.45), 0 0 0 1px rgba(255,255,255,0.03) inset, 0 1px 0 rgba(255,255,255,0.08) inset;
            animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .auth-footer { margin-top: 24px; color: var(--text-muted); font-size: 13px; text-align: center; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="grid-overlay"></div>

    <div class="auth-wrapper">
        <a href="{{ route('login') }}" class="brand">
            <div class="brand-icon">🍽️</div>
            <span class="brand-name">My Menu</span>
        </a>

        <div class="auth-card">
            @yield('content')
        </div>

        <p class="auth-footer">&copy; {{ date('Y') }} My Menu. Semua hak dilindungi.</p>
    </div>
</body>
</html>
