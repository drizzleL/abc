<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_user_token';
    public $timestamp = false;

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'uid');
    }
}
