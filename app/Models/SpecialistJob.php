<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class SpecialistJob extends BaseModel
{
    protected $fillable = ['user_id', 'job_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
