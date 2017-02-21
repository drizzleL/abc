<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersInfo extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_user_profile';
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $dateFormat = 'U';

    protected $fillable = ['uid', 'realname', 'company', 'position'];
}
