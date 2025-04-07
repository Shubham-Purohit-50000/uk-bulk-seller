<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RMLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $latitude;
    public $longitude;

    public function __construct($user_id, $latitude, $longitude)
    {
        $this->user_id = $user_id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function broadcastOn()
    {
        // return new PrivateChannel('rm-tracking.' . $this->user_id);
        return new Channel('rm-tracking_' . $this->user_id); // Public channel (no "private-" prefix)
    }
}
