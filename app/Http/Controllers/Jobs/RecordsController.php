<?php

namespace App\Http\Controllers\Jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RecommendRecord;
use Auth;

class RecordsController extends Controller
{
    public function index($job_id)
    {
        return RecommendRecord::where('user_id', Auth::id())
            ->where('job_id', $job_id)->paginate();
    }
}
