<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use Illuminate\Support\Facades\DB;

class StatusUpdateController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, $id)
    {
        Research::where('topic_id', $id)->update(['topic_status' => $request->topic_status]);
        write_logs(__FUNCTION__, "info");

        DB::disconnect('researchs');
        return response()->json(['success' => true]);
    }
}
