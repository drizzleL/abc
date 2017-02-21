<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Application extends BaseModel
{
    protected $fillable = ['uid', 'cn_name', 'en_name', 'type', 'wechat', 'city', 'specialty'];
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'uid');
    }
    public function membersInfo()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid');
    }

    public function getStatusCnAttribute()
    {
        switch ($this->attributes['status']) {
            case 1:
                return '审核通过';
            case 2:
                return '待审核';
            case 3:
                return '审核不通过';
            default:
                return '未知';
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'uid', 'uid');
    }
}
