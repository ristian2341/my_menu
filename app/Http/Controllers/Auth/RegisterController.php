<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\Auth\DTOs\RegisterDTO;
use App\Application\Auth\UseCases\RegisterUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * RegisterController — Thin presentation layer controller.
 *
 * Delegates all business logic to RegisterUseCase.
 * Responsible only for HTTP request/response handling.
 */
final class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterUseCase $registerUseCase,
    ) {}

    /**
     * Display the registration view.
     */
    public function show(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->registerUseCase->execute(
                RegisterDTO::fromArray($request->validated()),
            );
        } catch (\DomainException $e) {
            return back()
                ->withInput($request->only('name', 'email'))
                ->withErrors(['email' => $e->getMessage()]);
        }

        return redirect()->route('dashboard');
    }
}
