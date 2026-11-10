<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Display shared login page
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole();
        }

        return view('auth.login');
    }

    // Handle customer or admin login
    public function store(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regenerate session after successful login
        $request->session()->regenerate();

        return $this->redirectForRole();
    }

    // Logout customer or admin
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Redirect based on account role
    private function redirectForRole(): RedirectResponse
    {
        return redirect()->route(
            Auth::user()->role === 'admin'
                ? 'admin.dashboard'
                : 'account'
        );
    }
}
