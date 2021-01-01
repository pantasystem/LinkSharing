<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FetchSummaryRequest;
use App\Models\Summary;
use DB;

class SummaryController extends Controller
{
    //
    public function fetch(FetchSummaryRequest $request)
    {
        return DB::transaction(function() use ($request){
            $summary = Summary::where('url', '=', $request->input('url'))->lockForUpdate()->first();
            if(is_null($summary)){
                $summary = new Summary($request->only('url'));
                $summary->loadSummary();
                $summary->save();
                $summary->executeUpdateWords();
            }
            return $summary->load('aggregateWords');
        });
        

    }

    public function get($id)
    {
        return Summary::with('aggregateWords')->findOrFail($id);
    }

    
}
