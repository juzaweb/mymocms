<?php

namespace App\Core\Http\Controllers\Backend\Setting;

use App\Core\Models\Languages;
use App\Core\Models\Translation;
use Illuminate\Http\Request;
use App\Core\Http\Controllers\Controller;

class TranslateController extends Controller
{
    public function index($lang) {
        Languages::where('key', '=', $lang)->firstOrFail();
        
        return view('backend.setting.translate.index', [
            'lang' => $lang
        ]);
    }
    
    public function getData($lang, Request $request) {
        $search = $request->get('search');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Translation::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search, $lang) {
                $subquery->orWhere('key', 'like', '%'. $search .'%');
                $subquery->orWhere('en', 'like', '%'. $search .'%');
                $subquery->orWhere($lang, 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($lang, Request $request) {
        $this->validateRequest([
            'key' => 'required|string|exists:translation,key',
            'value' => 'required|max:250',
        ], $request, [
            'key' => trans('app.key'),
            'value' => trans('app.translate'),
        ]);
        
        $model = Translation::firstOrNew(['key' => $request->post('key')]);
        $model->setAttribute($lang, $request->post('value'));
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
}
