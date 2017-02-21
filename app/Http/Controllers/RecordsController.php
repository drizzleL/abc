<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecommendRecord;

class RecordsController extends Controller
{
    public function __construct(RecommendRecord $record_repo)
    {
        $this->record_repo = $record_repo;
    }
    public function index()
    {
        $record = $this->record_repo;
        $record = $record->whereUserId(21);
        return $record->paginate();
    }
    public function show($id)
    {

    }
}
