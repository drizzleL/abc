<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Company;

class JobsController extends Controller
{
    public function __construct()
    {
    }

    public function index($company_id)
    {
        $company = Company::find($company_id);
        $jobs = $company->jobs();

        return $jobs->paginate();
    }
}
