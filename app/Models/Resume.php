<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use SoftDeletes;

    protected $date = ['deleted_at'];
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_resumes';
    protected $casts = ['tags' => 'array'];
    protected $dateFormat = 'U';

    public function workExps()
    {
        return $this->hasMany('App\Models\ResumeWorkExp', 'rid');
    }

    public function eduExps()
    {
        return $this->hasMany('App\Models\ResumeEduExp', 'rid');
    }
    public function profile()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid');
    }
    // 简历用户
    public function user()
    {
        return $this->belongsTo('App\Models\Member', 'uid');
    }

    // 对应的简历文件
    public function resumefile()
    {
        return $this->belongsTo('App\Models\Resumefile');
    }
}
