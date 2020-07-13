<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use App\Models\Stars;
use App\Http\Controllers\Controller;

class StarController extends Controller
{
    public function index($slug) {
        $info = Stars::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
    
        $items = Movies::select([
            'id',
            'thumbnail',
            'name',
            'slug',
        ])
            ->where('status', '=', 1)
            ->whereRaw('find_in_set(?, stars)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('themes.mymo.genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}