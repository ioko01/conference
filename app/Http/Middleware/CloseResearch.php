<?php

namespace App\Http\Middleware;

use App\Models\Conference;
use Closure;
use Illuminate\Http\Request;

class CloseResearch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $conferences = Conference::select(
            Conference::raw(
                "floor(timestampdiff(second, now(), end_research)/(60*60*24)) as day"
            )
        )
            ->where('conferences.status', 1)
            ->get();
        foreach ($conferences as $conference) {
            if ($conference->day < 0) {
                Conference::where('status', 1)
                    ->update([
                        'status_research' => 0
                    ]);
            }
        }
        return $next($request);
    }
}
