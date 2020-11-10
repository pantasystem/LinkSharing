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
        return $user->notifications()->with(['publisher', 'subscriber', 'comment', 'favorite', 'follow'])->simplePaginate();
    }

    public function read($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()
            ->with(['publisher', 'subscriber', 'comment', 'favorite', 'follow'])->findOrFail($notificationId);
        $notification->is_read = true;
        return $notification->save();
    }

    public function find($notificationId)
    {
        $user = Auth::user();
        return $user->notifications()
            ->with(['publisher', 'subscriber', 'comment', 'favorite', 'follow'])->findOrFail($notificationId);
    }

}
