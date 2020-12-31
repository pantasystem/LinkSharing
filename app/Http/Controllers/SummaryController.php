<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FetchSummaryRequest;
use App\Models\Summary;

class SummaryController extends Controller
{
    //
    public function fetch(FetchSummaryRequest $request)
    {
        $summary = Summary::where('url', '=', $request->input('url'))->first();
        if(is_null($summary)){
            $summary = new Summary($request->only('url'));
            $summary->loadSummary();
            $summary->save();
        }
        return $summary;

    }

    public function get($id)
    {
        return Summary::findOrFail($id);
    }

    public function getWords($id)
    {
        $words = Summary::findOrFail($id)->getWords();
        uasort($words, function($cA, $cB){
            if($cA == $cB){
                return 0;
            }

            return ($a < $b) ? 1: -1;
        });
        $wordOnly = array_keys($words);
        if(count($wordOnly) < 10){
            return $wordOnly;
        }else{
            return array_slice($wordOnly, 0, 10);
        }
    }
}
