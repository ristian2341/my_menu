<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Menu User — Kelola daftar menu navigasi sistem">
    <title>Master Menu User — My Menu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════
           DESIGN TOKENS
        ═══════════════════════════════════════ */
        :root {
            --primary:        #6C63FF;
            --primary-light:  #8B85FF;
            --primary-dark:   #5046E4;
            --accent:         #FF6B9D;
            --success:        #00D9A5;
            --warning:        #FFB647;
            --danger:         #FF4F6A;
            --info:           #38BDF8;
            --bg-deep:        #0A0A1A;
            --bg-card:        rgba(255,255,255,0.04);
            --bg-card-hover:  rgba(255,255,255,0.07);
            --border:         rgba(255,255,255,0.07);
            --border-accent:  rgba(108,99,255,0.25);
            --text-primary:   #F0F0FF;
            --text-secondary: #9090B0;
            --text-muted:     #5A5A7A;
            --topbar-h:       64px;
            --radius:         12px;
            --radius-sm:      8px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 15% 10%, rgba(108,99,255,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 85% 85%, rgba(255,107,157,0.06) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }

        /* ── Topbar ─────────────────────────── */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            height: var(--topbar-h);
            display: flex; align-items: center;
            padding: 0 28px;
            background: rgba(10,10,26,0.88);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            gap: 16px;
        }
        .topbar::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(108,99,255,0.3) 30%, rgba(255,107,157,0.2) 70%, transparent 100%);
        }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .topbar-title { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--text-primary); }
        .topbar-sep { color: var(--text-muted); font-size: 1.2rem; }
        .topbar-page { font-size: 0.9rem; color: var(--text-secondary); font-weight: 500; }
        .topbar-spacer { flex: 1; }
        .topbar-back {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: var(--radius-sm);
            background: var(--bg-card); border: 1px solid var(--border);
            color: var(--text-secondary); font-size: 0.85rem;
            text-decoration: none; transition: all .2s;
        }
        .topbar-back:hover { background: var(--bg-card-hover); color: var(--text-primary); border-color: var(--border-accent); }

        /* ── Layout ─────────────────────────── */
        .page-wrap { position: relative; z-index: 1; padding: 32px 28px; max-width: 1400px; margin: 0 auto; }

        /* ── Page header ─────────────────────── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
        .page-header-left h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem; font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, var(--primary-light) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .page-header-left p { color: var(--text-secondary); font-size: 0.9rem; margin-top: 4px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; font-size: 0.875rem; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: all .2s; box-shadow: 0 4px 15px rgba(108,99,255,0.3);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(108,99,255,0.4); }

        /* ── Alert ──────────────────────────── */
        .alert {
            padding: 14px 18px; border-radius: var(--radius-sm);
            margin-bottom: 20px; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(0,217,165,0.1); border: 1px solid rgba(0,217,165,0.25); color: var(--success); }
        .alert-error   { background: rgba(255,79,106,0.1);  border: 1px solid rgba(255,79,106,0.25);  color: var(--danger);  }

        /* ── Filter toolbar ─────────────────── */
        .filter-bar {
            display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 16px 20px; margin-bottom: 20px;
        }
        .filter-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 500; white-space: nowrap; }
        .filter-input, .filter-select {
            background: rgba(255,255,255,0.06); border: 1px solid var(--border);
            border-radius: var(--radius-sm); padding: 8px 14px;
            color: var(--text-primary); font-size: 0.85rem; outline: none;
            transition: border-color .2s;
        }
        .filter-input  { min-width: 220px; }
        .filter-select { min-width: 140px; }
        .filter-input:focus, .filter-select:focus { border-color: var(--primary-light); }
        .filter-select option { background: #1a1a30; }
        .btn-filter {
            padding: 8px 18px; border-radius: var(--radius-sm);
            background: var(--primary); color: #fff; font-size: 0.85rem; font-weight: 600;
            border: none; cursor: pointer; transition: background .2s;
        }
        .btn-filter:hover { background: var(--primary-dark); }
        .btn-reset {
            padding: 8px 14px; border-radius: var(--radius-sm);
            background: transparent; color: var(--text-secondary); font-size: 0.85rem;
            border: 1px solid var(--border); cursor: pointer; transition: all .2s;
            text-decoration: none;
        }
        .btn-reset:hover { border-color: var(--border-accent); color: var(--text-primary); }
        .filter-spacer { flex: 1; }
        .total-badge {
            font-size: 0.8rem; color: var(--text-muted);
            background: rgba(255,255,255,0.05); padding: 4px 12px; border-radius: 999px;
            border: 1px solid var(--border);
        }

        /* ── Table card ─────────────────────── */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th {
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            color: var(--text-secondary);
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
            border-bottom: 1px solid var(--border);
            white-space: nowrap; text-align: left;
        }
        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--bg-card-hover); }
        td { padding: 14px 16px; vertical-align: middle; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 999px; font-size: 0.73rem; font-weight: 600;
        }
        .badge-active   { background: rgba(0,217,165,0.15); color: var(--success); border: 1px solid rgba(0,217,165,0.3); }
        .badge-inactive { background: rgba(255,79,106,0.12); color: var(--danger);  border: 1px solid rgba(255,79,106,0.25); }
        .badge-header   { background: rgba(255,182,71,0.15); color: var(--warning); border: 1px solid rgba(255,182,71,0.3); }
        .badge-child    { background: rgba(108,99,255,0.15); color: var(--primary-light); border: 1px solid rgba(108,99,255,0.3); }
        .badge-perm {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600;
            margin: 2px;
        }
        .perm-on  { background: rgba(0,217,165,0.15); color: var(--success); }
        .perm-off { background: rgba(255,255,255,0.05); color: var(--text-muted); }

        /* Code chip */
        .code-chip {
            font-family: 'Courier New', monospace; font-size: 0.78rem; font-weight: 600;
            color: var(--primary-light);
            background: rgba(108,99,255,0.12); border: 1px solid rgba(108,99,255,0.2);
            padding: 2px 8px; border-radius: 4px; letter-spacing: .03em;
        }

        /* Icon cell */
        .icon-cell { font-size: 1.2rem; text-align: center; }

        /* Parent indent */
        .menu-name { display: flex; align-items: center; gap: 8px; }
        .indent-mark { color: var(--text-muted); font-size: 0.8rem; }

        /* URL */
        .url-text { font-size: 0.8rem; color: var(--text-muted); font-family: monospace; }

        /* Action buttons */
        .actions { display: flex; gap: 6px; align-items: center; }
        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 7px;
            border: none; cursor: pointer; transition: all .18s; text-decoration: none; font-size: 0.8rem;
        }
        .btn-edit   { background: rgba(56,189,248,0.12); color: var(--info);    border: 1px solid rgba(56,189,248,0.25); }
        .btn-view   { background: rgba(255,182,71,0.12); color: var(--warning); border: 1px solid rgba(255,182,71,0.25); }
        .btn-delete { background: rgba(255,79,106,0.12); color: var(--danger);  border: 1px solid rgba(255,79,106,0.25); }
        .btn-toggle-on  { background: rgba(255,79,106,0.12);  color: var(--danger);   border: 1px solid rgba(255,79,106,0.25);  }
        .btn-toggle-off { background: rgba(0,217,165,0.12);   color: var(--success);  border: 1px solid rgba(0,217,165,0.25);   }
        .btn-icon:hover { transform: translateY(-1px) scale(1.08); filter: brightness(1.2); }

        /* Empty state */
        .empty-state { text-align: center; padding: 64px 24px; color: var(--text-muted); }
        .empty-state .icon { font-size: 3.5rem; margin-bottom: 12px; opacity: .5; }
        .empty-state p { font-size: 0.9rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .page-wrap { padding: 20px 16px; }
            .page-header { flex-direction: column; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .filter-input, .filter-select { min-width: unset; width: 100%; }
            .topbar { padding: 0 16px; }
        }
    </style>
</head>
<body>

{{-- ═══ TOPBAR ═══════════════════════════════════════════════════════════════ --}}
<header class="topbar">
    <a href="{{ route('dashboard') }}" class="topbar-brand">
        <div class="topbar-logo">🍜</div>
        <span class="topbar-title">My Menu</span>
    </a>
    <span class="topbar-sep">/</span>
    <span class="topbar-page">Master Menu User</span>
    <div class="topbar-spacer"></div>
    <a href="{{ route('dashboard') }}" class="topbar-back">← Dashboard</a>
</header>

<div class="page-wrap">

    {{-- ─── Page Header ─────────────────────────────────────────────── --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1>🗂️ Master Menu User</h1>
            <p>Kelola menu navigasi, hak akses, dan hirarki parent–child</p>
        </div>
        <a href="{{ route('user-menus.create') }}" class="btn-primary" id="btn-tambah-menu">
            ＋ Tambah Menu
        </a>
    </div>

    {{-- ─── Flash messages ──────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">✔ {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error" role="alert">✖ {{ $errors->first() }}</div>
    @endif

    {{-- ─── Filter Bar ──────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('user-menus.index') }}" id="form-filter">
        <div class="filter-bar">
            <span class="filter-label">🔍 Cari:</span>
            <input id="filter-search" class="filter-input" type="text" name="search"
                   placeholder="Kode, nama, atau URL..."
                   value="{{ request('search') }}">

            <span class="filter-label">Status:</span>
            <select id="filter-status" class="filter-select" name="status">
                <option value="">Semua</option>
                <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <span class="filter-label">Parent:</span>
            <select id="filter-parent" class="filter-select" name="parent">
                <option value="">Semua</option>
                <option value="root" {{ request('parent') === 'root' ? 'selected' : '' }}>Root (tanpa parent)</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" {{ request('parent') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter" id="btn-filter-cari">Cari</button>
            <a href="{{ route('user-menus.index') }}" class="btn-reset" id="btn-filter-reset">Reset</a>

            <div class="filter-spacer"></div>
            <span class="total-badge">{{ $userMenus->count() }} item</span>
        </div>
    </form>

    {{-- ─── Table ───────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Icon</th>
                        <th>Nama Menu</th>
                        <th>Parent</th>
                        <th>Header</th>
                        <th>URL</th>
                        <th>Hak Akses</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userMenus as $i => $menu)
                        <tr id="row-menu-{{ $menu->id }}">
                            <td style="color:var(--text-muted)">{{ $i + 1 }}</td>

                            <td><span class="code-chip">{{ $menu->code_menu }}</span></td>

                            <td class="icon-cell">{{ $menu->icon ?? '—' }}</td>

                            <td>
                                <div class="menu-name">
                                    @if($menu->parent_id)
                                        <span class="indent-mark">└</span>
                                    @endif
                                    <span style="font-weight:500">{{ $menu->nama }}</span>
                                </div>
                            </td>

                            <td>
                                @if($menu->parent)
                                    <span class="badge badge-child">{{ $menu->parent->nama }}</span>
                                @else
                                    <span style="color:var(--text-muted);font-size:.8rem">Root</span>
                                @endif
                            </td>

                            <td>
                                @if($menu->is_header)
                                    <span class="badge badge-header">Header</span>
                                @else
                                    <span style="color:var(--text-muted);font-size:.75rem">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="url-text">{{ $menu->url ?? '—' }}</span>
                            </td>

                            <td>
                                <span class="badge-perm {{ $menu->can_view   ? 'perm-on' : 'perm-off' }}">V</span>
                                <span class="badge-perm {{ $menu->can_create ? 'perm-on' : 'perm-off' }}">C</span>
                                <span class="badge-perm {{ $menu->can_update ? 'perm-on' : 'perm-off' }}">U</span>
                                <span class="badge-perm {{ $menu->can_delete ? 'perm-on' : 'perm-off' }}">D</span>
                            </td>

                            <td style="color:var(--text-secondary);text-align:center">{{ $menu->sort_order }}</td>

                            <td>
                                <span class="badge {{ $menu->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $menu->is_active ? '● Aktif' : '○ Non-Aktif' }}
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    {{-- Detail --}}
                                    <a href="{{ route('user-menus.show', $menu) }}"
                                       class="btn-icon btn-view" title="Detail" id="btn-view-{{ $menu->id }}">👁</a>

                                    {{-- Edit --}}
                                    <a href="{{ route('user-menus.edit', $menu) }}"
                                       class="btn-icon btn-edit" title="Edit" id="btn-edit-{{ $menu->id }}">✏️</a>

                                    {{-- Toggle Status --}}
                                    <form method="POST"
                                          action="{{ route('user-menus.toggle', $menu) }}"
                                          id="form-toggle-{{ $menu->id }}" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="btn-icon {{ $menu->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                                id="btn-toggle-{{ $menu->id }}"
                                                title="{{ $menu->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                onclick="return confirm('{{ $menu->is_active ? 'Nonaktifkan' : 'Aktifkan' }} menu ini?')">
                                            {{ $menu->is_active ? '⏸' : '▶' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('user-menus.destroy', $menu) }}"
                                          id="form-delete-{{ $menu->id }}" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn-icon btn-delete"
                                                id="btn-delete-{{ $menu->id }}"
                                                title="Hapus"
                                                onclick="return confirm('Hapus menu \"{{ $menu->nama }}\"? Aksi ini tidak dapat dibatalkan.')">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="empty-state">
                                    <div class="icon">🗂️</div>
                                    <p>Belum ada menu yang tersedia.</p>
                                    <a href="{{ route('user-menus.create') }}" class="btn-primary" style="display:inline-flex;margin-top:16px">
                                        ＋ Tambah Menu Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
