<?php

namespace App\Http\Controllers;

use App\Models\ReportQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    //
    public function index(){
       
        $users=User::all();
        return view('admin.user.index',['header'=>"Users","users"=>$users ]);
    }
    public function create(){
        $reports = ReportQuery::all();
        return view('admin.user.add',['header'=>"Add User", 'reports' => $reports]);
    }
    public function store(Request $request){
        $validator=\Validator::make($request->all(),[
            'firstname'=>"required",
            'lastname'=>"required",
            'email'=>"required",
            'user_role'=>"required",
            'is_sale_rep'=>"",
            'password'=>"required",
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                $user = User::create([
                    'name'=>$request['firstname'].' '.$request['lastname'],
                    'firstname'=>$request['firstname'],
                    'lastname'=>$request['lastname'],
                    'is_sale_rep'=>isset($request['is_sale_rep'])?1:0,
                    'email'=>$request['email'],
                    'user_role'=>$request['user_role'],
                    'password'=>\Hash::make($request['password'])
                ]);

                $user->reports()->sync($request['user_reports']);
                \DB::commit();
                \Session::flash('success','User added successfully');
                return redirect()->route('admin.users');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function edit($id){
        $reports = ReportQuery::all();
        $user=User::whereId($id)->first();
        return view('admin.user.edit',['header'=>"Edit User",'user'=>$user, 'reports' => $reports ]);
    }
    public function update(Request $request){
        //dd($request->all());
        $validator=\Validator::make($request->all(),[
            'user_id'=>"required",
            'firstname'=>"required",
            'lastname'=>"required",
            'user_role'=>"required",
            'is_sale_rep'=>"",
            'username'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else {
            \DB::beginTransaction();
            try {
                 User::whereId($request['user_id'])->update([
                    'name'          =>  $request['firstname'] . ' ' . $request['lastname'],
                    'firstname'     =>  $request['firstname'],
                    'username'      =>  $request['username'],
                    'lastname'      =>  $request['lastname'],
                    'is_sale_rep'   =>  isset($request['is_sale_rep'])?1:0,
                    'user_role'     =>  $request['user_role']
                ]);

                $user = User::find($request['user_id']);
                $user->reports()->sync($request['user_reports']);
                \DB::commit();
                \Session::flash('success','User updated successfully');
                return redirect()->route('admin.users');
            } catch (Exception $exception) {
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage() . ' ' . $exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function delete($id){
        User::whereId($id)->delete();
        \Session::flash('success','User deleted successfully');
        return redirect()->route('admin.users');
    }

}
