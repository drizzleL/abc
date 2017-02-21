<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThumbUpRecord extends Model
{
    protected $fillable = ['user_id', 'resumefile_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
