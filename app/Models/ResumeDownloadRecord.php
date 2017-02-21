<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeDownloadRecord extends Model
{
    protected $table = 'resume_download_records';
    public $timestamps = true;
    protected $fillable = ['user_id', 'resumefile_id'];

    public function resumefile()
    {
        return $this->belongsTo('App\Models\Resumefile');
    }
}
