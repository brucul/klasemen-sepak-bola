<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Club;
use App\Models\ClubMatch;
use DB;

class MatchController extends Controller
{
    public function index()
    {
        $title = "Pertandingan";
        $sub_title = '
            <div class="breadcrumb-item">Pertandingan</div>
        ';

        $clubs = Club::all();

        return view('match.index', compact('title', 'sub_title', 'clubs'));
    }

    public function json()
    {
        if (request()->ajax()) {
            $data = ClubMatch::latest();

            return datatables()->of($data)
                ->editColumn('club_1', function ($data) {
                    return $data->club_home->name.' ('.$data->score_1.')';
                })
                ->editColumn('club_2', function ($data) {
                    return $data->club_away->name.' ('.$data->score_2.')';
                })
                ->editColumn('match', function ($data) {
                    return $data->club_home->name.' ('.$data->score_1.') vs ('.$data->score_2.') '.$data->club_away->name;
                })
                ->addIndexColumn()
                ->make();
        }
    }

    public function getClub2(Request $request)
    {
        $clubs = Club::where('id', '!=', $request->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $clubs
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'club_id_1' => 'required',
            'club_id_2' => 'required',
            'score_1' => 'required|integer',
            'score_2' => 'required|integer',
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

        $checkMatch = ClubMatch::where('club_id_1', $request->club_id_1)->where('club_id_2', $request->club_id_2)->first();

        if ($checkMatch) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'club_id_1' => ['The match already exist.'],
                    'club_id_2' => ['The match already exist.'],
                ],
            ]);
        }

        $match = ClubMatch::create($validator->validated());
        $this->ruleMatch($match);

        return response()->json([
            'success' => true,
            'message' => 'Tambah Pertandingan Berhasil',
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $rules = [
            'club_id_1.*' => 'required',
            'club_id_2.*' => 'required',
            'score_1.*' => 'required|integer',
            'score_2.*' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);

        $input = array_fill_keys(array_keys($rules), null);
        $errors = array_merge($input, $validator->errors()->toArray());
        foreach ($rules as $key => $value) {
            unset($errors[$key]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }

        $club_ids_1 = array_values($request->club_id_1);
        $club_ids_2 = array_values($request->club_id_2);
        $scores_1 = array_values($request->score_1);
        $scores_2 = array_values($request->score_2);

        $matches = collect([]);
        foreach ($request->club_id_1 as $key => $value) {
            $matches[$key] = collect([
                'club_id_1' => $request->club_id_1[$key],
                'club_id_2' => $request->club_id_2[$key],
                'score_1' => $request->score_1[$key],
                'score_2' => $request->score_2[$key],
            ]);
        }
        // for ($i=0; $i < count($request->club_id_1); $i++) { 
        //     if (array_key_exists($i, $request->club_id_1)) {
        //         $matches[$i] = collect([
        //             'club_id_1' => $request->club_id_1[$i],
        //             'club_id_2' => $request->club_id_2[$i],
        //             'score_1' => $request->score_1[$i],
        //             'score_2' => $request->score_2[$i],
        //         ]);
        //     }
        // }

        $duplicates = $matches->duplicates(function ($item, $key) {
            return [
                $item['club_id_1'], 
                $item['club_id_2']
            ];
        })->keys()->map(function ($item, $key) {
            return [
                'club_id_1.'.$item => ['The match already exist.'],
                'club_id_2.'.$item => ['The match already exist.'],
            ];
        })->collapse();

        if ($duplicates->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'errors' => $duplicates,
            ]);
        }

        DB::beginTransaction();
        try {
            for ($i=0; $i < count($club_ids_1); $i++) {
                $checkMatch = ClubMatch::where('club_id_1', $club_ids_1[$i])->where('club_id_2', $club_ids_2[$i])->first();

                if ($checkMatch) {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'club_id_1.'.$i => ['The match already exist.'],
                            'club_id_2.'.$i => ['The match already exist.'],
                        ],
                    ]);
                }
                $match = ClubMatch::create([
                    'club_id_1' => $club_ids_1[$i],
                    'club_id_2' => $club_ids_2[$i],
                    'score_1' => $scores_1[$i],
                    'score_2' => $scores_2[$i],
                ]);
                $this->ruleMatch($match);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Tambah Pertandingan Berhasil',
        ]);
    }

    function ruleMatch($match)
    {
        if ($match) {
            $score_1 = $match->score_1;
            $score_2 = $match->score_2;

            if ($score_2 == $score_1) {
                $club_1 = $match->club_home;
                $club_1->update([
                    'match' => $club_1->match + 1,
                    'draw' => $club_1->draw + 1,
                    'goals_for' => $club_1->goals_for + $score_1,
                    'goals_against' => $club_1->goals_against + $score_2,
                    'point' => $club_1->point + 1,
                ]);

                $club_2 = $match->club_away;
                $club_2->update([
                    'match' => $club_2->match + 1,
                    'draw' => $club_2->draw + 1,
                    'goals_for' => $club_2->goals_for + $score_2,
                    'goals_against' => $club_2->goals_against + $score_1,
                    'point' => $club_2->point + 1,
                ]);
            } else {
                $club_1 = $match->club_home;
                $club_1->update([
                    'match' => $club_1->match + 1,
                    'win' => $club_1->win + ($score_1 > $score_2 ? 1 : 0),
                    'lose' => $club_1->lose + ($score_1 < $score_2 ? 1 : 0),
                    'goals_for' => $club_1->goals_for + $score_1,
                    'goals_against' => $club_1->goals_against + $score_2,
                    'point' => $club_1->point + ($score_1 > $score_2 ? 3 : 0),
                ]);

                $club_2 = $match->club_away;
                $club_2->update([
                    'match' => $club_2->match + 1,
                    'win' => $club_2->win + ($score_2 > $score_1 ? 1 : 0),
                    'lose' => $club_2->lose + ($score_2 < $score_1 ? 1 : 0),
                    'goals_for' => $club_2->goals_for + $score_2,
                    'goals_against' => $club_2->goals_against + $score_1,
                    'point' => $club_2->point + ($score_2 > $score_1 ? 1 : 0),
                ]);
            }
        }
    }
}
