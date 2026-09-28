<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit Menu User — My Menu">
    <title>Edit Menu: {{ $userMenu->nama }} — My Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:#6C63FF; --primary-light:#8B85FF; --primary-dark:#5046E4;
            --accent:#FF6B9D; --success:#00D9A5; --warning:#FFB647; --danger:#FF4F6A;
            --bg-deep:#0A0A1A; --bg-card:rgba(255,255,255,0.04); --bg-card-hover:rgba(255,255,255,0.07);
            --border:rgba(255,255,255,0.07); --border-accent:rgba(108,99,255,0.25);
            --text-primary:#F0F0FF; --text-secondary:#9090B0; --text-muted:#5A5A7A;
            --topbar-h:64px; --radius:12px; --radius-sm:8px;
        }
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
        .page-wrap{position:relative;z-index:1;padding:32px 28px;max-width:860px;margin:0 auto}
        .page-header{margin-bottom:28px}
        .page-header h1{font-family:'Outfit',sans-serif;font-size:1.8rem;font-weight:800;background:linear-gradient(135deg,#fff 0%,var(--warning) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .page-header p{color:var(--text-secondary);font-size:.9rem;margin-top:4px}
        .form-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:32px}
        .section-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)}
        .form-grid{display:grid;gap:20px;grid-template-columns:1fr 1fr}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group.full{grid-column:1/-1}
        label{font-size:.82rem;font-weight:600;color:var(--text-secondary)}
        label span.req{color:var(--danger)}
        input[type=text],input[type=number],select,textarea{background:rgba(255,255,255,.06);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;color:var(--text-primary);font-size:.875rem;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s,background .2s;width:100%}
        input:focus,select:focus,textarea:focus{border-color:var(--primary-light);background:rgba(255,255,255,.09)}
        input.is-invalid,select.is-invalid{border-color:var(--danger)}
        select option{background:#1a1a30}
        .error-msg{font-size:.78rem;color:var(--danger);margin-top:2px}
        .toggle-group{display:flex;flex-direction:column;gap:10px}
        .toggle-item{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border)}
        .toggle-label{font-size:.85rem;color:var(--text-secondary)}
        .toggle-desc{font-size:.75rem;color:var(--text-muted);margin-top:2px}
        .toggle-switch{position:relative;width:44px;height:24px;flex-shrink:0}
        .toggle-switch input{opacity:0;width:0;height:0}
        .toggle-track{position:absolute;inset:0;border-radius:999px;background:rgba(255,255,255,.1);border:1px solid var(--border);cursor:pointer;transition:all .25s}
        .toggle-thumb{position:absolute;top:3px;left:3px;width:16px;height:16px;border-radius:50%;background:var(--text-muted);transition:transform .25s,background .25s}
        .toggle-switch input:checked~.toggle-track{background:rgba(108,99,255,.3);border-color:var(--primary)}
        .toggle-switch input:checked~.toggle-track .toggle-thumb{transform:translateX(20px);background:var(--primary-light)}
        .perm-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
        .perm-card{display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 8px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border);cursor:pointer;transition:all .2s}
        .perm-card:has(input:checked){background:rgba(108,99,255,.1);border-color:var(--primary)}
        .perm-card input{display:none}
        .perm-icon{font-size:1.4rem}
        .perm-name{font-size:.75rem;font-weight:600;color:var(--text-secondary)}
        .perm-indicator{width:20px;height:20px;border-radius:5px;border:2px solid var(--border);background:transparent;transition:all .2s;display:flex;align-items:center;justify-content:center;font-size:.7rem}
        .perm-card:has(input:checked) .perm-indicator{border-color:var(--primary);background:var(--primary);color:#fff}
        .btn-row{display:flex;gap:12px;margin-top:28px;flex-wrap:wrap}
        .btn-primary{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:var(--radius-sm);background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;font-size:.9rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 15px rgba(108,99,255,.3);text-decoration:none}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(108,99,255,.4)}
        .btn-ghost{display:inline-flex;align-items:center;gap:8px;padding:12px 20px;border-radius:var(--radius-sm);background:transparent;color:var(--text-secondary);font-size:.9rem;font-weight:500;border:1px solid var(--border);cursor:pointer;transition:all .2s;text-decoration:none}
        .btn-ghost:hover{border-color:var(--border-accent);color:var(--text-primary)}
        .section-spacer{margin:28px 0;border:none;border-top:1px solid var(--border)}
        .alert{padding:14px 18px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:.9rem;display:flex;align-items:center;gap:10px}
        .alert-error{background:rgba(255,79,106,.1);border:1px solid rgba(255,79,106,.25);color:var(--danger)}
        .code-badge{font-family:'Courier New',monospace;font-size:.8rem;color:var(--primary-light);background:rgba(108,99,255,.12);border:1px solid rgba(108,99,255,.2);padding:2px 10px;border-radius:4px}
        @media(max-width:600px){.form-grid{grid-template-columns:1fr}.perm-grid{grid-template-columns:repeat(2,1fr)}.page-wrap{padding:20px 16px}}
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
    <span class="topbar-page">Edit</span>
    <div class="topbar-spacer"></div>
    <a href="{{ route('user-menus.index') }}" class="topbar-back">← Kembali</a>
</header>

