<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostLeadRequest;
use App\Models\Lead;
use Auth;

class LeadsController extends Controller
{
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }
    public function index()
    {
        return $this->lead->where('user_id', Auth::id())->paginate();
    }

    public function show($id)
    {
        return $this->lead->where('user_id', Auth::id())->findOrFail($id);
    }
    public function store(PostLeadRequest $request)
    {
        $lead = $this->lead;
        $lead->fill($request->all());
        return $lead;
        $lead->save();
        return $lead;
    }
}
