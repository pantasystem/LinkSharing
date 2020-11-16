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
                    
        return $user->notifications()->with(
            [
                'publisher' => function($query) use ($me){
                    $query->select(
                        [
                            'users.*',
                            'is_follower' => function($query) use ($me){
                                $query->selectRaw('count(*)')
                                    ->from('following_users')
                                    ->whereRaw('following_users.user_id = users.id')
                                    ->where('following_users.following_user_id', '=', $me->id);

                                    
                            },
                            'is_following' => function($query) use ($me){
                                $query->selectRaw('count(*)')
                                    ->from('following_users')
                                    ->whereRaw('following_users.following_user_id = users.id')
                                    ->where('following_users.user_id', '=', $me->id);
                            }
                        ]
                    );
                }, 
                'comment', 
                'favorite.note',
                'favorite.note.summary', 
                'favorite.note.tags', 
                'follow',
                
                
            ]
        )->orderBy('id', 'desc')->simplePaginate();

    }

    public function read($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()
        ->with(
            [
                'publisher', 
                'subscriber', 
                'comment', 
                'favorite.note',
                'favorite.note.summary', 
                'favorite.note.tags', 
                'follow',
            ]
        )->findOrFail($notificationId);
        $notification->is_read = true;
        return $notification->save();
    }

    public function find($notificationId)
    {
        $user = Auth::user();
        return $user->notifications()
        ->with(
            [
                'publisher', 
                'subscriber', 
                'comment', 
                'favorite.note',
                'favorite.note.summary', 
                'favorite.note.tags', 
                'follow'
            ]
        )->findOrFail($notificationId);
    }

}
