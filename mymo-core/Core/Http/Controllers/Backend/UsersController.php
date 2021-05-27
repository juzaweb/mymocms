<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\User;

class UsersController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.users.index');
    }
    
    public function getData(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = User::query();
        $query->where('id', '>', 1);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
            });
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
            $row->thumb_url = $row->getAvatar();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.users.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $model = User::firstOrNew(['id' => $id]);
        return view('mymo_core::backend.users.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,',
            'avatar' => 'nullable|mimetypes:image/jpeg,image/png,image/gif',
            'email' => 'required_if:id,|unique:users,email',
            'status' => 'required|in:0,1',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'email' => trans('mymo_core::app.email'),
            'password' => trans('mymo_core::app.password'),
            'avatar' => trans('mymo_core::app.avatar'),
            'status' => trans('mymo_core::app.status'),
        ]);
        
        $model = User::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->is_admin = $request->post('is_admin');
        
        if (empty($model->id)) {
            $model->setAttribute('email', $request->post('email'));
        }
        
        if ($request->post('password')) {
            $this->validateRequest([
                'password' => 'required|string|max:32|min:6|confirmed',
                'password_confirmation' => 'required|string|max:32|min:6'
            ], $request, [
                'password' => trans('mymo_core::app.password'),
                'password_confirmation' => trans('mymo_core::app.confirm_password')
            ]);
            
            $model->setAttribute('password', \Hash::make($request->post('password')));
        }
        
        $model->save();
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $extention = $avatar->getClientOriginalExtension();
            $newname = $model->id . '.' . $extention;
            $upload = $avatar->storeAs('avatars', $newname, 'public');
            
            if ($upload) {
                User::where('id', '=', $model->id)
                    ->update([
                        'avatar' => 'avatars/' . $newname
                    ]);
            }
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.users'),
        ]);
    }
    
    public function remove(Request $request)
    {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.users')
        ]);
        
        User::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
