<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',                                         
        'description',
        'key',
        'value'                                                                 
    ];

    
    /**
     * getIdleTimeout
     *
     * @return int
     */
    public static function getIdleTimeout(): int
    {
        return (int) self::where('key', 'idle_timeout')->value('value') ?? 5;
    }

}
