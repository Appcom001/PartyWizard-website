<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    // Display settings page with tabs
    public function showSetting()
    {
        $admin = Auth::guard('admin')->user(); 
        return view('admin.setting', compact('admin'));
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'The current password is incorrect.']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password updated successfully.');
    }

    // Update email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->email = $request->email;
        $admin->save();

        return back()->with('success', 'Email updated successfully.');
    }

    // Update seller details
    public function updateSellerDetails(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'company_legal_name' => 'required|string|max:255',
            'company_phone_number' => 'required|string|max:20',
            'full_address' => 'required|string|max:1000',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->first_name = $request->input('first_name');
        $admin->last_name = $request->input('last_name');
        $admin->store_name = $request->input('store_name');
        $admin->company_legal_name = $request->input('company_legal_name');
        $admin->company_phone_number = $request->input('company_phone_number');
        $admin->full_address = $request->input('full_address');
        $admin->save();

        return redirect()->back()->with('success', 'Seller details updated successfully.');
    }

    // Update bank details
    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'beneficiary_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'payoneer_email' => 'required|email|max:255',
            'iban_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'swift_code' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->beneficiary_name = $request->beneficiary_name;
        $admin->account_number = $request->account_number;
        $admin->payoneer_email = $request->payoneer_email;
        $admin->iban_number = $request->iban_number;
        $admin->bank_name = $request->bank_name;
        $admin->swift_code = $request->swift_code;
        $admin->branch_name = $request->branch_name;
        $admin->currency = $request->currency;
        $admin->save();

        return back()->with('success', 'Bank details updated successfully.');
    }
}
