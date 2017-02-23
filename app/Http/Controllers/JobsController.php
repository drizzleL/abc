<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Cache;
use Auth;

class JobsController extends Controller
{
    public function __construct(Job $job_model)
    {
        $this->job_model = $job_model;
    }

    // show job detail by specific ID
    public function show($id)
    {
        $job = Job::find($id);
        // $job->star_status = Cache::get('job_'.$id.'_star_status', false);
        return $job;
    }

    // show job list
    public function index(Request $request)
    {
        $jobs = $this->job_model;
        $jobs = $jobs->orderBy('id', 'desc');
        $jobs = $jobs->paginate();
        return $jobs;
    }

    // Star job
    public function star($id)
    {
        Cache::forever('job_'.$id.'_star_status', true);
        return;
    }

    // Unstar job
    public function unstar($id)
    {
        if ($this->checkRecordExists($id)) {
            return;
        } else {
            Cache::forget('job_'.$id.'_star_status');
            return '1';
        }
    }

    public function checkRecordExists()
    {
        return false;
    }
}
