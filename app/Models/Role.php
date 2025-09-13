<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'idle_monitoring',                                                              
    ];
}