<div class="page-wrap">
    <div class="page-header">
        <h1>✏️ Edit Menu User</h1>
        <p>Mengedit: <span class="code-badge">{{ $userMenu->code_menu }}</span> — {{ $userMenu->nama }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error" role="alert">✖ {{ $errors->first() }}</div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('user-menus.update', $userMenu) }}" id="form-edit-menu">
            @csrf @method('PUT')

            <div class="section-title">📋 Informasi Dasar</div>
            <div class="form-grid">

                <div class="form-group">
                    <label for="code_menu">Kode Menu <span class="req">*</span></label>
                    <input type="text" id="code_menu" name="code_menu"
                           value="{{ old('code_menu', $userMenu->code_menu) }}"
                           placeholder="MNU001"
                           class="{{ $errors->has('code_menu') ? 'is-invalid' : '' }}"
                           maxlength="50" required>
                    @error('code_menu') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="nama">Nama Menu <span class="req">*</span></label>
                    <input type="text" id="nama" name="nama"
                           value="{{ old('nama', $userMenu->nama) }}"
                           placeholder="Contoh: Dashboard, Kelola User..."
                           class="{{ $errors->has('nama') ? 'is-invalid' : '' }}"
                           maxlength="150" required>
                    @error('nama') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="parent_id">Parent Menu</label>
                    <select id="parent_id" name="parent_id"
                            class="{{ $errors->has('parent_id') ? 'is-invalid' : '' }}">
                        <option value="">— Tidak ada (Root) —</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}"
                                {{ old('parent_id', $userMenu->parent_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->code_menu }} — {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="icon">Icon</label>
                    <input type="text" id="icon" name="icon"
                           value="{{ old('icon', $userMenu->icon) }}"
                           placeholder="Emoji atau class icon, contoh: 🏠"
                           maxlength="100">
                    @error('icon') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label for="url">URL / Route</label>
                    <input type="text" id="url" name="url"
                           value="{{ old('url', $userMenu->url) }}"
                           placeholder="Contoh: /dashboard atau dashboard (route name)"
                           maxlength="255">
                    @error('url') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="sort_order">Urutan Tampil</label>
                    <input type="number" id="sort_order" name="sort_order"
                           value="{{ old('sort_order', $userMenu->sort_order) }}"
                           min="0" max="9999">
                    @error('sort_order') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

            </div>

            <hr class="section-spacer">

            <div class="section-title">⚙️ Konfigurasi Tampilan</div>
            <div class="toggle-group">
                <div class="toggle-item">
                    <div>
                        <div class="toggle-label">🏷️ Tampil sebagai Header / Divider</div>
                        <div class="toggle-desc">Menu ini akan menjadi judul grup, bukan link yang dapat diklik</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_header" value="0">
                        <input type="checkbox" id="is_header" name="is_header" value="1"
                               {{ old('is_header', $userMenu->is_header) ? 'checked' : '' }}>
                        <div class="toggle-track"><div class="toggle-thumb"></div></div>
                    </label>
                </div>

                <div class="toggle-item">
                    <div>
                        <div class="toggle-label">✅ Status Aktif</div>
                        <div class="toggle-desc">Menu yang aktif akan tampil di navigasi</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $userMenu->is_active) ? 'checked' : '' }}>
                        <div class="toggle-track"><div class="toggle-thumb"></div></div>
                    </label>
                </div>
            </div>

            <hr class="section-spacer">

            <div class="section-title">🔐 Hak Akses</div>
            <div class="perm-grid">

                <label class="perm-card" for="can_view">
                    <input type="hidden" name="can_view" value="0">
                    <input type="checkbox" id="can_view" name="can_view" value="1"
                           {{ old('can_view', $userMenu->can_view) ? 'checked' : '' }}>
                    <span class="perm-icon">👁️</span>
                    <span class="perm-name">View</span>
                    <span style="font-size:.7rem;color:var(--text-muted);text-align:center">Lihat data</span>
                    <div class="perm-indicator">✓</div>
                </label>

                <label class="perm-card" for="can_create">
                    <input type="hidden" name="can_create" value="0">
                    <input type="checkbox" id="can_create" name="can_create" value="1"
                           {{ old('can_create', $userMenu->can_create) ? 'checked' : '' }}>
                    <span class="perm-icon">➕</span>
                    <span class="perm-name">Create</span>
                    <span style="font-size:.7rem;color:var(--text-muted);text-align:center">Tambah data</span>
                    <div class="perm-indicator">✓</div>
                </label>

                <label class="perm-card" for="can_update">
                    <input type="hidden" name="can_update" value="0">
                    <input type="checkbox" id="can_update" name="can_update" value="1"
                           {{ old('can_update', $userMenu->can_update) ? 'checked' : '' }}>
                    <span class="perm-icon">✏️</span>
                    <span class="perm-name">Update</span>
                    <span style="font-size:.7rem;color:var(--text-muted);text-align:center">Ubah data</span>
                    <div class="perm-indicator">✓</div>
                </label>

                <label class="perm-card" for="can_delete">
                    <input type="hidden" name="can_delete" value="0">
                    <input type="checkbox" id="can_delete" name="can_delete" value="1"
                           {{ old('can_delete', $userMenu->can_delete) ? 'checked' : '' }}>
                    <span class="perm-icon">🗑️</span>
                    <span class="perm-name">Delete</span>
                    <span style="font-size:.7rem;color:var(--text-muted);text-align:center">Hapus data</span>
                    <div class="perm-indicator">✓</div>
                </label>

            </div>

            <div class="btn-row">
                <button type="submit" class="btn-primary" id="btn-update">💾 Perbarui Menu</button>
                <a href="{{ route('user-menus.index') }}" class="btn-ghost" id="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
