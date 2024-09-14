<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // Display the password reset request form
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Send a password reset link to the given user
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return view('auth.passwords.check');
        } else {
            return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    // Display the password reset form
    public function showResetForm(Request $request, $token = null)
    {
        if (!$token) {
            return redirect()->route('password.request')->withErrors(['token' => 'Invalid or missing token.']);
        }

        $email = $request->input('email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Email address is required.']);
        }

        return view('auth.passwords.reset')->with(['token' => $token, 'email' => $email]);
    }

    // Reset the given user's password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return view('auth.passwords.done'); 
        } else {
            return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }
}
