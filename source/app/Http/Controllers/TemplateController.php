<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Template;
use Illuminate\Http\Request;
use Exception;

class TemplateController extends Controller
{
    public function index(){
        $templates=Template::all();
        $claim_statuses=Status::whereType('claim')->get();
        $reorder_statuses=Status::whereType('re-order')->get();
        return view('admin.template.index',['header'=>'Templates','templates'=>$templates,
            'claim_statuses'=>$claim_statuses,
            'reorder_statuses'=>$reorder_statuses
        ]);
    }
    public function store(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'subject'=>"required",
            'claim_status'=>"",
            'reorder_status'=>"",
            'detail'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Template::create([
                    'title'=>$request['title'],
                    'subject'=>$request['subject'],
                    'claim_status'=>$request['claim_status'],
                    'reorder_status'=>$request['reorder_status'],
                    'detail'=>htmlentities($request['detail']),
                ]);
                \DB::commit();
                \Session::flash('success','Template added successfully');
                return redirect()->route('admin.templates');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function edit($id){
        $detail=Template::whereId($id)->first();
        $claim_statuses=Status::whereType('claim')->get();
        $reorder_statuses=Status::whereType('re-order')->get();
        $detail->detail=html_entity_decode($detail->detail);
        return response()->json([
            'success'=>true,
            'claim_statuses'=>$claim_statuses,
            'reorder_statuses'=>$reorder_statuses,
            'category'=>$detail
        ]);
    }
    public function update(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'subject'=>"required",
            'detail'=>"required",
            'claim_status'=>"",
            'reorder_status'=>"",
            'template_id'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Template::whereId($request['template_id'])->update([
                    'title'=>$request['title'],
                    'subject'=>$request['subject'],
                    'claim_status'=>$request['claim_status'],
                    'reorder_status'=>$request['reorder_status'],
                    'detail'=>htmlentities($request['detail']),
                ]);
                \DB::commit();
                \Session::flash('success','Template updated successfully');
                return redirect()->route('templates');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function destroy($id){
        Template::whereId($id)->delete();
        \Session::flash('success','Template deleted successfully');
        return redirect()->route('admin.templates');
    }
    public function sendMail(Request $request){
        $validate=\Validator::make($request->all(),[
            'subject'=>'required',
            'to'=>'required',
            'detail'=>'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'error'=>true,
                'message'=>$validate->errors()->first()
            ]);
        }else{
            \Mail::send('emails.index',['detail'=>$request['detail']],function ($mail) use ($request){
                $mail->to($request['to'], 'Guide Protection')->subject('Guide Protection');
            });
            return response()->json([
                'success'=>true
            ]);
        }
    }
}
