<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WidgetComponent extends Authenticatable
{

    protected $table = 'widget_component';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'widget_id', 'component_id', 'options',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function saveOptionsAttribute($value) {
        return serialize($value);
    }

    public function getOptionsAttribute($value) {
        return unserialize($value);
    }
}
