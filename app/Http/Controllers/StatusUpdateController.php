<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusUpdateController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        return view('frontend.pages.manage_research');
    }
}