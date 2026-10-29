<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LogoutController
 *
 * Logout Controller.
 */
class LogoutController extends Controller
{
    /**
     * Handle global web logout.
     * @param Request $request
     */
    public function logout(Request $request)
    {
        // Logout from all possible guards
        Auth::logout();
        Auth::guard('web')->logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUri = $request->input('redirect_uri', config('app.frontend_url'));

        if ($redirectUri) {
            return redirect()->to($redirectUri);
        }

        return redirect('/');
    }
}
