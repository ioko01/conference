<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;

class PaymentController extends Controller
{
    //
    public function index(){
        $tips = Tip::where('group', '2')->get();
        return view('frontend.pages.payment', compact('tips'));
    }
}