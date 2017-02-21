<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['additional_id', 'type', 'token'];
    public function scopeVerify($query, $type, $id, $token)
    {
        return $query->where('type', $type)->where('additional_id', $id)->where('token', $token);
    }
}
