<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'hi_company';
    protected $visible = ['id', 'name', 'shortname', 'jobs'];
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'uid');
    }
    public function membersInfo()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job')->hunter();
    }
}
