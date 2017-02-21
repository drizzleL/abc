<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $fillbale = [];
    public function getDescSimpleAttribute()
    {
        $desc = $this->attributes['desc'];
        $desc_simple = $desc;
        return $desc_simple;
    }
}
