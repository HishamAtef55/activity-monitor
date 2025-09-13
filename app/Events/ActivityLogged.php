<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $userId;
    public $action;
    public $model_type;
    public $model_id;
    public $properties;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $action, $model_type = null, $model_id = null,  $properties = null)
    {
        $this->userId = $userId;
        $this->action = $action;
        $this->model_type = $model_type;
        $this->model_id = $model_id;
        $this->properties = $properties;
    }

}
