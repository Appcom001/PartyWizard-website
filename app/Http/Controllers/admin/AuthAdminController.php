<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthAdminController extends Controller
{
    // Show the admin dashboard with optional time range filter
    public function showDashboard(Request $request)
    {
        $query = Order::query();
        
        if ($request->has('time_range')) {
            $now = now();
            switch ($request->time_range) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'last-7-days':
                    $query->whereBetween('created_at', [$now->subDays(7)->startOfDay(), $now->endOfDay()]);
                    break;
                case 'last-month':
                    $query->whereBetween('created_at', [$now->subMonth()->startOfDay(), $now->endOfDay()]);
                    break;
            }
        }
    
        $orders = $query->get();
    
        $totalSales = $orders->sum('total_amount'); 
        $totalReturns = $orders->sum(function($order) {
            return max($order->total_amount - $order->sub_total, 0);
        });
        $totalSalesIncome = $orders->sum('sub_total'); 
    
        $reviews = session('reviews') ?? ProductReview::with('user')->get();
        $averageRating = $reviews->isNotEmpty() ? $reviews->avg('rate') : 0;
        
        return view('admin.dashboard', compact('reviews', 'averageRating', 'orders', 'totalSales', 'totalReturns', 'totalSalesIncome'));
    }
    
    // Show the admin registration form
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    // Register a new admin
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'company_legal_name' => 'required|string|max:255',
            'company_phone_number' => 'required|string|max:255',
            'full_address' => 'required|string',
            'trade_licence' => 'nullable|file',
            'national_id' => 'nullable|file',
            'beneficiary_name' => 'required|string|max:255',
            'payoneer_email' => 'nullable|string|email|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'iban_number' => 'required|string|max:255',
            'swift_code' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'tax_registration_number' => 'required|string|max:255',
            'tax_registration_certificate' => 'nullable|file',
            'password' => 'required|string',
            'vat_agreement' => 'accepted',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $admin = Admin::create([
            'country' => $request->country,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'store_name' => $request->store_name,
            'company_legal_name' => $request->company_legal_name,
            'company_phone_number' => $request->company_phone_number,
            'full_address' => $request->full_address,
            'beneficiary_name' => $request->beneficiary_name,
            'payoneer_email' => $request->payoneer_email,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'iban_number' => $request->iban_number,
            'swift_code' => $request->swift_code,
            'currency' => $request->currency,
            'tax_registration_number' => $request->tax_registration_number,
            'password' => Hash::make($request->password),
        ]);
    
        $folderName = $admin->email; 
        $storagePath = "public/admins/{$folderName}";
    
        $tradeLicencePath = null;
        $nationalIdPath = null;
        $taxCertificatePath = null;
    
        if ($request->hasFile('trade_licence')) {
            $tradeLicencePath = $request->file('trade_licence')->store("{$storagePath}/trade_licences");
        }
    
        if ($request->hasFile('national_id')) {
            $nationalIdPath = $request->file('national_id')->store("{$storagePath}/national_ids");
        }
    
        if ($request->hasFile('tax_registration_certificate')) {
            $taxCertificatePath = $request->file('tax_registration_certificate')->store("{$storagePath}/tax_certificates");
        }
    
        $admin->update([
            'trade_licence' => $tradeLicencePath,
            'national_id' => $nationalIdPath,
            'tax_registration_certificate' => $taxCertificatePath,
        ]);
    
        Auth::guard('admin')->login($admin);
    
        return redirect()->route('admin.dashboard');
    }

    // Show the admin login form
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $reviews = ProductReview::with('user')->get();
    
            session(['reviews' => $reviews]);
    
            return redirect()->intended(route('admin.dashboard'));
        }
    
        return redirect()->back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Handle admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.showlogin');
    }
}
