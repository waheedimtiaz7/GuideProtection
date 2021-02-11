<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Order;
use App\Models\Page;
use App\Models\Shop;
use App\Models\Status;
use App\Models\Template;
use Illuminate\Http\Request;
use Exception;

class TemplateController extends Controller
{
    public function index(){
        $templates=Template::all();
        foreach ($templates as $template){
            $detail=str_replace("&lt;&lt;","{{",$template->detail);
            $detail=str_replace("&gt;&gt;","}}",$detail);
            Template::whereId($template->id)->update(["detail"=>$detail]);
        }
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
            'mail_subject'=>'required',
            'mail_claim_id'=>'',
            'mail_template_id'=>'',
            'to'=>'required',
            'mail_detail'=>'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'error'=>true,
                'message'=>$validate->errors()->first()
            ]);
        }else{
            $claim=Claim::whereId($request['mail_claim_id'])->first();
            $order=Order::whereId($claim->order_id)->with(['order_detail'])->first();
            $shop=Shop::whereId($order->shop_id)->first();
            if(!empty($request['mail_template_id'])){
                $template=Template::whereId($request['mail_template_id'])->first();
                $detail=str_replace("{{first name}}",$order->customer_firstname,$request['mail_detail']);
                $detail=str_replace("{{store display name}}",$shop->display_name,$detail);
                $detail=str_replace("{{order number}}",$order->cart_orderid,$detail);
                $detail=str_replace("{{replacement tracking number}}",$claim->reorder_trackingnumber,$detail);
                \Mail::send('emails.index',['user'=>$order,'store'=>$shop,'title'=>$template->title,'template'=>$template,'detail'=>$detail],function ($mail) use ($request,$order,$template){
                    $mail->to($request['to'], $order->customer_firstname)->subject($request['mail_subject']);
                });
            }else{
                \Mail::send('emails.index',['user'=>$order,'store'=>$shop,'title'=>"Guide Protection",'detail'=>$request['mail_detail']],function ($mail) use ($request,$order,$template){
                    $mail->to($request['to'], $order->customer_firstname)->subject($request['mail_subject']);
                });
            }
            return response()->json([
                'success'=>true
            ]);
        }
    }
}
