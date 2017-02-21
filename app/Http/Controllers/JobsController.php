<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobsController extends Controller
{
    public function __construct(Job $job_model)
    {
        $this->job_model = $job_model;
    }

    // show job detail by specific ID
    public function show($id)
    {
        return Job::find($id);
    }

    // show job list
    public function index(Request $request)
    {
        $jobs = $this->job_model;
        if ($request->sort_by) {
            $jobs = $jobs->orderBy($request->sort_by);
        }
        $jobs = $jobs->paginate();
        return $jobs;
    }

    // Star job
    public function star($id)
    {
        return;
    }

    // Unstar job
    public function unstar($id)
    {
        if ($this->checkRecordExists($id)) {
            return;
        } else {
            return '1';
        }
    }

    public function checkRecordExists()
    {
        return false;
    }
}
