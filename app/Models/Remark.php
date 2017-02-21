<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = ['user_id', 'contact_type', 'content', 'resource_id', 'resource_type'];
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
    public function getModelNameAttribute()
    {
        $model = preg_replace("/^App\\\Models\\\/", '', $this->attributes['resource_type']);
        switch ($model) {
            case 'RecommendRecord':
                $name = '推荐记录';
                break;
            case 'Application':
                $name = '猎头申请记录';
                break;
            case 'Group':
                $name = '虚拟团队';
                break;
            case 'User':
                $name = '用户';
                break;
            case 'Information':
                $name = '推荐客户';
                break;
            case 'Order':
                $name = '订单';
                break;
            case 'Job':
                $name = '职位';
                break;
            case 'Deal':
                $name = '成单';
                break;
        }
        return $name;
    }
}
