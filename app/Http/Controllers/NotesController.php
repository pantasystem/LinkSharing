<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotesController extends Controller
{
    function create(Request $request)
    {
        $user = $request->user();
        $user->notes()->create($request->only(['title', 'text']));
    }
}
