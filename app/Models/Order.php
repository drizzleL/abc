<?php

namespace App\Models;

use App\Models\BaseModel;

class Order extends BaseModel
{
    protected $fillable = ['user_id', 'job_id', 'tags', 'remark', 'company_id', 'status'];

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function details()
    {
        return $this->hasOne('App\Models\HeadhuntingJob', 'job_id', 'job_id');
    }

    public function lastRecord()
    {
        return $this->hasOne('App\Models\RecommendRecord', 'job_id', 'job_id')
            ->mine()->latest('updated_at');
    }

    public function records()
    {
        return $this->hasMany('App\Models\RecommendRecord');
    }
}
