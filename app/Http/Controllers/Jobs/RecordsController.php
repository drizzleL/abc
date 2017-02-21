<?php

namespace App\Http\Controllers\Jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function index($job_id)
    {
        return RecommendRecord::where('user_id', '12')
            ->where('job_id', $job_id)->paginate();
    }
}
