<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Exception;

class PageController extends Controller
{
    //
    public function index(){
        $pages=Page::all();
        return view('admin.pages.index',['header'=>'Static Pages','pages'=>$pages]);
    }
    public function store(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'detail'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Page::create([
                    'title'=>$request['title'],
                    'slug'=>strtolower(str_replace('','-',$request['title'])),
                    'detail'=>htmlentities($request['detail']),
                ]);
                \DB::commit();
                \Session::flash('success','Static page added successfully');
                return redirect()->route('admin.static_pages');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function edit($id){
        $detail=Page::whereId($id)->first();
        $detail->detail=html_entity_decode($detail->detail);
        return response()->json([
            'success'=>true,
            'page'=>$detail
        ]);
    }
    public function update(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'detail'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Page::whereId($request['page_id'])->update([
                    'title'=>$request['title'],
                    'slug'=>strtolower(str_replace('','-',$request['title'])),
                    'detail'=>htmlentities($request['detail']),
                ]);
                \DB::commit();
                \Session::flash('success','Static page added successfully');
                return redirect()->route('admin.static_pages');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function destroy($id){
        Page::whereId($id)->delete();
        \Session::flash('success','Static page deleted successfully');
        return redirect()->route('admin.static_pages');
    }
    public function getPage($slug){
        $page=Page::whereSlug($slug)->first();
        if($page){
            return view('page',['header'=>$page->title,'detail'=>$page->detail]);
        }else{
            return redirect()->to('/');
        }
    }
}
