<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MembersInfo;

class Member extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_users';
    protected $primaryKey = 'uid';
    protected $fillable = ['email', 'mobile'];
    protected $dateFormat = 'U';
    protected $hidden = ['password', 'pwd_hash'];

    // 最后更新简历时间
    public function refreshtime()
    {
        return $this->hasOne('App\Models\Resume', 'uid')->latest('updated_at');
    }
    public function resumes()
    {
        return $this->hasMany('App\Models\Resume', 'uid')->latest('updated_at');
    }
    public function getRegTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
    public function membersInfo()
    {
        return $this->hasOne('App\Models\MembersInfo', 'uid');
    }

    public function existsOrCreate($mobile, $request)
    {
        $member = $this->firstOrCreate(['mobile' => $mobile]);
        if ($member->email == '') {
            $member->email = $request->email;
            $member->save();
        }
        $member_info = MembersInfo::firstOrCreate(['uid' => $member->uid]);
        if ($member_info->realname == '') {
            $member_info->realname = $request->realname;
            $member_info->save();
        }
        return $member;
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'uid');
    }
}
