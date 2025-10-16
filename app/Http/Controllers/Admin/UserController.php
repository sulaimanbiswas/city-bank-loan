<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $plans = \App\Models\Plan::where('status', 'active')->orderBy('name')->get(['name']);
        return view('admin.users.edit', [
            'user' => $user,
            'plans' => $plans,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'current_plan' => ['nullable', 'string', 'max:100', 'exists:plans,name'],
            'status' => ['required', 'in:active,inactive'],
            'user_type' => ['required', 'in:user,admin'],
        ]);

        $user->fill($validated);
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('status', 'User deleted');
    }

    public function toggle(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        return back()->with('status', 'User status updated');
    }

    public function impersonate(User $user)
    {
        // Save the admin id to session and login as user
        session(['impersonator_id' => Auth::id()]);
        Auth::login($user);
        return redirect()->route('user.dashboard')->with('status', 'You are now browsing as ' . $user->name);
    }
}
