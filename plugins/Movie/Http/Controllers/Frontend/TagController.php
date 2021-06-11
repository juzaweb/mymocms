<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\Movie;
use Plugins\Movie\Models\Category\Tags;

class TagController extends FrontendController
{
    public function index($slug) {
        $info = Tags::where('slug', '=', $slug)
            ->firstOrFail(['id', 'name']);
        
        $items = Movie::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->wherePublish()
            ->whereRaw('find_in_set(?, tags)', [$info->id])
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('genre.index', [
            'items' => $items,
            'info' => $info,
        ]);
    }
}
