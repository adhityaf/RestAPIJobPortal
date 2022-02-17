<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyApplicationStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $status;
    public $position;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $status, $position)
    {
        $this->name = $name;
        $this->status = $status;
        $this->position = $position;
		$this->message  = "Company {$name} change your application to {$status} as {$position}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notify-application-status-change-to');
    }
}
