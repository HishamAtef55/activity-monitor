<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\ActivityLogged;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->logUserIdleSession($request);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    /**
     * logoutInactivity
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutInactivity(Request $request): JsonResponse
    {
        $request->user()->penalties()->create([
            'reason' => 'inactivity',
            'date' => now(),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out due to inactivity',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }


    /**
     * logUserIdleSession
     *
     * @param  Request $request
     * @return void
     */
    private function logUserIdleSession(Request $request): void
    {
        array_map(function ($type) use ($request) {
            event(new ActivityLogged($request->user()->id, $type));
        }, [
            'login',
            'idle_session'
        ]);
    }
}
