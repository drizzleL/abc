<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOauth extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_user_oauth';
}
