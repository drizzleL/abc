<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resumefile extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_resumefiles';
    protected $dateFormat = 'U';

    public function candidate()
    {
        return $this->belongsTo('App\Models\Member', 'resume_uid');
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\Member', 'uid')->select(array('uid', 'mobile', 'email'));
    }
    public function ownerName()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid', 'uid');
    }

    public function uploader()
    {
        return $this->belongsTo('App\Models\Member', 'uid')->select(array('uid', 'mobile', 'email'));
    }

    public function openid()
    {
        return $this->belongsTo('App\Models\UserOauth', 'uid', 'uid')->whereType('wx_openid');
    }
    public function isThumbedUp($user_id)
    {
        return $this->HasOne('App\Models\ThumbUpRecord', 'resumefile_id')->where('user_id', $user_id);
    }

}
