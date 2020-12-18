<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Note;
use App\Models\User;

class TimelineUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriberId;
    public $noteId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Note $note, User $subscriber)
    {
        //
        $this->noteId = $note->id;
        $this->subscriberId = $subscriber->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('timeline.streaming.' . $this->subscriberId);
    }
}
