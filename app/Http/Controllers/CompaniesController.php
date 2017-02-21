<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompaniesController extends Controller
{

    public function __construct()
    {
        //$this->company_repo = $company_repo;
    }

    public function show($id)
    {
        $company = Company::find($id);
        return $company;
    }

    public function store(Request $request)
    {
    }
}
