<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{

    

    
    function search(Request $request)
    {
        $word = $request->input('word');
        $query = Tag::limit(50);
        if(isset($word) && !empty(trim($word))){
            $query->where('name', 'like', "%{$word}%");
        }
        return $query->orderBy('name', 'asc')->get();
        
    }
}
