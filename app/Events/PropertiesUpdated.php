<?php

namespace App\Events;

use App\Visitor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class PropertiesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $visitor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('businesses.'.$this->visitor->business->id.'.visitors.'.$this->visitor->id.'.properties');
    }
}
