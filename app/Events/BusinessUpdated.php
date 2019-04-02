<?php

namespace App\Events;

use App\Business;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class BusinessUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $business;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('businesses.'.$this->business->id);
    }
}
