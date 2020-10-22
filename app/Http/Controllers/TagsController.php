<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{

    

    
    function search($tag)
    {
        return Tag::where('name', 'like', "%${$tag}