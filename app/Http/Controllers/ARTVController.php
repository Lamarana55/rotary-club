<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Region, Prefecture, Commune};

class ARTVController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function getCommunes(Request $request)
    {
        $prefectureId = $request->input('prefecture_id');
        $communes = Commune::where('prefecture_id', $prefectureId)->get();
        return response()->json($communes);
    }

    public function getPrefectures(Request $request)
    {
        $regionId = $request->input('region_id');
        $prefectures = Prefecture::where('region_id', $regionId)->with("communes")->get();
        return response()->json($prefectures);
    }

}
