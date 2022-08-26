<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\AuthenticateRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Sing Up page.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup()
    {
        return view('register');
    }



    /**
     * Register a user to the system.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        try {
            $user = new User();
            $user->fill($data);
            $user->password = bcrypt($request->password);
            $user->save();

            // Authenticate User 
            auth()->login($user);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput($request->all())->withErrors(['error' => 'An error occured while registering.']);
        }

        return redirect()->route('surveys.dashboard');
    }

    /**
     * Authenticate user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(AuthenticateRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $remember = (isset($request->remember_me) && $request->remember_me == true) ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
