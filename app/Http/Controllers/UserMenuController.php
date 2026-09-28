<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * UserMenuController — CRUD master data menu user.
 */
final class UserMenuController extends Controller
{
    public function index(Request $request): View
    {
        $query = UserMenu::with('parent')
            ->withTrashed(false)
            ->orderBy('sort_order')
            ->orderBy('code_menu');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code_menu', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        if ($request->filled('parent')) {
            $query->where('parent_id', $request->parent === 'root' ? null : $request->parent);
        }

        $userMenus = $query->get();
        $parents   = UserMenu::whereNull('parent_id')->orderBy('nama')->get();

        return view('user-menus.index', compact('userMenus', 'parents'));
    }

    public function create(): View
    {
        $parents = UserMenu::whereNull('parent_id')->orderBy('sort_order')->get();

        return view('user-menus.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMenu($request);

        UserMenu::create($validated);

        return redirect()->route('user-menus.index')
            ->with('success', "Menu \"{$validated['nama']}\" berhasil ditambahkan!");
    }

    public function show(UserMenu $userMenu): View
    {
        $userMenu->load('parent', 'children');

        return view('user-menus.show', compact('userMenu'));
    }

    public function edit(UserMenu $userMenu): View
    {
        $parents = UserMenu::whereNull('parent_id')
            ->where('id', '!=', $userMenu->id)
            ->orderBy('sort_order')
            ->get();

        return view('user-menus.edit', compact('userMenu', 'parents'));
    }

    public function update(Request $request, UserMenu $userMenu): RedirectResponse
    {
        $validated = $this->validateMenu($request, $userMenu->id);

        $userMenu->update($validated);

        return redirect()->route('user-menus.index')
            ->with('success', "Menu \"{$userMenu->nama}\" berhasil diperbarui!");
    }

    public function destroy(UserMenu $userMenu): RedirectResponse
    {
        $nama = $userMenu->nama;
        $userMenu->delete();

        return redirect()->route('user-menus.index')
            ->with('success', "Menu \"{$nama}\" berhasil dihapus.");
    }

    /** Toggle status aktif / non-aktif */
    public function toggle(UserMenu $userMenu): RedirectResponse
    {
        $userMenu->update(['is_active' => ! $userMenu->is_active]);

        $status = $userMenu->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Menu \"{$userMenu->nama}\" berhasil {$status}.");
    }

    // ── Private helpers ──────────────────────────────────────

    private function validateMenu(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code_menu'  => ['required', 'string', 'max:50',
                             \Illuminate\Validation\Rule::unique('user_menus', 'code_menu')->ignore($ignoreId)],
            'nama'       => ['required', 'string', 'max:150'],
            'parent_id'  => ['nullable', 'exists:user_menus,id'],
            'is_header'  => ['boolean'],
            'url'        => ['nullable', 'string', 'max:255'],
            'can_create' => ['boolean'],
            'can_update' => ['boolean'],
            'can_delete' => ['boolean'],
            'can_view'   => ['boolean'],
            'is_active'  => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            'icon'       => ['nullable', 'string', 'max:100'],
        ]);
    }
}
