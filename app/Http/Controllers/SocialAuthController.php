<?php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialAuthController extends Controller
    {
        // Google login
        public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }
    
        public function handleGoogleCallback()
        {
            try {
                $user = Socialite::driver('google')->user();
                $existingUser = User::where('email', $user->getEmail())->first();
                
                if ($existingUser) {
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'google_id' => $user->getId(),
                        'avatar' => $user->getAvatar(),
                        'password' => bcrypt(Str::random(16)),
                    ]);
    
                    Auth::login($newUser);
                }
    
                return redirect()->route('home');
            } catch (Exception $e) {
                Log::error('Google login error: ' . $e->getMessage());
                return redirect('/login')->withErrors('An error occurred during Google login.');
            }
        }
    
        // Facebook login
        public function redirectToFacebook()
        {
            return Socialite::driver('facebook')->redirect();
        }
    
        public function handleFacebookCallback()
        {
            try {
                $user = Socialite::driver('facebook')->user();
                $existingUser = User::where('email', $user->getEmail())->first();
                
                if ($existingUser) {
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'facebook_id' => $user->getId(),
                        'avatar' => $user->getAvatar(),
                        'password' => bcrypt(Str::random(16)),
                    ]);
    
                    Auth::login($newUser);
                }
    
                return redirect()->route('home');
            } catch (Exception $e) {
                Log::error('Facebook login error: ' . $e->getMessage());
                return redirect('/login')->withErrors('An error occurred during Facebook login.');
            }
        }
    
        // Twitter login 
        public function redirectToTwitter()
        {
            return Socialite::driver('twitter')->redirect();
        }
    
        public function handleTwitterCallback()
        {
            try {
                $user = Socialite::driver('twitter')->user();
                $existingUser = User::where('email', $user->getEmail())->first();
                
                if ($existingUser) {
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'twitter_id' => $user->getId(),
                        'avatar' => $user->getAvatar(),
                        'password' => bcrypt(Str::random(16)),
                    ]);
    
                    Auth::login($newUser);
                }
    
                return redirect()->route('home');
            } catch (Exception $e) {
                Log::error('Twitter login error: ' . $e->getMessage());
                return redirect('/login')->withErrors('An error occurred during Twitter login.');
            }
        }
    }
    

