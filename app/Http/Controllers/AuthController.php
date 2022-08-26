<?php

namespace App\Http\Controllers;

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
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agreement' => ['required'],
        ]);

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
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile')->with(['item' => auth()->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        # Validation
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'nullable|min:8',
            'new_password' => 'nullable|min:8|confirmed',
        ]);



        #Match The Old Password
        if (isset($request->current_password) && isset($request->new_password) && !Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(["error" => "Old Password Doesn't match!"]);
        }

        $data = ['email' => $request->email];
        if (isset($request->current_password) && isset($request->new_password))
            $data['password'] = Hash::make($request->new_password);

        #Update the user
        User::find(auth()->user()->id)->update($data);

        return back()->with("success", "Data updated successfully!");
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
