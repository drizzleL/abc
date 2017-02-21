<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['user_id', 'resource_type', 'resource_id', 'event_type', 'description'];
    protected $visible = ['id', 'created_at', 'details'];
    protected $appends = ['details'];

    static function auditJob($user, $job)
    {
        $model = new self;
        $model->user_id = $user->id;
        $model->event_type = 'audit_job';
        $model->resource_id = $job->id;
        $model->resource_type = 'App\Models\Job';
        $model->description = $user->name .'审核通过'. $job->name;
        $model->save();
    }


    static function auditHunter($user, $hunter)
    {
        $model = new self;
        $model->user_id = $user->id;
        $model->event_type = 'audit_hunter';
        $model->resource_id = $hunter->id;
        $model->resource_type = 'App\Models\User';
        $model->description = $user->name .'审核通过'. $hunter->name;
        $model->save();
    }

    static function markInterview($user, $record)
    {
        $model = new self;
        $model->user_id = $user->id;
        $model->event_type = 'mark_interview';
        $model->resource_id = $record->id;
        $model->resource_type = 'App\Models\RecommendRecord';
        $model->description = '候选人通过面试';
        $model->save();
    }

    public function getDetailsAttribute()
    {
        switch ($this->attributes['event_type']) {
            case 'audit_hunter':
                $name = mb_substr($this->resource->name, 0, 1);
                return "欢迎{$name}**加入招手猎头。";
            case 'audit_job':
                $job = $this->resource;
                return '某'. $job->root_trade .'企业发布'. $job->name .'职位，<span>年薪'. join('-', $job->year_salary) .'万</span>。';
            case 'record_verified_redpack':
                $name = mb_substr($this->user->name, 0, 1);
                return "猎头{$name}**推荐人选通过初审，获得<span>微信红包</span>奖励。";
            case 'mark_interview':
                $name = mb_substr($this->resource->user->name, 0, 1);
                $jobname = $this->resource->job->name;
                return "{$name}**推荐的{$jobname}人选进入面试，预祝面试成功！";
            case 'deal_created':
                $name = mb_substr($this->user->name, 0, 1);
                $jobname = $this->resource->job->name;
                $money = $this->resource->deal->contract_price * 0.3;
                return "猎头{$name}**推荐的{$jobname}人选成功入职，获得推荐<span>佣金{$money}元</span>。";
        }
    }

    public function resource()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getUrlAttribute()
    {
        $model = preg_replace("/^App\\\Models\\\/", '', $this->attributes['resource_type']);
        switch ($model) {
            case 'RecommendRecord':
                $resource = 'records';
                break;
            case 'Application':
                $resource = 'applications';
                break;
            case 'Group':
                $resource = 'groups';
                break;
            case 'User':
                $resource = 'users';
                break;
            case 'Information':
                $resource = 'information';
                break;
            case 'Order':
                $resource = 'orders';
                break;
            case 'Job':
                $resource = 'jobs';
                break;
            case 'Deal':
                $resource = 'deals';
                break;
        }
        return '/staff/'. $resource .'/'. $this->resource_id;
    }

}
