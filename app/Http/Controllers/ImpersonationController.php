<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ImpersonationController extends Controller
{
    public function stop(): RedirectResponse
    {
        $impersonatorId = session('impersonator_id');
        if ($impersonatorId) {
            Auth::logout();
            session()->forget('impersonator_id');
            Auth::loginUsingId($impersonatorId);
            return redirect()->route('admin.dashboard')->with('status', 'Returned to admin');
        }
        return redirect()->back();
    }
}
