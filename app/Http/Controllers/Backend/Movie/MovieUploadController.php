<?php

namespace App\Http\Controllers\Backend\Movie;

use App\Models\Movie\Movies;
use App\Models\Video\VideoServers;
use App\Models\Video\VideoFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class MovieUploadController extends Controller
{
    public function index($server_id) {
        $server = VideoServers::where('id', '=', $server_id)->firstOrFail();
        $movie = Movies::where('id', '=', $server->movie_id)->firstOrFail();
        
        return view('backend.movie_upload.index', [
            'server' => $server,
            'movie' => $movie,
        ]);
    }
    
    public function form($server_id, $id = null) {
        $server = VideoServers::where('id', '=', $server_id)->firstOrFail();
        $movie = Movies::where('id', '=', $server->movie_id)->firstOrFail();
        $model = VideoFiles::firstOrNew(['id' => $id]);
        
        return view('backend.movie_upload.index', [
            'title' => $model->label ? $model->label : trans('app.add_new'),
            'server' => $server,
            'movie' => $movie,
            'model' => $model,
        ]);
    }
    
    public function getData($server_id, Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = VideoFiles::query();
        $query->where('server_id', '=', $server_id);
        
        if ($search) {
            $query->orWhere('name', 'like', '%'. $search .'%');
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy('order', 'asc');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.movies.servers.upload.edit', [$row->id]);
            $row->subtitle_url = route('admin.movies.servers.upload.subtitle', [$row->id]);
            $row->url = substr($row->url, 0, 50);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($server_id, Request $request) {
        $this->validateRequest([
            'label' => 'required|string|max:250',
            'source' => 'required|string|max:100',
            //'url' => 'required_if:source,!=,upload|max:250',
            //'url_upload' => 'required_if:source,upload|max:250',
            'order' => 'required|numeric',
        ], $request, [
            'label' => trans('app.label'),
            'source' => trans('app.source'),
            'url' => trans('app.video_url'),
            'url_upload' => trans('app.video_url'),
            'order' => trans('app.order'),
        ]);
        
        if ($request->post('source') == 'gdrive') {
            if (!get_google_drive_id($request->post('url'))) {
                return response()->json([
                    'status' => 'error',
                    'message' => trans('app.cannot_get_google_drive_id'),
                ]);
            }
        }
        
        $model = VideoFiles::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->server_id = $server_id;
        $model->movie_id = $server_id;
        
        if ($request->post('source') == 'upload') {
            $model->url = image_path($request->post('url_upload'));
        }
        
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function remove($server_id, Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.servers'),
        ]);
    
        VideoFiles::destroy($request->post('ids', []));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.movies.servers.upload', [
                'server_id' => $server_id
            ]),
        ]);
    }
    
    public function getFile(Request $request) {
        $query = VideoFiles::query();
        $query->where('id', '=', $request->get('id'));
        
        if ($query->exists()) {
            return $query->first([
                'id',
                'label',
                'order',
                'source',
                'url',
            ])->toJson();
        }
        
        return json_encode([
            'status' => 'error',
            'message' => 'File not found',
        ]);
    }
}