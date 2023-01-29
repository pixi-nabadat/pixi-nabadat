<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param Model $model
     * refernece to order im my database
     * Model between (Order , Reservation)
     */
    public function __construct(public Model $model,public $type = null)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return [];
    }
}
