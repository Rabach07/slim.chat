<?php

namespace App\Events;

use App\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class ConversationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new Channel('businesses.'.$this->conversation->business->id.'.conversations'),
            new Channel('conversations.'.$this->conversation->id),
        ];
    }
}
