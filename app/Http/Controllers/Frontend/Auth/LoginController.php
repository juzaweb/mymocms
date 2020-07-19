<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index() {
    
    }
    
    public function login(Request $request) {
        $this->validateRequest([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'nullable|numeric',
        ], $request, [
            'email' => trans('app.email'),
            'password' => trans('app.password'),
            'remember' => 'nullable|numeric',
        ]);
        
        
    }
    
    public function logout() {
        \Auth::logout();
        return redirect()->route('home');
    }
}
