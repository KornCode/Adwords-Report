<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
	protected $table = 'umeta';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'meta_key', 'meta_value',
    ];
}
