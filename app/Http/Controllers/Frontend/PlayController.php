<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Genres;
use App\Models\Movies;
use App\Models\MovieViews;
use App\Models\VideoFiles;
use Illuminate\Support\Facades\Cookie;

class PlayController extends Controller
{
    public function index($slug, $vid) {
        $info = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        $genre = Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
        
        return view('themes.mymo.watch.watch', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive halimthemes halimmovies halim-corner-rounded',
            'info' => $info,
            'vid' => $vid,
            'start' => $info->getStarRating(),
            'genre' => $genre,
            'tags' => $info->getTags(),
            'servers' => $info->getServers(),
            'related_movies' => $info->getRelatedMovies(8),
        ]);
    }
    
    public function getPlayer($slug, $vid) {
        $movie = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        $file = VideoFiles::find($vid);
        if ($file) {
            $files = $file->getFiles();
            return response()->json([
                'data' => [
                    'status' => true,
                    'sources' => view('themes.mymo.data.player_script', [
                        'movie' => $movie,
                        'files' => $files,
                    ])->render(),
                ]
            ]);
        }
        
        return response()->json([
            'data' => [
                'status' => false,
            ]
        ]);
    }
    
    public function setMovieView($slug) {
        $movie = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail(['id', 'views']);
    
        $views = $movie->views;
        $viewed = Cookie::get('viewed');
        if ($viewed) {
            $viewed = json_decode($viewed, true);
            
            if (in_array($movie->id, $viewed)) {
                return response()->json([
                    'view' => $views,
                ]);
            }
        }
        
        if (empty($viewed)) {
            $viewed = [];
        }
    
        $views = $movie->views + 1;
        $this->setView($movie->id);
        
        $viewed[] = $movie->id;
        Cookie::queue('viewed', json_encode($viewed), 1440);
        
        Movies::where('id', '=', $movie->id)
            ->update([
                'views' => $views
            ]);
        
        return response()->json([
            'view' => $views,
        ]);
    }
    
    protected function setView($movie_id) {
        $model = MovieViews::firstOrNew([
            'movie_id' => $movie_id,
            'day' => date('Y-m-d'),
        ]);
        $model->movie_id = $movie_id;
        $model->views = $model->views + 1;
        $model->day = date('Y-m-d');
        return $model->save();
    }
}