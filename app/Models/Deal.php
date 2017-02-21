<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Deal extends BaseModel
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $attributes = ['contract_price' => 0];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function record()
    {
        return $this->belongsTo('App\Models\RecommendRecord');
    }
    public function specialist()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getStatusCnAttribute()
    {
        $status = $this->attributes['status'];
        switch ($status) {
            case 1:
                return '收到回款';
            case 2:
                return '回款完成';
            default:
                return '暂未收到回款';
        }
    }

    public function setDownpaymentReceivedAtAttribute($value)
    {
        $value = $value ?: null;
        $this->attributes['downpayment_received_at'] = $value;
    }
    public function setExpectedDownpaymentReceivedAtAttribute($value)
    {
        $value = $value ?: null;
        $this->attributes['expected_downpayment_received_at'] = $value;
    }
    public function setBalanceReceivedAtAttribute($value)
    {
        $value = $value ?: null;
        $this->attributes['balance_received_at'] = $value;
    }
    public function setExpectedBalanceReceivedAtAttribute($value)
    {
        $value = $value ?: null;
        $this->attributes['expected_balance_received_at'] = $value;
    }
}
