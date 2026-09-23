<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MenuCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * MenuItemController — CRUD halaman menu restoran.
 */
final class MenuItemController extends Controller
{
    public function index(Request $request): View
    {
        $categories = MenuCategory::orderBy('sort_order')->get();
        $query      = MenuItem::with('category')->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('menu_category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menuItems = $query->get();

        return view('menu.index', compact('categories', 'menuItems'));
    }

    public function create(): View
    {
        $categories = MenuCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('menu.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'description'      => ['nullable', 'string'],
            'price'            => ['required', 'numeric', 'min:0'],
            'is_available'     => ['boolean'],
            'sort_order'       => ['integer', 'min:0'],
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);

        MenuItem::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(MenuItem $menu): View
    {
        $categories = MenuCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, MenuItem $menu): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'description'      => ['nullable', 'string'],
            'price'            => ['required', 'numeric', 'min:0'],
            'is_available'     => ['boolean'],
            'sort_order'       => ['integer', 'min:0'],
        ]);

        $validated['is_available'] = $request->boolean('is_available', false);

        $menu->update($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(MenuItem $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    /** Toggle ketersediaan menu (AJAX-friendly) */
    public function toggle(MenuItem $menu): RedirectResponse
    {
        $menu->update(['is_available' => ! $menu->is_available]);

        return back()->with('success', 'Status menu diperbarui.');
    }
}
