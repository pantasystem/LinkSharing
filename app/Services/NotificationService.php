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

        if($model instanceof Comment){

            $to = $model->commentable()->author()->get();
            $notification->subscribe($to);
            $notification->comment()->associate($model);
            $notification->type = 'comment';

        }else if($model instanceof Favorite){
            $note = $model->note()->first();
            if($publisher->id === $note->author()->first()->id){
                return null;
            }
            $notification->subscribe($note->author()->first());
            $notification->favorite()->associate($model);
            $notification->type = 'favorite';
        }else if($model instanceof FollowingUser){
            $notification->subscribe($model->followingUser);
            $notification->follow()->associate($model);
            $notification->type = 'follow';
        }else{
            return null;
        }

        $notification->save();
        return Notification::findOrFail($notification->id);



    }

}