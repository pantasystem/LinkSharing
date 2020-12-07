<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\FollowingUser;
use App\Models\User;


class NotificationService
{

    public function create(User $publisher, Model $model): ?Notification
    {
        $notification = new Notification;

        $notification->publish($publisher);

        $subscriber;

        if($model instanceof Comment){

            $to = $model->commentable()->author()->get();
            $subscriber = $to;
            $notification->comment()->associate($model);
            $notification->type = 'comment';

        }else if($model instanceof Favorite){
            $note = $model->note()->first();
            
            $subscriber = $note->author()->first();
            $notification->favorite()->associate($model);
            $notification->type = 'favorite';
        }else if($model instanceof FollowingUser){
            $subscriber = $model->followingUser;
            $notification->follow()->associate($model);
            $notification->type = 'follow';
        }else{
            return null;
        }

        $notification->subscribe($subscriber);
        if($subscriber->id === $publisher->id){
            return null;
        }

        $notification->save();
        return Notification::findOrFail($notification->id);



    }

}