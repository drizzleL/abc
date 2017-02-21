<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Group extends BaseModel
{
    protected $fillable = ['name', 'user_id', 'is_real', 'description'];
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'groups_users')->withPivot('created_at');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function usersCount()
    {
        return $this->hasOne('App\Models\GroupUser')
            ->selectRaw('group_id, count(*) as aggregate')->groupBy('group_id');
    }
}
