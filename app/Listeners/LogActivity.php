<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;
use App\Events\ActivityLogged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ActivityLogged $event): void
    {
        ActivityLog::create([
            'user_id' => $event->userId,
            'action' => $event->action,
            'model_id' => $event->model_id,
            'model_type' => $event->model_type,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'properties' => $event->properties ? json_encode($event->properties) : null,
        ]);
    }
}
