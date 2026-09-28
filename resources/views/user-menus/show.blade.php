<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail Menu: {{ $userMenu->nama }} — My Menu">
    <title>Detail: {{ $userMenu->nama }} — My Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--primary:#6C63FF;--primary-light:#8B85FF;--primary-dark:#5046E4;--accent:#FF6B9D;--success:#00D9A5;--warning:#FFB647;--danger:#FF4F6A;--info:#38BDF8;--bg-deep:#0A0A1A;--bg-card:rgba(255,255,255,0.04);--bg-card-hover:rgba(255,255,255,0.07);--border:rgba(255,255,255,0.07);--border-accent:rgba(108,99,255,0.25);--text-primary:#F0F0FF;--text-secondary:#9090B0;--text-muted:#5A5A7A;--topbar-h:64px;--radius:12px;--radius-sm:8px}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:var(--bg-deep);color:var(--text-primary);min-height:100vh}
        body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 70% 50% at 15% 10%,rgba(108,99,255,.08) 0%,transparent 60%),radial-gradient(ellipse 50% 40% at 85% 85%,rgba(255,107,157,.06) 0%,transparent 55%);pointer-events:none;z-index:0}
        .topbar{position:sticky;top:0;z-index:100;height:var(--topbar-h);display:flex;align-items:center;padding:0 28px;background:rgba(10,10,26,.88);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);gap:16px}
        .topbar::after{content:'';position:absolute;bottom:-1px;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent 0%,rgba(108,99,255,.3) 30%,rgba(255,107,157,.2) 70%,transparent 100%)}
        .topbar-brand{display:flex;align-items:center;gap:10px;text-decoration:none}
        .topbar-logo{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;font-size:18px}
        .topbar-title{font-family:'Outfit',sans-serif;font-size:1.2rem;font-weight:700;color:var(--text-primary)}
        .topbar-sep{color:var(--text-muted);font-size:1.2rem}
        .topbar-page{font-size:.9rem;color:var(--text-secondary);font-weight:500}
        .topbar-spacer{flex:1}
        .topbar-back{display:flex;align-items:center;gap:8px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--bg-card);border:1px solid var(--border);color:var(--text-secondary);font-size:.85rem;text-decoration:none;transition:all .2s}
        .topbar-back:hover{background:var(--bg-card-hover);color:var(--text-primary);border-color:var(--border-accent)}
        .page-wrap{position:relative;z-index:1;padding:32px 28px;max-width:900px;margin:0 auto}
        /* Hero */
        .hero{display:flex;align-items:center;gap:20px;margin-bottom:32px}
        .hero-icon{width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,rgba(108,99,255,.3),rgba(255,107,157,.2));border:1px solid var(--border-accent);display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0}
        .hero-info h1{font-family:'Outfit',sans-serif;font-size:1.8rem;font-weight:800;background:linear-gradient(135deg,#fff 0%,var(--primary-light) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero-info p{color:var(--text-secondary);font-size:.9rem;margin-top:4px}
        .hero-actions{display:flex;gap:10px;flex-wrap:wrap;margin-left:auto}
        /* Cards */
        .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .detail-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:24px}
        .detail-card.full{grid-column:1/-1}
        .card-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)}
        .field-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(255,255,255,.04)}
        .field-row:last-child{border-bottom:none}
        .field-label{font-size:.8rem;color:var(--text-muted)}
        .field-value{font-size:.875rem;color:var(--text-primary);font-weight:500;text-align:right}
        /* Badges */
        .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:999px;font-size:.73rem;font-weight:600}
        .badge-active{background:rgba(0,217,165,.15);color:var(--success);border:1px solid rgba(0,217,165,.3)}
        .badge-inactive{background:rgba(255,79,106,.12);color:var(--danger);border:1px solid rgba(255,79,106,.25)}
        .badge-header{background:rgba(255,182,71,.15);color:var(--warning);border:1px solid rgba(255,182,71,.3)}
        .badge-root{background:rgba(56,189,248,.1);color:var(--info);border:1px solid rgba(56,189,248,.2)}
        .badge-child{background:rgba(108,99,255,.15);color:var(--primary-light);border:1px solid rgba(108,99,255,.3)}
        /* Permission grid */
        .perm-display{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
        .perm-item{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 8px;border-radius:var(--radius-sm);border:1px solid var(--border)}
        .perm-on{background:rgba(0,217,165,.1);border-color:rgba(0,217,165,.25)}
        .perm-off{background:rgba(255,255,255,.02);opacity:.5}
        .perm-icon{font-size:1.3rem}
        .perm-label{font-size:.7rem;font-weight:600;color:var(--text-secondary)}
        .perm-status{font-size:.65rem;font-weight:700}
        .perm-on .perm-status{color:var(--success)}
        .perm-off .perm-status{color:var(--text-muted)}
        /* Sub-menus */
        .sub-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border);margin-bottom:8px}
        .sub-icon{font-size:1rem;width:28px;text-align:center}
        .sub-name{font-size:.85rem;font-weight:500}
        .sub-code{font-family:monospace;font-size:.75rem;color:var(--primary-light)}
        /* Code chip */
        .code-chip{font-family:'Courier New',monospace;font-size:.8rem;font-weight:600;color:var(--primary-light);background:rgba(108,99,255,.12);border:1px solid rgba(108,99,255,.2);padding:2px 10px;border-radius:4px}
        /* Buttons */
        .btn-primary{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:var(--radius-sm);background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;font-size:.875rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 15px rgba(108,99,255,.3)}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(108,99,255,.4)}
        .btn-ghost{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:var(--radius-sm);background:transparent;color:var(--text-secondary);font-size:.875rem;border:1px solid var(--border);cursor:pointer;transition:all .2s;text-decoration:none}
        .btn-ghost:hover{border-color:var(--border-accent);color:var(--text-primary)}
        .btn-danger{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:var(--radius-sm);background:rgba(255,79,106,.12);color:var(--danger);font-size:.875rem;border:1px solid rgba(255,79,106,.25);cursor:pointer;transition:all .2s;text-decoration:none}
        .btn-danger:hover{background:rgba(255,79,106,.2)}
        .btn-warning{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:var(--radius-sm);background:rgba(255,182,71,.12);color:var(--warning);font-size:.875rem;border:1px solid rgba(255,182,71,.25);cursor:pointer;transition:all .2s;text-decoration:none}
        .btn-warning:hover{background:rgba(255,182,71,.2)}
        /* Alert */
        .alert{padding:14px 18px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:.9rem;display:flex;align-items:center;gap:10px}
        .alert-success{background:rgba(0,217,165,.1);border:1px solid rgba(0,217,165,.25);color:var(--success)}
        @media(max-width:700px){.detail-grid{grid-template-columns:1fr}.perm-display{grid-template-columns:repeat(2,1fr)}.hero{flex-direction:column}.hero-actions{margin-left:0;width:100%}.page-wrap{padding:20px 16px}}
    </style>
