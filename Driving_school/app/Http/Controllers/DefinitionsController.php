<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Definitions;

class DefinitionsController extends Controller
{

    public function index()
    {
        $definitions = Definitions::all();
        
        return view('cours', compact('definitions'));
    }
}
