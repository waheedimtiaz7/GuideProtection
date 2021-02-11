<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimEmail;
use App\Models\ClaimFile;
use App\Models\ClaimUpdate;
use App\Models\Shop;
use App\Models\Status;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClaimController extends Controller
{
    //
    public function index(){
        $claim_statuses=Status::whereType('claim')->get();
        $reorder_statuses=Status::whereType('re-order')->get();
        $stores=Shop::where('store_type','!=',-1)->select('shops.*')->get();
        $reps=User::whereStatus(1)->get();
        return view('admin.claims.index',[
            'header'=>'Claims',
            'reps'=>$reps,
            'stores'=>$stores,
            'claim_statuses'=>$claim_statuses,
            'reorder_statuses'=>$reorder_statuses
        ]);
    }
    public function getClaims(Request $request){
        return DataTables::of(Claim::select('claims.*')->with(['shop','claimStatus','reorderStatus','representative']))
            ->editColumn('cart_ordernumber',function ($claim){
                return '<a href="'. route('admin.claim_detail',[$claim->id]) .'">'. $claim->cart_ordernumber .'</a>';
            })->filter(function ($query) use ($request) {
                if ($request->get('date_from')!='') {
                    $query->where('claims.created_at', '>=', date("Y-m-d",strtotime($request->get('date_from'))));
                }if ($request->get('date_to')!='') {
                    $query->where('claims.created_at', '<=', date("Y-m-d H:i:s",strtotime($request->get('date_to')." 23:59:59")));
                }if ($request->get('reorder_status')!='') {
                    $query->where('reorder_status', $request->get('reorder_status'));
                }if ($request->get('claim_status')!='') {
                    $query->where('claim_status', $request->get('claim_status'));
                }if ($request->get('rep')!='') {
                    $query->where('claim_rep', $request->get('rep'));
                }if ($request->get('shop_id')!='') {
                    $query->where('shop_id', $request->get('shop_id'));
                }if ($request->get('escalated')!='') {
                    $query->where('is_escalated', $request->get('escalated'));
                }
            })
            ->addColumn('representative_name',function ($claim){
                if(!empty($claim->representative)){
                    return $claim->representative->name;
                }else{
                    return '';
                }

            })->addColumn('customer_name',function ($claim){
                return $claim->customer_firstname.' '.$claim->customer_lastname;
            })->addColumn('reorder_notify',function ($claim){
                $check=ClaimEmail::whereClaimId($claim->id)->where('email_type','reorder_notify')->first();
                if($check){
                    return '<input type="checkbox" name="reorder_notify_check" checked>';
                }else{
                    return '<input type="checkbox" name="reorder_notify_check">';
                }
            })->addColumn('track_notify',function ($claim){
                $check=ClaimEmail::whereClaimId($claim->id)->where('email_type','track_notify')->first();
                if($check){
                    return '<input type="checkbox" name="track_notify_check" checked>';
                }else{
                    return '<input type="checkbox" name="track_notify_check">';
                }
            })->addColumn('final_email',function ($claim){
                $check=ClaimEmail::whereClaimId($claim->id)->where('email_type','final_email')->first();
                if($check){
                    return '<input type="checkbox" name="final_email_check" checked>';
                }else{
                    return '<input type="checkbox" name="final_email_check">';
                }
            })->editColumn('is_escalated',function ($claim){
                if($claim->is_escalated==1){
                    return 'Escalated';
                }else{
                    return '';
                }
            })
            ->editColumn('claim_status',function ($claim){
                return isset($claim->claimStatus->value)?$claim->claimStatus->title:"";
            })->editColumn('claim_status',function ($claim){
                return isset($claim->claimStatus->value)?$claim->claimStatus->title:"";
            })->editColumn('reorder_status',function ($claim){
                return isset($claim->reorderStatus->value)?$claim->reorderStatus->title:"";
            })->editColumn('created_at',function ($claim){
                return date('m/d/Y',strtotime($claim->created_at));
            })->rawColumns(['cart_ordernumber','reorder_notify','track_notify','final_email'])
            ->make(true);
    }
    public function claimDetail($order_id){
        $detail=Claim::with(['order','shop','order.order_detail','claim_detail','files','incidentType'])->where('id',$order_id)->first();
        $claim_statuses=Status::whereType('claim')->get();
        $reorder_statuses=Status::whereType('re-order')->get();
        $reps=User::whereStatus(1)->get();
        $previous_claims =Claim::with(['order','shop','order.order_detail','claim_detail','files','incidentType'])->where('customer_email',$detail->customer_email)->where('id','!=',$order_id)->get();
        $history =ClaimUpdate::where('claim_id',$detail->id)->get();
        return view('admin.claims.claim_detail',[
            'header'=>'Claim Detail',
            'claim'=>$detail,
            "claim_statuses"=>$claim_statuses,
            "previous_claims"=>$previous_claims,
            "reps"=>$reps,
            "history"=>$history,
            "reorder_statuses"=>$reorder_statuses
        ]);
    }
    public function updateClaim(Request $request){
        $validator=\Validator::make($request->all(),[
            'claim_id'=>"required",
            'claim_status'=>''
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>true,
                'message'=>$validator->errors()->first()
            ]);
        }else {
            try {
                \DB::beginTransaction();
                $update=Claim::whereId($request['claim_id']);
                $claim=$update->with(['claimStatus','reorderStatus','representative'])->first();
                if($claim->claim_status!=$request['claim_status']){
                    $status=Status::whereType('claim')->whereValue($request['claim_status'])->first();
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'claim_status',
                        'original_value'=>$claim->claim_status,
                        'updated_value'=>$request['claim_status'],
                        'detail'=>'Claim status updated to '.$status->title.' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['claim_status'=>$request['claim_status']]);
                }
                if($claim->claim_rep!=$request['claim_rep'] && !empty($request['claim_rep'])){
                    $rep=User::whereId($request['claim_rep'])->first();
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'claim_rep',
                        'original_value'=>$claim->claim_rep,
                        'updated_value'=>$request['claim_rep'],
                        'detail'=>$rep->name.' assigned as claim rep by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['claim_rep'=>$request['claim_rep']]);
                }
                if($claim->reorder_status!=$request['reorder_status']){
                    $reorder=Status::whereType('re-order')->whereValue($request['reorder_status'])->first();
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'reorder_status',
                        'original_value'=>$claim->reorder_status,
                        'updated_value'=>$request['reorder_status'],
                        'detail'=>'Claim reorder status updated to '.$reorder->title.' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['reorder_status'=>$request['reorder_status']]);
                }
                if($claim->gp_reorder_trackno!=$request['gp_reorder_trackno']){
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'gp_reorder_trackno',
                        'original_value'=>$claim->gp_reorder_trackno,
                        'updated_value'=>$request['gp_reorder_trackno'],
                        'detail'=>'Claim GP reorder tracking # updated to '.$request['gp_reorder_trackno'].' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['gp_reorder_trackno'=>$request['gp_reorder_trackno']]);
                }
                if($claim->reorder_trackingnumber!=$request['reorder_trackingnumber']){
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'reorder_trackingnumber',
                        'original_value'=>$claim->reorder_trackingnumber,
                        'updated_value'=>$request['reorder_trackingnumber'],
                        'detail'=>'Claim reorder tracking # updated to '.$request['reorder_trackingnumber'].' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['reorder_trackingnumber'=>$request['reorder_trackingnumber']]);
                }if($claim->reorder_cartnumber!=$request['reorder_cartnumber']){
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'reorder_cartnumber',
                        'original_value'=>$claim->reorder_cartnumber,
                        'updated_value'=>$request['reorder_cartnumber'],
                        'detail'=>'Claim reorder # updated to '.$claim->reorder_cartnumber.' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['reorder_cartnumber'=>$request['reorder_cartnumber']]);
                }
                if(date('Y-m-d',strtotime($claim->hold_until_date))!=date('Y-m-d',strtotime($request['hold_until_date']))){
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'reorder_cartnumber',
                        'original_value'=>$claim->hold_until_date,
                        'updated_value'=>$request['hold_until_date'],
                        'detail'=>'Hold until date updated to '.$claim->hold_until_date.' by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['hold_until_date'=>date('Y-m-d',strtotime($request['hold_until_date']))]);
                }if(isset($request['escalate'])){
                    if($claim->escalate!=$request['escalate']){
                        ClaimUpdate::create([
                            'claim_id'=>$request['claim_id'],
                            'updated_by'=>\Auth::user()->id,
                            'column_name'=>'escalate',
                            'original_value'=>$claim->escalate,
                            'updated_value'=>$request['escalate'],
                            'detail'=>'Claim is escalated by '.\Auth::user()->name,
                            'date_updated'=>date('Y-m-d H:i:s'),
                        ]);
                        $update->update(['is_escalated'=>isset($request['escalate'])?$request['escalate']:0]);
                    }
                }
                if($claim->notes!=$request['notes']){
                    ClaimUpdate::create([
                        'claim_id'=>$request['claim_id'],
                        'updated_by'=>\Auth::user()->id,
                        'column_name'=>'notes',
                        'original_value'=>$claim->notes,
                        'updated_value'=>$request['notes'],
                        'detail'=>'Claim notes updated by '.\Auth::user()->name,
                        'date_updated'=>date('Y-m-d H:i:s'),
                    ]);
                    $update->update(['notes'=>$request['notes']]);
                }
                \DB::commit();
                return response()->json([
                    'success'=>true,
                    'message'=>'Claim info updated successfully'
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'error'=>true,
                    'message'=>$exception->getMessage().' '.$exception->getLine()
                ]);
            }
        }
    }
    public function claimStoreFile(Request $request){
        $validator=\Validator::make($request->all(),[
            'file'=>"required",
            'claim_id'=>"required",
            'description'=>''
        ]);
        if($validator->fails()){
           return response()->json([
               'error'=>true,
               'message'=>$validator->errors()->first()
           ]);
        }else{
            try {
                $file=$request->file('file');
                $name=$file->getClientOriginalName();
                $file->move('assets/claims/'.$request['claim_id'],$name);
                $path='assets/claims/'.$request['claim_id'].'/'.$name;
                $claim=ClaimFile::create([
                    'claim_id'=>$request['claim_id'],
                    'user_id'=>\Auth::user()->id,
                    'filename'=>$name,
                    'path'=>$path,
                    'description'=>$request['description']
                ]);
                $files=ClaimFile::whereClaimId($request['claim_id'])->get();
                return response()->json([
                    'success'=>true,
                    'message'=>'File stored successfully.',
                    'files'=>$files
                ]);
            }catch (\Exception $exception){
                return response()->json([
                    'error'=>true,
                    'message'=>$exception->getMessage().' '.$exception->getLine()
                ]);
            }
        }
    }
    public function deleteClaimFile($id){
        ClaimFile::whereId($id)->delete();
        \Session::flash('error','File deleted successfully');
        return redirect()->back();
    }
    public function getMailDetail($id){
        $template=Template::whereId($id)->first();
        return response()->json([
            'success'=>true,
            'message'=>'File stored successfully.',
            'template'=>$template,
            "detail"=>$template->detail
        ]);
    }

}
