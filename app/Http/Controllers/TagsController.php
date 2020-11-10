<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{

    

    
    function search(Request $request)
    {
        
        return Tag::where('name', 'like', "%{$request->name}%")
            ->orderBy('name', 'asc')->simplePaginate(30);
        
    }
}
