<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SpecialistJob;
use App\Models\BaseModel;

class User extends BaseModel implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['uid', 'username', 'role', 'avatar', 'name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getNameAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->attributes['username'];
        }
    }
    public function getIsStaffAttribute()
    {
        return $this->roles()->exists();
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'users_roles');
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles->pluck('name')->toArray());
    }
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'uid', 'uid');
    }
    public function profile()
    {
        return $this->belongsTo('App\Models\MembersInfo', 'uid', 'uid');
    }

    public function hunterProfile()
    {
        return $this->hasOne('App\Models\HunterProfile');
    }


    /**
     * 猎头角色
     */
    // 申请资料
    public function application()
    {
        return $this->hasOne('App\Models\Application', 'uid', 'uid');
    }
    // 所有接单
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    // 接单数量
    public function ordersCount()
    {
        return $this->hasOne('App\Models\Order')
            ->selectRaw('user_id, count(*) as aggregate')->groupBy('user_id');
    }
    // 推荐记录
    public function records()
    {
        return $this->hasMany('App\Models\RecommendRecord');
    }
    // 推荐数量
    public function recordsCount()
    {
        return $this->hasOne('App\Models\RecommendRecord')
            ->selectRaw('user_id, count(*) as aggregate')->groupBy('user_id');
    }
    // 所属团队
    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'groups_users');
    }
    // 创建的团队
    public function group()
    {
        return $this->hasOne('App\Models\Group');
    }
    // 所有权限
    public function permission()
    {
        return $this->hasOne('App\Models\HunterPermission');
    }
    // 是否拥有某权限
    public function hasPermission($permission_name)
    {
        $permission = $this->permission;
        if ($permission) {
            $permission = $permission->toArray();
            return $permission[$permission_name] == 1;
        }
        return false;
    }

    /**
     * 招聘专家角色
     */
    // 负责的职位id
    public function getJobIdsAttribute()
    {
        $job_ids = SpecialistJob::where('user_id', $this->id)
            ->pluck('job_id');
        return $job_ids;
    }
    // 负责的职位
    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job', 'headhunting.specialist_jobs')
            ->withPivot('created_at');
    }
    public function specialistJobsCount()
    {
        return $this->hasOne('App\Models\SpecialistJob')
            ->selectRaw('user_id, count(*) as aggregate')
            ->groupBy('user_id');
    }

    public function upgrade($class = 'B')
    {
        $this->class = $class;
        $this->save();
        return 1;
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function openid()
    {
        return $this->hasOne('App\Models\UserOauth', 'uid', 'uid')
            ->where('type', 'wx_openid');
    }

    public function specialistInfo()
    {
        return $this->hasOne('App\Models\SpecialistInfo');
    }
}
