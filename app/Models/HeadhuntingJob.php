<?php

namespace App\Models;

use App\Models\BaseModel;

class HeadhuntingJob extends BaseModel
{
    protected $fillable = ['job_id', 'category', 'company_id', 'user_id', 'superior', 'enterprise_scale', 'department_scale', 'main_business', 'salary', 'preference', 'office_location', 'education', 'experience', 'available_date', 'etc', 'reasons_for_suspension', 'redpack', 'status', 'type', 'commission'];
    protected $casts = ['tags' => 'array'];

    public function scopeAvailable($query)
    {
        return $query->whereStatus(0);
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'job_id', 'job_id')->mine();
    }

    public function getStatusCnAttribute()
    {
        switch ($this->status) {
            case 1:
                return "已成功";
            case -1:
                return "已失败";
            default:
                return "进行中";
        }
    }

    public function getTypeCnAttribute()
    {
        switch ($this->type) {
            case 1:
                return '普通猎招';
            case 2:
                return '快招职位';
            default:
                return '高端猎招';
        }
    }
}
