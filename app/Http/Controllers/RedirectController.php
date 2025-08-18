<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function show(string $slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (!$link) {
            abort(404);
        }

        if ($link->expires_at && Carbon::now()->greaterThan($link->expires_at)) {
            $link->status = 'expired';
            $link->save();
            return response()->json(['message' => 'Link expirado.'], 410);
        }

        $link->increment('click_count');

        return redirect($link->original_url, 302);
    }
}
