<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{
    
    function search($tag)
    {
        return Tag::where('name', 'like', "%${$tag}%")->orderBy('name', 'asc')->get();
    }
}
