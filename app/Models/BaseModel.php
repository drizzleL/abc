<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

abstract class BaseModel extends Model
{
    protected $transform = [];
    // user_id是当前登录用户的
    public function scopeMine($query)
    {
        return $query->whereUserId(Auth::id());
    }
    // 根据company_id，统计
    public function scopeCountByCompany($query)
    {
        return $query->selectRaw('company_id, count(*) as aggregate')
            ->groupBy('company_id');
    }

    public function setAttribute($key, $value)
    {
        if (array_key_exists($key, $this->transform) && is_array($value)) {
            $rules                  = explode(':', $this->transform[$key]);
            $value                  = implode($rules[1], $value);
            $this->attributes[$key] = $value;
            return $this;
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->transform) && is_string($this->attributes[$key])) {
            // $value = explode($rules[1], $this->attributes[$key]);
            $this->attributes[$key] = $this->transformAttribute($key, $this->attributes[$key]);
            return $this->attributes[$key];
        }
        return parent::getAttribute($key);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->transform as $key => $value) {

            if (!array_key_exists($key, $attributes)) {
                continue;
            }

            $attributes[$key] = $this->transformAttribute($key, $attributes[$key]);
        }

        return $attributes;
    }

    protected function transformAttribute($key, $value)
    {
        $rules = explode(':', $this->transform[$key]);
        return explode($rules[1], $value);
        // if (is_string($this->attributes[$key])) {
        //     $value = explode($rules[1], $this->attributes[$key]);
        //     // $this->attributes[$key] = $value;
        // }
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    // 资源备注
    public function resourceRemarks()
    {
        return $this->morphMany('App\Models\Remark', 'resource');
    }

    // 资源最新备注
    public function lastResourceRemark()
    {
        return $this->morphOne('App\Models\Remark', 'resource')->latest('id');
    }
}
