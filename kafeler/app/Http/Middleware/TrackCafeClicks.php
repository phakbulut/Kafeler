<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CafeClick;
class TrackCafeClicks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if ($slug) {
            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;

            $click = CafeClick::firstOrNew([
                'user_id' => User::where('slug', $slug)->value('id'),
                'slug' => $slug,
                'year' => $year,
                'month' => $month,
            ]);

            $click->click_count++;
            $click->save();
        }

        return $next($request);
    }
    
}
