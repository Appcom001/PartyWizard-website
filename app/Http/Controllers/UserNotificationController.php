<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $types = ['Product Updates', 'Comments', 'Checkout Product'];
        foreach ($types as $type) {
            $enabled = $request->has(strtolower(str_replace(' ', '_', $type))); 
            UserNotification::updateOrCreate(
                ['user_id' => $user->id, 'type' => $type],
                ['enabled' => $enabled]
            );
        }
        return redirect()->back()->with('success', 'Notifications updated successfully');
    }
}
