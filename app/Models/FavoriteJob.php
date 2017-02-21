<?php

namespace App\Models;

use App\Models\BaseModel;

class FavoriteJob extends BaseModel
{
    protected $table = 'favorite_jobs';
    public $timestamps = true;
    protected $fillable = ['user_id', 'job_id', 'tags', 'remark', 'company_id'];

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
    public function recommendRecords()
    {
        return $this->hasMany('App\Models\RecommendRecord', 'job_id', 'job_id')
            ->mine();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function details()
    {
        return $this->hasOne('App\Models\HeadhuntingJob', 'job_id', 'job_id');
    }
}
