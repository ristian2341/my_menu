<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use App\Support\MasterMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * UserGroupController — Kelola group akses user.
 */
final class UserGroupController extends Controller
{
    public function index(): View
    {
        $groups = UserGroup::withCount('users')->orderBy('name')->get();

        return view('groups.index', compact('groups'));
    }

    public function create(): View
    {
        $masterMenu = MasterMenu::all();
        $users      = User::orderBy('name')->get();

        return view('groups.create', compact('masterMenu', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:500'],
            'allowed_menus' => ['nullable', 'array'],
            'allowed_menus.*' => ['string', 'in:' . implode(',', array_keys(MasterMenu::all()))],
            'users'         => ['nullable', 'array'],
            'users.*'       => ['exists:users,id'],
        ]);

        $group = UserGroup::create([
            'name'          => $validated['name'],
            'description'   => $validated['description'] ?? null,
            'allowed_menus' => $validated['allowed_menus'] ?? [],
        ]);

        if (! empty($validated['users'])) {
            $group->users()->sync($validated['users']);
        }

        return redirect()->route('groups.index')
            ->with('success', "Group \"{$group->name}\" berhasil dibuat!");
    }

    public function edit(UserGroup $group): View
    {
        $masterMenu   = MasterMenu::all();
        $users        = User::orderBy('name')->get();
        $assignedIds  = $group->users()->pluck('users.id')->toArray();

        return view('groups.edit', compact('group', 'masterMenu', 'users', 'assignedIds'));
    }

    public function update(Request $request, UserGroup $group): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:500'],
            'allowed_menus' => ['nullable', 'array'],
            'allowed_menus.*' => ['string', 'in:' . implode(',', array_keys(MasterMenu::all()))],
            'users'         => ['nullable', 'array'],
            'users.*'       => ['exists:users,id'],
        ]);

        $group->update([
            'name'          => $validated['name'],
            'description'   => $validated['description'] ?? null,
            'allowed_menus' => $validated['allowed_menus'] ?? [],
        ]);

        $group->users()->sync($validated['users'] ?? []);

        return redirect()->route('groups.index')
            ->with('success', "Group \"{$group->name}\" berhasil diperbarui!");
    }

    public function destroy(UserGroup $group): RedirectResponse
    {
        $group->delete();

        return redirect()->route('groups.index')
            ->with('success', 'Group berhasil dihapus.');
    }
}
