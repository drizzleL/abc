<?php

namespace App\Models;

use App\Models\BaseModel;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\JobApply;

class RecommendRecord extends BaseModel
{
    protected $table = 'recommend_records';
    public $timestamps = true;
    protected $fillable = ['user_id', 'job_id' ,'searched_resume_id', 'remark', 'company_id', 'candidate_uid', 'resume_id', 'status', 'candidate_name', 'order_id'];

    public function getPercentageAttribute()
    {
        switch ($this->attributes['status']) {
            case '0':
                return 10;
            case '1':
                return 20;
            case '2':
                return 30;
            case '3':
                return 40;
            case '4':
                return 50;
            case '5':
                return 60;
            case '6':
                return 70;
            case '7':
                return 80;
            case '8':
                return 100;
            default:
                return 0;
        }
    }

    public function getStatusCnAttribute()
    {
        switch ($this->attributes['status']) {
            case '0':
                return '邀请已发送，等待候选人回复';
            case '1':
                return '候选人点击邮件';
            case '2':
                return '待招聘专家审核';
            case '3':
                return '待招聘专家审核';
            case '4':
                return '简历已发给企业';
            case '5':
                return '企业已浏览，待跟进';
            case '6':
                return '面试到场';
            case '7':
                return '已发Offer';
            case '8':
                return '成功入职';
            default:
                return '职位推荐失败';
        }
    }

    public function scopeDateFilter($query, $datefilter)
    {
        if ($datefilter) {
            $dates = explode(' 至 ', $datefilter);
            $date1 = $dates[0];
            $date2 = $dates[1];
            return $query->where('created_at', '>=', $date1)
                ->where('created_at', '<=', Carbon::parse($date2)->addDay(1));
        } else {
            return $query;
        }
    }

    public function getStatusStageAttribute()
    {
        $status = $this->attributes['status'];
        if ($status >= 4 && $status <= 7) {
            return 4;
        } else if ($status >= 0 && $status <= 3) {
            return 0;
        } else {
            return $status;
        }
    }
    public function scopeStatusStage($query, $status)
    {
         if ($status == 0) {
             return $query->whereIn('status', [0, 1, 2, 3]);
         } else if ($status == 4) {
             return $query->whereIn('status', [4, 5, 6, 7]);
         } else if ($status == 8) {
             return $query->whereStatus(8);
         } else if ($status == -1) {
             return $query->where('status', '<=', -1);
         }
    }

    // 已推荐人数
    public function scopeRecommendCount($query, $job_id)
    {
        return $query->where('job_id', $job_id);
    }
    // 是否推荐过
    public function scopeHasRecommended($query, $job_id, $candidate_uid)
    {
        return $query->where('job_id', $job_id)
            ->where('candidate_uid', $candidate_uid);
    }

    public function searchedResume()
    {
        return $this
            ->belongsTo('App\Models\Resume', 'searched_resume_id');
    }
    // 职位
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
    // 发布职位公司
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    // 进度
    public function progress()
    {
        return $this->hasMany('App\Models\RecordProgress', 'record_id');
    }

    // 候选人
    public function candidate()
    {
        return $this->belongsTo('App\Models\Member', 'candidate_uid');
    }
    // 候选人信息
    public function candidateInfo()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'candidate_uid');
    }

    // 推荐简历
    public function resume()
    {
        return $this->belongsTo('App\Models\Resume');
    }


    // 候选人简历
    public function resumes()
    {
        return $this->hasMany('App\Models\Resume', 'uid', 'candidate_uid');
    }

    // 猎头
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    // 负责的招聘专家
    public function specialist()
    {
        return $this->belongsToMany('App\Models\User', 'specialist_jobs', 'job_id', 'user_id', 'job_id');
    }
    public function specialistJob()
    {
        return $this->belongsTo('App\Models\SpecialistJob', 'job_id', 'job_id');
    }

    public function read($user_id)
    {
        Notification::where('user_id', $user_id)
            ->where('resource_id', $this->id)
            ->where('resource_type', 'record')
            ->update(['status' => 1]);
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function deal()
    {
        return $this->hasOne('App\Models\Deal', 'record_id');
    }

    public function getApplyAttribute()
    {
        return JobApply::whereType('hunter')->where('job_id', $this->job_id)
            ->where('personal_uid', $this->candidate_uid)->latest('id')->first();
    }
}
