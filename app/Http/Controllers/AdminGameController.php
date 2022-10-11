<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminGameController extends Controller
{
    public function edit($id)
    {
        return view('admin.games.edit');
    }
}