</head>
<body>
<header class="topbar">
    <a href="{{ route('dashboard') }}" class="topbar-brand">
        <div class="topbar-logo">🍜</div>
        <span class="topbar-title">My Menu</span>
    </a>
    <span class="topbar-sep">/</span>
    <a href="{{ route('user-menus.index') }}" class="topbar-page" style="text-decoration:none;color:var(--text-secondary)">Master Menu User</a>
    <span class="topbar-sep">/</span>
    <span class="topbar-page">Detail</span>
    <div class="topbar-spacer"></div>
    <a href="{{ route('user-menus.index') }}" class="topbar-back">← Kembali</a>
</header>

<div class="page-wrap">

    @if(session('success'))
        <div class="alert alert-success" role="alert">✔ {{ session('success') }}</div>
    @endif

    {{-- ── Hero ────────────────────────────────────────────── --}}
    <div class="hero">
        <div class="hero-icon">{{ $userMenu->icon ?? '🗂️' }}</div>
        <div class="hero-info">
            <h1>{{ $userMenu->nama }}</h1>
            <p>
                <span class="code-chip">{{ $userMenu->code_menu }}</span>
                &nbsp;
                <span class="badge {{ $userMenu->is_active ? 'badge-active' : 'badge-inactive' }}">
                    {{ $userMenu->is_active ? '● Aktif' : '○ Non-Aktif' }}
                </span>
                @if($userMenu->is_header)
                    &nbsp;<span class="badge badge-header">Header</span>
                @endif
            </p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('user-menus.edit', $userMenu) }}" class="btn-primary" id="btn-edit-detail">✏️ Edit</a>

            <form method="POST" action="{{ route('user-menus.toggle', $userMenu) }}" style="display:inline" id="form-toggle-detail">
                @csrf @method('PATCH')
                <button type="submit"
                        class="{{ $userMenu->is_active ? 'btn-warning' : 'btn-ghost' }}"
                        id="btn-toggle-detail"
                        onclick="return confirm('{{ $userMenu->is_active ? 'Nonaktifkan' : 'Aktifkan' }} menu ini?')">
                    {{ $userMenu->is_active ? '⏸ Nonaktifkan' : '▶ Aktifkan' }}
                </button>
            </form>

            <form method="POST" action="{{ route('user-menus.destroy', $userMenu) }}" style="display:inline" id="form-delete-detail">
                @csrf @method('DELETE')
                <button type="submit"
                        class="btn-danger"
                        id="btn-delete-detail"
                        onclick="return confirm('Hapus menu \"{{ $userMenu->nama }}\"? Tindakan ini tidak dapat dibatalkan.')">
                    🗑 Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- ── Detail Cards ────────────────────────────────────── --}}
    <div class="detail-grid">

        {{-- Informasi Dasar --}}
        <div class="detail-card">
            <div class="card-title">📋 Informasi Dasar</div>

            <div class="field-row">
                <span class="field-label">Kode Menu</span>
                <span class="field-value"><span class="code-chip">{{ $userMenu->code_menu }}</span></span>
            </div>
            <div class="field-row">
                <span class="field-label">Nama</span>
                <span class="field-value">{{ $userMenu->nama }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Icon</span>
                <span class="field-value">{{ $userMenu->icon ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">URL / Route</span>
                <span class="field-value" style="font-family:monospace;font-size:.8rem">{{ $userMenu->url ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Urutan</span>
                <span class="field-value">{{ $userMenu->sort_order }}</span>
            </div>
        </div>

        {{-- Konfigurasi --}}
        <div class="detail-card">
            <div class="card-title">⚙️ Konfigurasi & Status</div>

            <div class="field-row">
                <span class="field-label">Parent Menu</span>
                <span class="field-value">
                    @if($userMenu->parent)
                        <span class="badge badge-child">{{ $userMenu->parent->nama }}</span>
                    @else
                        <span class="badge badge-root">Root</span>
                    @endif
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Header / Divider</span>
                <span class="field-value">
                    @if($userMenu->is_header)
                        <span class="badge badge-header">Ya</span>
                    @else
                        <span style="color:var(--text-muted)">Tidak</span>
                    @endif
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Status</span>
                <span class="field-value">
                    <span class="badge {{ $userMenu->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $userMenu->is_active ? '● Aktif' : '○ Non-Aktif' }}
                    </span>
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Dibuat</span>
                <span class="field-value" style="font-size:.8rem">{{ $userMenu->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Diperbarui</span>
                <span class="field-value" style="font-size:.8rem">{{ $userMenu->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        {{-- Hak Akses --}}
        <div class="detail-card">
            <div class="card-title">🔐 Hak Akses</div>
            <div class="perm-display">
                <div class="perm-item {{ $userMenu->can_view ? 'perm-on' : 'perm-off' }}">
                    <span class="perm-icon">👁️</span>
                    <span class="perm-label">View</span>
                    <span class="perm-status">{{ $userMenu->can_view ? '✓ Aktif' : '✗ Tidak' }}</span>
                </div>
                <div class="perm-item {{ $userMenu->can_create ? 'perm-on' : 'perm-off' }}">
                    <span class="perm-icon">➕</span>
                    <span class="perm-label">Create</span>
                    <span class="perm-status">{{ $userMenu->can_create ? '✓ Aktif' : '✗ Tidak' }}</span>
                </div>
                <div class="perm-item {{ $userMenu->can_update ? 'perm-on' : 'perm-off' }}">
                    <span class="perm-icon">✏️</span>
                    <span class="perm-label">Update</span>
                    <span class="perm-status">{{ $userMenu->can_update ? '✓ Aktif' : '✗ Tidak' }}</span>
                </div>
                <div class="perm-item {{ $userMenu->can_delete ? 'perm-on' : 'perm-off' }}">
                    <span class="perm-icon">🗑️</span>
                    <span class="perm-label">Delete</span>
                    <span class="perm-status">{{ $userMenu->can_delete ? '✓ Aktif' : '✗ Tidak' }}</span>
                </div>
            </div>
        </div>

        {{-- Sub-menus --}}
        <div class="detail-card">
            <div class="card-title">🌿 Sub-Menu ({{ $userMenu->children->count() }})</div>
            @forelse($userMenu->children as $child)
                <div class="sub-item">
                    <span class="sub-icon">{{ $child->icon ?? '└' }}</span>
                    <div>
                        <div class="sub-name">{{ $child->nama }}</div>
                        <div class="sub-code">{{ $child->code_menu }}</div>
                    </div>
                    <span class="badge {{ $child->is_active ? 'badge-active' : 'badge-inactive' }}" style="margin-left:auto;font-size:.65rem">
                        {{ $child->is_active ? 'Aktif' : 'Off' }}
                    </span>
                </div>
            @empty
                <p style="color:var(--text-muted);font-size:.85rem;text-align:center;padding:16px">Tidak ada sub-menu</p>
            @endforelse
        </div>

    </div>

</div>
</body>
</html>
