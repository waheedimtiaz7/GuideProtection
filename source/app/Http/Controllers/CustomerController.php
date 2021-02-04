<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimOrderDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shop;
use App\Models\Status;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    public function index(){
        return view('index',['header'=>'Customer Claim']);
    }
    public function checkOrder(Request $request){
        $check_claim=Claim::whereCustomerEmail($request->get('email'))->where('cart_ordernumber',$request->get('order_number'))->first();
        if($check_claim){
            return response()->json([
                'error'=>true,
                'message'=>'Already claim is created for this order'
            ]);
        }
        $check=Order::whereCustomerEmail($request->get('email'))->where('cart_orderid',$request->get('order_number'))
            ->whereHas('shop')->first();
        if($check){
            return response()->json([
                'success'=>true,
                'order'=>$check
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'message'=>'Order not found. If you think you\'r receiving this by mistake, please contact your store\'s customer service.'
            ]);
        }
    }
    public function fileClaim($id){
        $order=Order::where('id',$id)->with('order_detail')->first();
        $store=Shop::whereId($order->shop_id)->first();
        $incident_types=Status::whereType('incident-type')->get();
        return view('file_compliant',["order"=>$order,'incident_types'=>$incident_types,"store"=>$store]);
    }
    public function submitClaimForm(Request $request){
        try {
            DB::beginTransaction();
            $order=Order::whereId($request['order_id'])->with(['order_detail'])->first();
            $shop=Shop::whereId($order->shop_id)->first();
            $claim=Claim::create([
                'incident_type' =>$request['incident_type'],
                'incident_description'=>$request['incident_description'],
                'store_id'=>$order->store_id,
                'shop_id'=>$order->shop_id,
                'store_ordernumber'=>$order->store_ordernumber,
                'cart_ordernumber'=>$order->cart_orderid,
                'cart_trackingnumber'=>$request['cart_trackingnumber'],
                'order_id'=>$order->id,
                'claim_status'=>1,
                'orderdate'=>date('Y-m-d',strtotime($order->orderdate)),
                'customer_reported_trackno'=>$order->cart_ship_trackno,
                'customer_firstname'=>$order->customer_firstname,
                'customer_lastname'=>$order->customer_lastname,
                'customer_email'=>$order->customer_email,
                'customer_phone'=>$order->customer_phone,
                'shipping_addresss_1'=>$order->shipping_addresss_1,
                'shipping_addresss_2'=>$order->shipping_addresss_2,
                'shipping_city'=>$order->shipping_city,
                'shipping_state'=>$order->shipping_state,
                'shipping_zip'=>$order->shipping_zip,
                'shipping_country'=>$order->shipping_country,
                'shipping_carrier_method'=>$order->shipping_carrier_method
            ]);
            foreach ($request['item'] as $k=>$item){
                $order_detail=OrderDetail::whereId($request['item'][$k])->first();
                ClaimOrderDetail::create([
                    "claim_id"=>$claim->id,
                    "order_detail_id"=>$request['item'][$k],
                    "quantity"=>$request['qty'][$k],
                    "variantid"=>$order_detail->cart_variantid,
                    "product_id"=>$order_detail->cart_productid
                ]);
            }
            $template=Template::whereType($request['incident_type'])->first();
            \Mail::send('emails.index',['user'=>$order,'store'=>$shop,'title'=>$template->title,'template'=>$template,'detail'=>$template->detail],function ($mail) use ($request,$order,$template){
                $mail->to($order->customer_email, $order->customer_firstname)->subject($template->subject);
            });
            DB::commit();
            return response()->json([
                'success'=>true
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'error'=>false,
                'message'=>$exception->getMessage().' '.$exception->getLine()
            ]);
        }
    }
    public function successPage(){
        return view('claim_success');
    }
}
