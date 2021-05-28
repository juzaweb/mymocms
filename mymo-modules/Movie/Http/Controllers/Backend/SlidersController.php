<?php

namespace Mymo\Core\Http\Controllers\Backend\Design;

use Mymo\Core\Models\Sliders;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class SlidersController extends BackendController
{
    public function index() {
        return view('mymo_core::backend.design.sliders.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Sliders::query();
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.design.sliders.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Sliders::firstOrNew(['id' => $id]);
        return view('mymo_core::backend.design.sliders.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
        ]);
    
        $model = Sliders::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
    
        $titles = $request->post('title');
        $links = $request->post('link');
        $images = $request->post('image');
        $descriptions = $request->post('description');
    
        if (empty($titles)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('validation.required', [
                    'attribute' => trans('mymo_core::app.banners')
                ])
            ]);
        }
    
        $content = [];
        foreach ($titles as $key => $title) {
            $content[] = [
                'title' => $title,
                'link' => $links[$key],
                'image' => $images[$key],
                'description' => $descriptions[$key],
            ];
        }
    
        $model->content = json_encode($content);
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.design.sliders'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.design.sliders')
        ]);
        
        Sliders::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}