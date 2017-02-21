<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_site_status';
    protected $fillable = ['date'];

    public $timestamps = false;

    protected static function stats($column)
    {
        $model = self::firstOrCreate(['date' => date('Y-m-d')]);
        $model->increment($column);
    }
}
