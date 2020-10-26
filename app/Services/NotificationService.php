<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;



class NotificationService
{
    
    public function create(User $publisher, User $subscriber, Model $model)
    {
        $notification = new Notification;
        $notification->publish($publisher);
        $notification->subscribe($subscriber);

        $model->notificable()->save($notification);
    }
}