<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

class StandingController extends Controller
{
    public function index()
    {
        $title = "Klasemen";
        $sub_title = '
            <div class="breadcrumb-item">Klasemen</div>
        ';

        return view('standings.index', compact('title', 'sub_title'));
    }

    public function json()
    {
        if (request()->ajax()) {
            $data = Club::orderBy('point', 'desc')->orderBy('match', 'desc')->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->make();
        }
    }
}
