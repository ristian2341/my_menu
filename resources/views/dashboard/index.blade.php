<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard — My Menu Sistem Manajemen Menu">
    <title>Dashboard — My Menu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════════════
           DESIGN TOKENS
        ═══════════════════════════════════════════════════════ */
        :root {
            --primary:        #6C63FF;
            --primary-light:  #8B85FF;
            --primary-dark:   #5046E4;
            --accent:         #FF6B9D;
            --success:        #00D9A5;
            --warning:        #FFB647;
            --danger:         #FF4F6A;
            --bg-deep:        #0A0A1A;
            --bg-card:        rgba(255,255,255,0.04);
            --bg-card-hover:  rgba(255,255,255,0.08);
            --border:         rgba(255,255,255,0.07);
            --border-accent:  rgba(108,99,255,0.25);
            --text-primary:   #F0F0FF;
            --text-secondary: #9090B0;
            --text-muted:     #5A5A7A;
            --topbar-h:       64px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Subtle background texture */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 15% 10%, rgba(108,99,255,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 85% 85%, rgba(255,107,157,0.06) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }

        /* ═══════════════════════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════════════════════ */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            height: var(--topbar-h);
            display: flex; align-items: center;
            padding: 0 28px;
            background: rgba(10,10,26,0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            gap: 16px;
        }

        /* Glow line */
        .topbar::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(108,99,255,0.3) 30%, rgba(255,107,157,0.2) 70%, transparent 100%);
        }

        /* Brand in topbar */
        .topbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex-shrink: 0;
        }
        .topbar-brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 16px rgba(108,99,255,0.35);
        }
        .topbar-brand-name {
            font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 18px;
            background: linear-gradient(135deg, #fff, #a8a4ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Divider */
        .topbar-divider {
            width: 1px; height: 24px;
            background: var(--border);
            flex-shrink: 0;
        }

        /* Page title */
        .topbar-title {
            font-family: 'Outfit', sans-serif;
            font-size: 16px; font-weight: 600;
            color: var(--text-secondary);
        }

        .topbar-spacer { flex: 1; }

        .topbar-actions { display: flex; align-items: center; gap: 10px; }

        /* Icon button */
        .btn-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
            position: relative;
            color: var(--text-secondary);
        }
        .btn-icon:hover { background: var(--bg-card-hover); border-color: var(--border-accent); }
        .btn-icon .dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--accent); border-radius: 50%;
            border: 1.5px solid var(--bg-deep);
        }

        /* User pill in topbar */
        .topbar-user {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px 6px 6px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 40px;
            cursor: default;
        }
        .topbar-user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .topbar-user-name { font-size: 13px; font-weight: 500; color: var(--text-secondary); }

        /* Logout button */
        .btn-logout {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 14px;
            background: rgba(255,79,106,0.08);
            border: 1px solid rgba(255,79,106,0.2);
            border-radius: 10px;
            color: #FF7A8F; font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: rgba(255,79,106,0.18); color: #fff; }

        /* ═══════════════════════════════════════════════════════
           WINDOWS-STYLE POPUP MENU
        ═══════════════════════════════════════════════════════ */

        /* Trigger button */
        .btn-menu-trigger {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 14px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-secondary);
            font-size: 13px; font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        .btn-menu-trigger:hover,
        .btn-menu-trigger.active {
            background: rgba(108,99,255,0.12);
            border-color: var(--border-accent);
            color: var(--text-primary);
            box-shadow: 0 0 16px rgba(108,99,255,0.15);
        }
        .trigger-icon { font-size: 16px; }
        .trigger-arrow {
            font-size: 10px; margin-left: 2px;
            transition: transform 0.25s ease;
            display: inline-block;
        }
        .btn-menu-trigger.active .trigger-arrow { transform: rotate(180deg); }

        /* Popup container */
        .win-menu-popup {
            position: fixed;
            top: calc(var(--topbar-h) + 10px);
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            width: 600px;
            max-width: calc(100vw - 32px);
            background: rgba(12,12,30,0.98);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(108,99,255,0.2);
            border-radius: 18px;
            box-shadow:
                0 40px 90px rgba(0,0,0,0.7),
                0 0 0 1px rgba(255,255,255,0.04) inset,
                0 1px 0 rgba(255,255,255,0.07) inset;
            z-index: 500;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.25s cubic-bezier(0.16,1,0.3,1);
        }
        .win-menu-popup.open {
            opacity: 1;
            pointer-events: all;
            transform: translateX(-50%) translateY(0);
        }
        .win-menu-popup::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--accent), transparent);
            opacity: 0.7;
        }

        /* ── Search ──────────────────────────────────────────── */
        .win-search-wrap { padding: 16px 16px 0; }
        .win-search {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 11px 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .win-search:focus-within {
            border-color: rgba(108,99,255,0.5);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }
        .win-search-icon { font-size: 15px; color: var(--text-muted); flex-shrink: 0; }
        .win-search input {
            flex: 1; background: none; border: none; outline: none;
            color: var(--text-primary); font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        .win-search input::placeholder { color: var(--text-muted); }
        .win-search-clear {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 14px; padding: 2px;
            display: none; transition: color 0.2s; line-height: 1;
        }
        .win-search-clear:hover { color: var(--text-primary); }
        .win-search input:not(:placeholder-shown) ~ .win-search-clear { display: block; }

        /* ── Body: left categories + right items ─────────────── */
        .win-menu-body { display: flex; margin-top: 12px; }

        /* Left categories */
        .win-categories {
            width: 155px; flex-shrink: 0;
            padding: 4px 8px 16px;
            border-right: 1px solid var(--border);
        }
        .win-cat-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 9px;
            cursor: pointer; font-size: 13px; font-weight: 500;
            color: var(--text-secondary);
            transition: all 0.15s ease;
            border: 1px solid transparent;
            margin-bottom: 2px; user-select: none;
        }
        .win-cat-item:hover { background: rgba(255,255,255,0.05); color: var(--text-primary); }
        .win-cat-item.selected {
            background: rgba(108,99,255,0.13);
            border-color: rgba(108,99,255,0.22);
            color: #fff;
        }
        .win-cat-icon { font-size: 15px; width: 20px; text-align: center; flex-shrink: 0; }

        /* Right items */
        .win-items {
            flex: 1; padding: 6px 12px 14px;
            overflow-y: auto; max-height: 360px;
            scrollbar-width: thin;
            scrollbar-color: rgba(108,99,255,0.25) transparent;
        }
        .win-items-label {
            font-size: 10px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--text-muted); padding: 4px 8px 10px;
        }
        .win-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 10px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent;
            text-decoration: none; margin-bottom: 3px;
            transition: background 0.15s, border-color 0.15s, transform 0.15s;
        }
        .win-item:hover {
            background: rgba(108,99,255,0.1);
            border-color: rgba(108,99,255,0.16);
            transform: translateX(3px);
        }
        .win-item:focus {
            outline: none;
            background: rgba(108,99,255,0.14);
            border-color: rgba(108,99,255,0.3);
        }
        .win-item-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px; flex-shrink: 0;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
        }
        .win-item-info { overflow: hidden; flex: 1; }
        .win-item-title {
            font-size: 13px; font-weight: 600; color: var(--text-primary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .win-item-desc {
            font-size: 11px; color: var(--text-muted);
            margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .win-item-badge {
            margin-left: auto; flex-shrink: 0;
            background: rgba(108,99,255,0.18);
            border: 1px solid rgba(108,99,255,0.28);
            color: var(--primary-light);
            font-size: 10px; font-weight: 700;
            padding: 2px 8px; border-radius: 20px;
        }

        /* No results */
        .win-no-results {
            padding: 32px 16px; text-align: center;
            color: var(--text-muted); display: none;
        }
        .win-no-results .nr-icon { font-size: 32px; margin-bottom: 10px; }
        .win-no-results p { font-size: 13px; }

        /* Footer */
        .win-menu-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            font-size: 12px; color: var(--text-muted);
        }
        .win-shortcut { display: flex; align-items: center; gap: 5px; }
        .win-key {
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.06); border: 1px solid var(--border);
            border-radius: 5px; padding: 2px 7px;
            font-size: 11px; font-weight: 600; color: var(--text-secondary);
        }

        /* ═══════════════════════════════════════════════════════
           CONTENT AREA
        ═══════════════════════════════════════════════════════ */
        .page-wrapper {
            position: relative; z-index: 1;
            max-width: 1280px; margin: 0 auto;
            padding: 32px 32px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Welcome Banner ──────────────────────────────────── */
        .welcome-banner {
            background: linear-gradient(135deg, rgba(108,99,255,0.13), rgba(255,107,157,0.07));
            border: 1px solid rgba(108,99,255,0.17);
            border-radius: 20px; padding: 30px 36px;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px; position: relative; overflow: hidden;
            animation: fadeUp 0.4s ease backwards;
        }
        .welcome-banner::after {
            content: ''; position: absolute; right: -60px; top: -60px;
            width: 240px; height: 240px;
            background: radial-gradient(circle, rgba(108,99,255,0.16), transparent 70%);
            pointer-events: none;
        }
        .welcome-text h2 {
            font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700;
            margin-bottom: 6px;
        }
        .welcome-text h2 span {
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .welcome-text p { color: var(--text-secondary); font-size: 14px; }
        .welcome-emoji { font-size: 60px; line-height: 1; position: relative; z-index: 1; }

        /* ── Section title ───────────────────────────────────── */
        .section-title {
            font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text-muted); letter-spacing: 0.08em;
            text-transform: uppercase; margin-bottom: 14px;
        }

        /* ── Stats Grid ──────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px; margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; padding: 22px;
            transition: all 0.25s ease; animation: fadeUp 0.4s ease backwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }
        .stat-card:hover {
            background: var(--bg-card-hover); transform: translateY(-3px);
            border-color: var(--border-accent);
            box-shadow: 0 12px 32px rgba(0,0,0,0.25);
        }
        .stat-icon   { font-size: 26px; margin-bottom: 14px; }
        .stat-value  { font-family: 'Outfit', sans-serif; font-size: 30px; font-weight: 700; margin-bottom: 4px; }
        .stat-label  { font-size: 13px; color: var(--text-secondary); }
        .stat-change { font-size: 12px; margin-top: 8px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }
        .up { color: var(--success); }

        /* ── Quick Actions ───────────────────────────────────── */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }
        .action-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 22px 20px;
            cursor: pointer; transition: all 0.25s ease;
            text-decoration: none; display: block;
            animation: fadeUp 0.4s ease backwards;
        }
        .action-card:nth-child(1) { animation-delay: 0.08s; }
        .action-card:nth-child(2) { animation-delay: 0.13s; }
        .action-card:nth-child(3) { animation-delay: 0.18s; }
        .action-card:nth-child(4) { animation-delay: 0.23s; }
        .action-card:hover {
            background: var(--bg-card-hover); transform: translateY(-3px);
            border-color: var(--border-accent);
            box-shadow: 0 10px 28px rgba(0,0,0,0.2);
        }
        .action-icon  { font-size: 28px; margin-bottom: 12px; }
        .action-title { font-weight: 600; font-size: 14px; margin-bottom: 5px; color: var(--text-primary); }
        .action-desc  { font-size: 12px; color: var(--text-muted); line-height: 1.5; }

        /* ── Activity Card ───────────────────────────────────── */
        .activity-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            animation: fadeUp 0.4s 0.15s ease backwards;
        }
        .activity-header {
            padding: 18px 24px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .activity-title { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; }
        .activity-empty { padding: 40px; text-align: center; color: var(--text-muted); }
        .activity-empty .empty-icon { font-size: 40px; margin-bottom: 12px; }
        .activity-empty p { font-size: 14px; }
    </style>
</head>
<body>

    <!-- ══════════════ TOPBAR ══════════════ -->
    <header class="topbar">

        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="topbar-brand">
            <div class="topbar-brand-icon">🍽️</div>
            <span class="topbar-brand-name">My Menu</span>
        </a>

        <div class="topbar-divider"></div>
        <span class="topbar-title">Dashboard</span>

        <div class="topbar-spacer"></div>

        <div class="topbar-actions">

            <!-- ⊞ Windows-style Menu Trigger -->
            <div style="position:relative;">
                <button class="btn-menu-trigger" id="menuTrigger"
                    onclick="toggleWinMenu()"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="trigger-icon">⊞</span>
                    Menu
                    <span class="trigger-arrow">▾</span>
                </button>
            </div>

            <!-- Notification -->
            <button class="btn-icon" title="Notifikasi">
                🔔<span class="dot"></span>
            </button>

            <!-- User pill -->
            <div class="topbar-user">
                <div class="topbar-user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <span class="topbar-user-name">{{ $user->name }}</span>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">🚪 Keluar</button>
            </form>

        </div>
    </header>

    <!-- ══════════════ WINDOWS POPUP MENU ══════════════ -->
    <div class="win-menu-popup" id="winMenuPopup" role="dialog" aria-label="Menu Utama">

        <!-- Search -->
        <div class="win-search-wrap">
            <div class="win-search">
                <span class="win-search-icon">🔍</span>
                <input type="text" id="winSearchInput" placeholder="Cari menu..." autocomplete="off"
                    oninput="filterWinMenu(this.value)">
                <button class="win-search-clear" onclick="clearWinSearch()" tabindex="-1">✕</button>
            </div>
        </div>

        <!-- Body -->
        <div class="win-menu-body">

            <!-- Categories -->
            <div class="win-categories" id="winCategories">
                <div class="win-cat-item selected" onclick="selectCat(this,'all')">
                    <span class="win-cat-icon">⭐</span> Favorit
                </div>
                <div class="win-cat-item" onclick="selectCat(this,'all')">
                    <span class="win-cat-icon">🗂️</span> Semua
                </div>
                <div class="win-cat-item" onclick="selectCat(this,'menu')">
                    <span class="win-cat-icon">🍜</span> Makanan
                </div>
                <div class="win-cat-item" onclick="selectCat(this,'category')">
                    <span class="win-cat-icon">📦</span> Kategori
                </div>
                <div class="win-cat-item" onclick="selectCat(this,'report')">
                    <span class="win-cat-icon">📊</span> Laporan
                </div>
                <div class="win-cat-item" onclick="selectCat(this,'settings')">
                    <span class="win-cat-icon">⚙️</span> Pengaturan
                </div>
            </div>

            <!-- Items -->
            <div class="win-items" id="winItems">
                <div class="win-items-label" id="winItemsLabel">Favorit</div>

                <a href="{{ route('dashboard') }}" class="win-item" data-cat="all" data-keywords="dashboard beranda home">
                    <div class="win-item-icon" style="background:rgba(108,99,255,0.15);border-color:rgba(108,99,255,0.25);">🏠</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Dashboard</div>
                        <div class="win-item-desc">Halaman utama & ringkasan</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="menu" data-keywords="menu makanan tambah kelola">
                    <div class="win-item-icon" style="background:rgba(255,107,157,0.12);border-color:rgba(255,107,157,0.2);">🍜</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Kelola Menu</div>
                        <div class="win-item-desc">Tambah & edit item menu</div>
                    </div>
                    <span class="win-item-badge">Segera</span>
                </a>

                <a href="#" class="win-item" data-cat="menu" data-keywords="tambah baru item">
                    <div class="win-item-icon" style="background:rgba(0,217,165,0.1);border-color:rgba(0,217,165,0.2);">➕</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Tambah Menu Baru</div>
                        <div class="win-item-desc">Buat item menu baru</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="category" data-keywords="kategori folder organisir">
                    <div class="win-item-icon" style="background:rgba(255,182,71,0.1);border-color:rgba(255,182,71,0.2);">📦</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Kategori</div>
                        <div class="win-item-desc">Organisir menu per kategori</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="menu" data-keywords="gambar foto upload media">
                    <div class="win-item-icon" style="background:rgba(108,99,255,0.12);border-color:rgba(108,99,255,0.2);">🖼️</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Upload Media</div>
                        <div class="win-item-desc">Foto & gambar untuk menu</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="report" data-keywords="laporan analitik statistik grafik">
                    <div class="win-item-icon" style="background:rgba(0,217,165,0.1);border-color:rgba(0,217,165,0.2);">📊</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Analitik</div>
                        <div class="win-item-desc">Statistik & grafik performa</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="report" data-keywords="pesanan order transaksi riwayat">
                    <div class="win-item-icon" style="background:rgba(255,107,157,0.1);border-color:rgba(255,107,157,0.2);">🧾</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Pesanan</div>
                        <div class="win-item-desc">Riwayat transaksi pesanan</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="settings" data-keywords="pengaturan setting konfigurasi">
                    <div class="win-item-icon" style="background:rgba(255,255,255,0.05);">⚙️</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Pengaturan</div>
                        <div class="win-item-desc">Konfigurasi aplikasi</div>
                    </div>
                </a>

                <a href="#" class="win-item" data-cat="settings" data-keywords="bagikan share link qr publik">
                    <div class="win-item-icon" style="background:rgba(108,99,255,0.12);border-color:rgba(108,99,255,0.2);">🔗</div>
                    <div class="win-item-info">
                        <div class="win-item-title">Bagikan Menu</div>
                        <div class="win-item-desc">Link publik untuk pelanggan</div>
                    </div>
                </a>

                <!-- No results -->
                <div class="win-no-results" id="winNoResults">
                    <div class="nr-icon">🔍</div>
                    <p>Tidak ada hasil untuk kata kunci ini.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="win-menu-footer">
            <span>{{ $user->name }}</span>
            <div class="win-shortcut">
                <span class="win-key">Ctrl</span>
                <span>+</span>
                <span class="win-key">K</span>
                <span style="margin-left:4px;">untuk buka menu</span>
            </div>
        </div>
    </div>

    <!-- ══════════════ PAGE CONTENT ══════════════ -->
    <div class="page-wrapper">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h2>Halo, <span>{{ $user->name }}</span>! 👋</h2>
                <p>Selamat datang di panel manajemen My Menu. Mulai kelola menu restoran Anda.</p>
            </div>
            <div class="welcome-emoji">🍽️</div>
        </div>

        <!-- Stats -->
        <div class="section-title">Ringkasan</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🍜</div>
                <div class="stat-value" style="color: var(--primary-light);">0</div>
                <div class="stat-label">Total Menu</div>
                <div class="stat-change"><span class="up">●</span> Belum ada data</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-value" style="color: var(--accent);">0</div>
                <div class="stat-label">Kategori</div>
                <div class="stat-change"><span class="up">●</span> Belum ada data</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value" style="color: var(--success);">1</div>
                <div class="stat-label">Pengguna Aktif</div>
                <div class="stat-change"><span class="up">✓</span> Online sekarang</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-value" style="color: var(--warning); font-size: 18px;">{{ now()->format('d M Y') }}</div>
                <div class="stat-label">Tanggal Hari Ini</div>
                <div class="stat-change">{{ now()->isoFormat('dddd') }}</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-title">Aksi Cepat</div>
        <div class="actions-grid">
            <a href="#" class="action-card">
                <div class="action-icon">➕</div>
                <div class="action-title">Tambah Menu</div>
                <div class="action-desc">Tambahkan item menu baru ke daftar</div>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon">📁</div>
                <div class="action-title">Buat Kategori</div>
                <div class="action-desc">Organisir menu dengan kategori</div>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon">🖼️</div>
                <div class="action-title">Upload Gambar</div>
                <div class="action-desc">Tambahkan foto menarik untuk menu</div>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon">🔗</div>
                <div class="action-title">Bagikan Menu</div>
                <div class="action-desc">Tampilkan menu ke pelanggan</div>
            </a>
        </div>

        <!-- Activity -->
        <div class="activity-card">
            <div class="activity-header">
                <span class="activity-title">📋 Aktivitas Terbaru</span>
                <span style="font-size: 12px; color: var(--text-muted);">Hari ini</span>
            </div>
            <div class="activity-empty">
                <div class="empty-icon">🌱</div>
                <p>Belum ada aktivitas. Mulai dengan menambah menu pertama Anda!</p>
            </div>
        </div>

    </div><!-- /page-wrapper -->

    <script>
        /* ═══════════════════════════════════════════════════════
           WINDOWS-STYLE POPUP MENU
        ═══════════════════════════════════════════════════════ */
        const menuTrigger    = document.getElementById('menuTrigger');
        const winMenuPopup   = document.getElementById('winMenuPopup');
        const winSearchInput = document.getElementById('winSearchInput');
        const winNoResults   = document.getElementById('winNoResults');
        const winItemsLabel  = document.getElementById('winItemsLabel');
        const allWinItems    = document.querySelectorAll('.win-item');

        let winMenuOpen = false;
        let activeCat   = 'all';

        /* Toggle */
        function toggleWinMenu() {
            winMenuOpen ? closeWinMenu() : openWinMenu();
        }

        function openWinMenu() {
            winMenuOpen = true;
            winMenuPopup.classList.add('open');
            menuTrigger.classList.add('active');
            menuTrigger.setAttribute('aria-expanded', 'true');
            setTimeout(() => winSearchInput.focus(), 60);
        }

        function closeWinMenu() {
            winMenuOpen = false;
            winMenuPopup.classList.remove('open');
            menuTrigger.classList.remove('active');
            menuTrigger.setAttribute('aria-expanded', 'false');
            clearWinSearch();
        }

        /* Close on outside click */
        document.addEventListener('click', (e) => {
            if (winMenuOpen
                && !winMenuPopup.contains(e.target)
                && !menuTrigger.contains(e.target)) {
                closeWinMenu();
            }
        });

        /* Keyboard shortcuts */
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && winMenuOpen) { closeWinMenu(); return; }
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                winMenuOpen ? closeWinMenu() : openWinMenu();
            }
        });

        /* Category labels */
        const catLabels = {
            all: 'Semua Menu', menu: 'Makanan & Menu',
            category: 'Kategori', report: 'Laporan', settings: 'Pengaturan',
        };

        function selectCat(el, cat) {
            document.querySelectorAll('.win-cat-item').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            activeCat = cat;
            winItemsLabel.textContent = catLabels[cat] || 'Menu';
            winSearchInput.value = '';
            filterWinMenu('');
        }

        /* Live search + filter */
        function filterWinMenu(query) {
            const q = query.toLowerCase().trim();
            let visible = 0;

            allWinItems.forEach(item => {
                const cat  = item.dataset.cat;
                const kw   = (item.dataset.keywords || '') + ' ' +
                             (item.querySelector('.win-item-title')?.textContent || '') + ' ' +
                             (item.querySelector('.win-item-desc')?.textContent  || '');
                const show = ((activeCat === 'all') || cat === activeCat)
                          && (!q || kw.toLowerCase().includes(q));

                item.style.display = show ? 'flex' : 'none';
                if (show) {
                    highlightText(item.querySelector('.win-item-title'), q);
                    visible++;
                }
            });

            winNoResults.style.display = visible === 0 ? 'block' : 'none';
        }

        /* Highlight matched text */
        function highlightText(el, q) {
            if (!el) return;
            const raw = el.textContent;
            if (!q) { el.innerHTML = raw; return; }
            const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
            el.innerHTML = raw.replace(re, '<mark style="background:rgba(108,99,255,0.35);color:#fff;border-radius:3px;padding:0 2px;">$1</mark>');
        }

        /* Clear search */
        function clearWinSearch() {
            winSearchInput.value = '';
            filterWinMenu('');
            winSearchInput.focus();
        }

        /* Arrow key navigation */
        winSearchInput.addEventListener('keydown', (e) => {
            const vis = [...allWinItems].filter(i => i.style.display !== 'none');
            if (e.key === 'ArrowDown' && vis.length) { e.preventDefault(); vis[0].focus(); }
        });
        winMenuPopup.addEventListener('keydown', (e) => {
            const vis = [...allWinItems].filter(i => i.style.display !== 'none');
            const idx = vis.indexOf(document.activeElement);
            if (e.key === 'ArrowDown' && idx < vis.length - 1) { e.preventDefault(); vis[idx+1].focus(); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); idx > 0 ? vis[idx-1].focus() : winSearchInput.focus(); }
        });
    </script>

</body>
</html>
