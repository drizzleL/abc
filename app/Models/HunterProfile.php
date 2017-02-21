<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HunterProfile extends Model
{
    protected $casts = ['images' => 'json'];
    protected $fillable = [
        'file_name', 'file_url', 'user_id', 'remark', 'id_url', 'agreement_url'
    ];
}
