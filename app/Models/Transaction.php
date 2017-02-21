<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Transaction extends BaseModel
{
    protected $fillable = ['user_id', 'resource_type', 'resource_id', 'type'];
    protected $attributes = [
        'order_state' => 'PROCESSING'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function resource()
    {
       return $this->morphTo();
    }

    public function getTypeCnAttribute()
    {
        $type = $this->attributes['type'];
        switch ($type) {
            case 'record_verified_redpack':
                return '简历通过初审，奖励！';
            case 'record_consolation_redpack':
                return '优质简历奖励红包';
            case 'invite_redpack':
                return '邀请新用户奖励红包';
            case 'interview_redpack':
                return '候选人面试红包';
            default:
                return '招手红包奖励！';
        }
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
