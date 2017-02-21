<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class Job extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'mysql2';
    protected $dates = ['deleted_at'];
    protected $table = 'hi_jobs';
    protected $dateFormat = 'U';
    protected $hidden = ['redpack_total', 'redpack_balance', 'reward_balance', 'reward_total', 'reward_balance', 'reward_bonus', 'robot', 'shares', 'uid', 'experience_search', 'nature', 'wx_desc', 'wx_title', 'clicks', 'deleted_at', 'audit', 'deadline', 'type'];
    protected $transform = [
        'tags'     => 'array:,',
        'district' => 'array:,',
        'address'  => 'array:,',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('isstop', '0')->where('deadline', '>', time());
    }
    // 猎头职位
    public function scopeHunter($query)
    {
        return $query->where('hi_jobs.type', '>', 0);
    }
    // 是否审核
    public function scopeIsAudit($query, $audit = 0)
    {
        if (is_null($audit)) $audit = 0;
        return $query->where('audit', $audit);
    }

    public function getAddtimeCnAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['created_at']);
    }
    public function getRefreshtimeCnAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['updated_at']);
    }
    public function getDeadlineCnAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['deadline']);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function order()
    {
        return $this->hasOne('App\Models\Order')->mine();
    }
    public function ordersCount()
    {
        return $this->hasOne('App\Models\Order')->selectRaw('job_id, count(*) as aggregate')->groupBy('job_id');
    }

    public function records()
    {
        return $this->hasMany('App\Models\RecommendRecord');
    }

    public function recordsCount()
    {
        return $this->hasOne('App\Models\RecommendRecord')->selectRaw('job_id, count(*) as aggregate')->groupBy('job_id');
    }

    // 地区城市
    public function getAreasAttribute()
    {
        $district = $this->district;
        $address = $this->address;
        $size = count($district);
        $areas = [];
        for ($i = 0; $i < $size; $i++) {
            $areas[] = $district[$i] .' '. $address[$i];
        }
        return $areas;
    }
    public function getContentsAttribute($value)
    {
        preg_match_all("/<section[ ]?[^\>]*?\>(.*?)\<\/section\>/", $value, $t);
        if (isset($t[1]) && !isset($t[1][0])) {
            return $value;
        }
        return isset($t[1]) ? $t[1][0] : '';
    }

    // 是否显示公司信息
    public function getShowCompanyCnAttribute()
    {
        return $this->show_company ? '显示企业信息' : '不显示企业信息';
    }

    // 是否验证通过
    public function getAuditCnAttribute()
    {
        switch ($this->audit) {
            case '1':
                return '已审核';
            case '2':
                return '审核不通过';
            default:
                return '未审核';
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    // 职位发布者用户
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'uid');
    }
    // 职位发布者信息
    public function membersInfo()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid', 'uid');
    }

    public function details()
    {
        return $this->hasOne('App\Models\HeadhuntingJob');
    }

    public function reason()
    {
        return $this->hasOne('App\Models\AuditReason', 'belong')
            ->whereType('hunter_job')->latest();
    }

    public function isTrashed()
    {
        return $this->trashed() ? '（已删除）' : '';
    }

    public function scopeCompanyCountWithAudit($query, $audit)
    {
        return $query->hunter()->whereAudit($audit)->countByCompany();
    }

    public function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function specialistId()
    {
        return $this->hasOne('App\Models\SpecialistJob');
    }
    public function specialist()
    {
        return $this->belongsToMany('App\Models\User', 'specialist_jobs')->withPivot('created_at');
    }

    /**
     * 是否已收藏
     */
    public function favoriteJob()
    {
        return $this->hasOne('App\Models\FavoriteJob')->mine();
    }

    public function getRewardAttribute()
    {
        $salary = $this->salary;
        $reward = $salary[0] * 0.2 * 0.3 * 1000 * 12;
        return intval($reward);
    }
    public function getSalaryAttribute()
    {
        $s = $this->attributes['s_salary'];
        $e = $this->attributes['e_salary'];
        return [$s,$e];
    }

    /**
     * 猎头提供信息的客户
     */
    public function information()
    {
        return $this->belongsTo('App\Models\Information', 'company_id', 'company_id');
    }

    public function getYearSalaryAttribute()
    {
        $s = $this->attributes['s_salary'] * 1.2;
        $e = $this->attributes['e_salary'] * 1.2;
        return [$s, $e];
    }
    // 获取行业大类
    public function getRootTradeAttribute()
    {
        $trade = $this->attributes['trade'];
        return current(explode("：", $trade));
    }

    public function tagss()
    {
        return $this->tags();
    }

    public function getExpectedRewardAttribute()
    {
        return $this->attributes['s_salary'] * 720;
    }
}
