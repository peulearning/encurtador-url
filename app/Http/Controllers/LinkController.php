<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $slug = Str::random(8); // Gere um slug aleatório

        $link = Link::create([
            'user_id' => $request->user()->id,
            'original_url' => $request->original_url,
            'slug' => $slug,
            'expires_at' => $request->expires_at,
        ]);

        // Lógica para gerar QR Code (pode ser implementada com uma biblioteca como o simple-qrcode)
        // Lógica para gerar short_url

        return response()->json([
            'message' => 'Link created successfully.',
            'link' => $link,
        ], 201);
    }
}
