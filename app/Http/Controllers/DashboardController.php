<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\ClubMatch;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $sub_title = '
            <div class="breadcrumb-item">Dashboard</div>
        ';

        $club = Club::all();
        $match = ClubMatch::all();
        
        return view('index', compact('title', 'sub_title', 'club', 'match'));
    }
}
