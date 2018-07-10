<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Component extends Authenticatable
{

    protected $table = 'components';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'options',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function widgets() {
        return $this->belongsToMany('App\Widgets', 'widget_component', 'component_id', 'widget_id');
    }

    public function saveOptionsAttribute($value) {
        return serialize($value);
    }

    public function getOptionsAttribute($value) {
        return unserialize($value);
    }
}
