<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\MasterMenu;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * DashboardController — Post-authentication landing page.
 */
final class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     * Passes filtered menu items based on the user's group access.
     */
    public function index(Request $request): View
    {
        $user        = $request->user();
        $allowedMenus = MasterMenu::filter($user->allowedMenus());

        return view('dashboard.index', [
            'user'         => $user,
            'allowedMenus' => $allowedMenus,
        ]);
    }
}
