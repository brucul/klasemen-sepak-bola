<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Club;

class ClubController extends Controller
{
    public function index()
    {
        $title = "Klub";
        $sub_title = '
            <div class="breadcrumb-item">Klub</div>
        ';

        return view('club.index', compact('title', 'sub_title'));
    }

    public function json()
    {
        if (request()->ajax()) {
            $data = Club::all();

            return datatables()->of($data)
                ->addIndexColumn()
                ->make();
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'city' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        $input = array_fill_keys(array_keys($rules), null);
        $errors = array_merge($input, $validator->errors()->toArray());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }

        if (Club::where('slug_name', str_slug($request->name))->first()) {
            return response()->json([
                'success' => false,
                'errors' => ['name' => ['Club name already exist.']],
            ]);
        }

        Club::create([
            'name' => $request->name,
            'slug_name' => str_slug($request->name),
            'city' => $request->city,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tambah Klub Berhasil',
        ]);
    }
}
