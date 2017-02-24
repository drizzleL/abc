<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecommendRecord;
use Auth;

class RecordsController extends Controller
{
    public function index(Request $request)
    {
        $record = new RecommendRecord;
        $record = $record->whereUserId(Auth::id());
        if ($request->state == 'open') {
            $record = $record->open();
        }
        return $record->paginate();
    }
    public function show($id)
    {
        $record = RecommendRecord::where('user_id', Auth::id())
            ->with('company', 'job')
            ->findOrFail($id);
        return $record;
    }

}
