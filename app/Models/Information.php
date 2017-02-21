<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Information extends BaseModel
{
    protected $fillable = ['company_name', 'remark', 'contact_name', 'contact_title', 'contact_mobile', 'contact_email', 'is_secret'];
    protected $casts = ['progress' => 'array'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'company_id', 'company_id')
            ->whereType(1);
    }
    public function getStatusCnAttribute()
    {
        switch ($this->status) {
            case 0:
                return '待跟进';
            case 1:
                return '已签约职位';
            default:
                return '失败';
        }
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
