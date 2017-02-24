<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecommendRecord;
use Auth;

class StatisticsController extends Controller
{
    public function record()
    {
        $num = RecommendRecord::whereUserId(Auth::id())
            ->groupBy('status')->selectRaw('status, count(*) as aggregate')->get();
        return $num;
    }

    public function getStatistics($name)
    {
        return call_user_func([$this, $name]);
    }

}
