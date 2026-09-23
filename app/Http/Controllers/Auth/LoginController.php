<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\Auth\DTOs\LoginDTO;
use App\Application\Auth\UseCases\LoginUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * LoginController — Thin presentation layer controller.
 *
 * Delegates all business logic to LoginUseCase.
 * Responsible only for HTTP request/response handling.
 */
final class LoginController extends Controller
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase,
    ) {}

    /**
     * Display the login view.
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $this->loginUseCase->execute(
                LoginDTO::fromArray($request->validated()),
            );
        } catch (\DomainException $e) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => $e->getMessage()]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
