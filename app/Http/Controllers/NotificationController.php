<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;



class NotificationController extends Controller
{
    
    public function notifications()
    {
        $user = Auth::user();

        $me = auth('sanctum')->user();
                    
        return $user->notifications()->withDetail($me)->orderBy('id', 'desc')->simplePaginate();

    }

    public function read($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()
        ->withDetail($user)->findOrFail($notificationId);
        $notification->is_read = true;
        return $notification->save();
    }

    public function find($notificationId)
    {
        $user = Auth::user();
        return $user->notifications()
        ->withDetail($user)->findOrFail($notificationId);
    }

}
