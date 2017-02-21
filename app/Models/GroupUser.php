<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'groups_users';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['user_id', 'group_id'];
}
