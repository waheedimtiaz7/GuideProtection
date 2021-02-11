<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function login(){
        if(Auth::check() && auth()->user()->user_role==User::USER_TYPE_ADMIN){
            return redirect()->route('admin.claims');
        }else if(Auth::check() && auth()->user()->user_role==User::USER_TYPE_STAFF){
            return redirect()->route('admin.claims');
        }
        return view('login');
    }
    public function verifyLogin(Request $request){
        $validate=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors());
        }else{
            if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
                if(auth()->user()->user_role==User::USER_TYPE_ADMIN){
                    return redirect()->route('admin.claims');
                }else if(auth()->user()->user_role==User::USER_TYPE_STAFF){
                    return redirect()->route('admin.claims');
                }
            }else{
                \Session::flash('error','Invalid email or password');
                return redirect()->back();
            }
        }
    }
}
