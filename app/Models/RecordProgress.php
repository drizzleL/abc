<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordProgress extends Model
{
    protected $fillable = ['type', 'remark', 'record_id'];
    public function getTypeCnAttribute()
    {
        $value = $this->attributes['type'];
        switch ($value) {
            case 0:
                return '发送邀请';
            case 1:
                return '候选人已确认';
            case 2:
                return '简历已提交，等待审核';
            case 3:
                return '猎头顾问已审核简历提交给招聘专家';
            case 4:
                return '招聘专家审核通过，简历提交发给企业';
            case 5:
                return '企业已查看简历';
            case 6:
                return '面试到场';
            case 7:
                return '已发Offer';
            case 8:
                return '成功入职';
            default:
                return '职位失败';
        }
    }

    public function record()
    {
        return $this->belongsTo('App\Models\RecommendRecord');
    }
}
