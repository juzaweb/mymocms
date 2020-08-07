<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\TmdbApi;
use App\Models\Countries;
use App\Models\Files;
use App\Models\Genres;
use App\Models\Movies;
use App\Models\Stars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TmdbController extends Controller
{
    public function addMovie(Request $request) {
        $this->validateRequest([
            'tmdb' => 'required',
        ], $request);
        
        if (empty(get_config('tmdb_api_key'))) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.tmdb_api_key_not_found'),
            ]);
        }
        
        $movie = $this->getMovieById($request->post('tmdb'));
        if (empty($movie)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.movie_not_found'),
            ]);
        }
        
        $model = new Movies();
        $model->fill($movie);
        $model->thumbnail = $this->downloadThumbnail($movie['thumbnail']);
        $model->poster = $this->downloadThumbnail($movie['poster']);
        $model->genres = implode(',', $movie['genres']);
        $model->countries = implode(',', $movie['countries']);
        $model->actors = implode(',', $movie['actors']);
        $model->writers = implode(',', $movie['writers']);
        $model->directors = implode(',', $movie['directors']);
        $model->save();
        
        return response()->json([
            'status' => '',
            'redirect' => route('admin.movies.edit', [$model->id]),
        ]);
    }
    
    protected function getMovieById($imdb_id) {
        $api = new TmdbApi();
        $api->setAPIKey(get_config('tmdb_api_key'));
        $data = $api->getMovie($imdb_id);
        if (empty($data)) {
            return false;
        }
        
        $actors = $this->getStarIds($data['credits']['cast'], 'actor');
        $directors = $this->getStarIds($data['credits']['crew'], 'director');
        $writers = $this->getStarIds($data['credits']['crew'], 'writter');
        $countries = $this->getCounrtyIds($data['production_countries']);
        $genres = $this->getGenreIds($data['genres']);
        
        return [
            'name' => $data['original_title'],
            'description' => $data['overview'],
            'thumbnail' => 'https://image.tmdb.org/t/p/w185/'.$data['poster_path'],
            'poster' => 'https://image.tmdb.org/t/p/w780/'.$data['backdrop_path'],
            'rating' => $data['vote_average'],
            'release' => $data['release_date'],
            'runtime' => @$data['runtime'] . ' ' . trans('app.min'),
            'actors' => $actors,
            'directors' => $directors,
            'writers' => $writers,
            'countries' => $countries,
            'genres' => $genres,
        ];
    }
    
    protected function downloadThumbnail($thumbnail) {
        $data['name'] = basename($thumbnail);
        $slip = explode('.', $data['name']);
        $data['extension'] = $slip[count($slip) - 1];
        $file_name = str_replace('.' . $data['extension'], '', $data['name']);
        $new_file = Str::slug($file_name) . '-' . Str::random(10) . '-'. time() .'.' . $data['extension'];
        
        try {
            $new_dir = \Storage::disk('uploads')->path(date('Y/m/d'));
            if (!is_dir($new_dir)) {
                \File::makeDirectory($new_dir, 0775, true);
            }
            
            $get_file = file_put_contents($new_dir . '/' . $new_file, file_get_contents($thumbnail));
            if ($get_file) {
                $data['path'] = date('Y/m/d') .'/'. $new_file;
                $model = new Files();
                $model->fill($data);
                $model->type = 1;
                $model->mime_type = \Storage::disk('uploads')
                    ->mimeType($data['path']);
                $model->user_id = \Auth::id();
                $model->save();
                
                return $data['path'];
            }
        }
        catch (\Exception $exception) {
            return null;
        }
        
        return null;
    }
    
    protected function getGenreIds($genres) {
        $result = [];
        foreach ($genres as $genre) {
            if ($genre['name']) {
                $result[] = $this->addOrGetGenre($genre['name']);
            }
        }
        return $result;
    }
    
    protected function getCounrtyIds($countries) {
        $result = [];
        foreach ($countries as $country) {
            if ($country['name']) {
                $result[] = $this->addOrGetCountry($country['name']);
            }
        }
        return $result;
    }
    
    protected function getStarIds($stars, $type = 'actor') {
        $result = [];
        foreach ($stars as $star) {
            if ($star['name']) {
                $result[] = $this->addOrGetStar($star['name'], $type);
            }
        }
        return $result;
    }
    
    protected function addOrGetGenre($name) {
        $name = trim($name);
        $slug = Str::slug($name);
        $genre = Genres::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Genres();
        $model->name = $name;
        $model->slug = $slug;
        $model->save();
        return $model->id;
    }
    
    protected function addOrGetCountry($name) {
        $name = trim($name);
        $slug = Str::slug($name);
        $genre = Countries::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Countries();
        $model->name = $name;
        $model->slug = $slug;
        $model->save();
        return $model->id;
    }
    
    protected function addOrGetStar($name, $type = 'actor') {
        $name = trim($name);
        $slug = Str::slug($name);
        $genre = Stars::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Stars();
        $model->name = $name;
        $model->slug = $slug;
        $model->type = $type;
        $model->save();
        return $model->id;
    }
}