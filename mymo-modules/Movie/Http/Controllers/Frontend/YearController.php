<?php

namespace Modules\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;

class YearController extends FrontendController
{
    public function index($year) {
        $info = (object) [
            'name' => $year,
        ];
        
        $items = Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->where('status', '=', 1)
            ->where('year', '=', $year)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('genre.index', [
            'title' => $year,
            'description' => $year,
            'keywords' => $year,
            'info' => $info,
            'items' => $items,
        ]);
    }
}
