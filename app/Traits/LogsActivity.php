<?php

namespace App\Traits;

use App\Events\ActivityLogged;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function booted()
    {
        static::created(function (Model $model) {
            event(new ActivityLogged(auth()->id(), 'create', get_class($model), $model->getKey()));
        });

        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            $original = $model->getOriginal();
         
            if (array_key_exists('status', $changes)) {
                $action = $changes['status'];
                $properties = [
                    'from' => $original['status'] ?? null,
                    'to'   => $changes['status'],
                ];
            } else {
                $action = "updated";
                $properties = $changes;
            }

            event(new ActivityLogged(
                auth()->id(),
                $action,
                get_class($model),
                $model->getKey(),
                $properties
            ));
        });

        static::deleted(function (Model $model) {
            event(new ActivityLogged(auth()->id(), 'delete', get_class($model), $model->getKey()));
        });
    }
}
