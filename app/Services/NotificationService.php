<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\FollowingUser;


class NotificationService
{

    public function create(User $publisher, Model $model): Notification
    {
        $notification = new Notification;

        $notification->publish($publisher);

        if($model instanceof Comment){

            $to = $model->commentable()->author()->get();
            $notification->subscribe($to);
            $notification->comment()->associate($model);

        }else if($model instanceof Favorite){
            $notification->publish($model->user()->get());
            $notification->subscribe($model->note()->author()->get());
            $notification->favorite()->associate($model);
        }else if($model instanceof FollowingUser){
            $notification->publish($model->user);
            $notification->subscribe($model->followingUser);
            $notification->follow($model);
        }else{
            return null;
        }

        $notification = $notification->saveOrFail();

        // 将来的にはPush通知関連のQueueへのPush操作も実装する

        return $notification;


    }

}