<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

        // Display home page with products and categories
    public function home()
    {
        $user = auth()->user();
        $cartItemCount = $user ? $user->cartItems()->count() : 0;
        $wishlistItems = $user ? Wishlist::where('user_id', $user->id)->get() : collect();
        $wishlistCount = $wishlistItems->count();

        session(['cartItemCount' => $cartItemCount]);

        $products = Product::all();
        $categories = Category::all();

        return view('index', compact('products', 'wishlistItems', 'wishlistCount', 'categories'));
    }
    
    // Display the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Display the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    // Handle user login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email not found.'])
                ->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return redirect()->back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->withInput();
        }

        return redirect()->intended('/');
    }

    // Validate registration data
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Handle user logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
