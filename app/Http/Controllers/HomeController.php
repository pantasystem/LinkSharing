<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SummaryLoader;
use App\Models\Hoge;
use App\Models\Summary;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test(){
        return "Hello world";
    }

    public function me(){
        return User::withCountRelationModels()->find(Auth::user()->id);
    }

    public function loadSummary()
    {
        /*$summary = new SummaryLoader();


        return $summary->getSummary($url);*/

        $url = "https://teratail.com/questions/160537";

        $hoge= new Hoge();
        $summary = new Summary($url);
        $summary->loadSummary();
        return $summary;
    }

    

}
