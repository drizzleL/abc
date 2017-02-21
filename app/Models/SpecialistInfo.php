<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialistInfo extends Model
{
    public $table = 'specialist_info';
    protected $fillable = ['user_id'];
}
