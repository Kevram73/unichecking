<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function login_get(Request $request)
    {
        return view("auth.login");
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function params(Request $request)
    {
        $user = Auth::user();
        $universites = Universite::all();
        $years = Annee::all();
        return view('users.params', compact('user', 'universites', 'years'));
    }

    public function params_store(Request $request)
    {
        Session::put('academic', $request->academic);
        Session::put('university', $request->university);

        return redirect()->back();
    }

    /**
     * Handle login attempt.
     */
    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index');
        }

        return back()->with([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Show the form for password recovery.
     */
    public function forget_pwd_get()
    {
        return view("auth.passwords.email");
    }

    /**
     * Send a reset link to the given user.
     */

    public function forget_pwd_post(Request $request){
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->get();

        if(count($user) == 0){
            return redirect()->back()->with('error', "Aucun compte n'est associé à cet email.");
        }
        $myAccount = $user->first();
        $token = Str::random(60);
        $myAccount->remember_token = $token;
        $myAccount->save();
        $mailData = [
            "name" => $myAccount->username,
            "token" => $token,
        ];

        Mail::to($request->email)->send(new UserMail($mailData));
        return redirect()->back()->with('success', "Un courriel vous a été envoyé.");
    }

    /**
     * Show the reset password form.
     */
    public function reset_pwd_get(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Handle password reset.
     */
    public function reset_pwd_post(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->get()->first();
        if($request->token != $user->remember_token){
            return redirect()->back()->with('error', "Modification non autorisée");
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login')->with('success', "Veuillez vous connecter.");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
