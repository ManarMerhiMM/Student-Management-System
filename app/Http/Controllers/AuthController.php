<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validate the login form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_deactivated) {
                Auth::logout();
                return back()->withInput()->withErrors([
                    'email' => 'Your account has been deactivated :/',
                ]);
            }

            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended('/dashboard'); // Or home page after login
        }

        // If auth fails, redirect back with error
        return back()->withInput()->withErrors([
            'email' => 'Incorrect email/password',
            'password' => 'Incorrect email/password',
        ]);
    }



    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:10', 'confirmed', 'regex:/[0-9]/'],
        ], [
            'password.min' => 'Password must be at least 10 characters long.',
            'password.regex' => 'Password must contain at least one number.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login');
    }

    public function index(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $query = User::where('is_admin', false);

        if ($request->has('search') && $request->search !== null) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        $users = $query->orderBy('id', 'asc')->get();

        return view('users.index', compact('users'));
    }


    public function deactivateUser(User $user)
    {
        // Only allow admins
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        // Prevent deactivating admin users (optional)
        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Cannot deactivate admin users.');
        }

        $user->is_deactivated = true;
        $user->save();

        return redirect()->back()->with('success', 'User deactivated successfully.');
    }

    // Activate user
    public function activateUser(User $user)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $user->is_deactivated = false;
        $user->save();

        return redirect()->back()->with('success', 'User activated successfully.');
    }
}
