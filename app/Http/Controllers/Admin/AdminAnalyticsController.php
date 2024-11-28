<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques regroupées par URL
        $pageViews = DB::table('page_views')
            ->select('url', DB::raw('count(*) as views'), DB::raw('max(visited_at) as last_visited'))
            ->groupBy('url')
            ->orderByDesc('views')
            ->get();

        return view('admin.analytics.index', compact('pageViews'));
    }
}
