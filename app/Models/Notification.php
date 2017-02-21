<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'resource_type', 'resource_id', 'action_type'];
    protected $hidden = ['created_at', 'user_id'];

    public function record()
    {
        return $this->belongsTo('App\Models\RecommendRecord', 'resource_id');
    }
}
