<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class SpecialistCompany extends BaseModel
{
    protected $table = 'specialist_company';
    protected $fillable = ['user_id', 'company_id'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    // 已审核职位数量
    public function auditedJobsCount()
    {
        return $this->hasOne('App\Models\Job', 'company_id', 'company_id')
            ->companyCountWithAudit(1);
    }
    // 未审核职位数量
    public function unauditedJobsCount()
    {
        return $this->hasOne('App\Models\Job', 'company_id', 'company_id')
            ->companyCountWithAudit(0);
    }
    // 审核失败职位数量
    public function failedJobsCount()
    {
        return $this->hasOne('App\Models\Job', 'company_id', 'company_id')
            ->companyCountWithAudit(2);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
