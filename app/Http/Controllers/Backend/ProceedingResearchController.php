<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProceedingResearchController extends Controller
{
    //
    public function index($year)
    {
        return view('backend.pages.proceeding_research', compact('year'));
    }
}
