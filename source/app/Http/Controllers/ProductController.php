<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryShop;
use App\Models\Shop;
use App\Models\ShopPrice;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    //
    public function stores(){
        $stores=Shop::where('store_type','!=',-1)->with(["categories","rep"])->get();
        return view('admin.store.index',['stores'=>$stores]);
    }
    public function categories(){
        $categories=Category::all();
        return view('admin.category.index',['header'=>'Categories','categories'=>$categories]);
    }
    public function categoryStore(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Category::create([
                    'title'=>$request['title']
                ]);
                \DB::commit();
                \Session::flash('success','Category added successfully');
                return redirect()->route('admin.categories');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function categoryEdit($id){
        $detail=Category::whereId($id)->first();
        return response()->json([
            'success'=>true,
            'category'=>$detail
        ]);
    }
    public function categoryUpdate(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'category_id'=>"required"
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                Category::whereId($request['category_id'])->update([
                    'title'=>$request['title']
                ]);
                \DB::commit();
                \Session::flash('success','Category updated successfully');
                return redirect()->route('categories');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function categoryDestroy($id){
        Category::whereId($id)->delete();
        \Session::flash('success','Category deleted successfully');
        return redirect()->route('admin.categories');
    }
    public function storePricing($id){
        $pricings=ShopPrice::whereShopId($id)->orderBy('range_from')->get();
        return view('admin.store.pricings',['header'=>'Shop Pricing','prices'=>$pricings,'shop_id'=>$id]);
    }
    public function storePricingCreate(Request $request){
        $validator=\Validator::make($request->all(),[
            'title'=>"required",
            'range_from'=>"required",
            'range_to'=>"required",
            'shop_id'=>"required",
            'price'=>"required"
            
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                ShopPrice::create([
                    'title'=>$request['title'],
                    'range_from'=>$request['range_from'],
                    'range_to'=>$request['range_to'],
                    'shop_id'=>$request['shop_id'],
                    'price'=>$request['price'],
                    'guide_price'=>$request['guide_price']                        
                ]);
                \DB::commit();
                \Session::flash('success','Shop price created successfully');
                return redirect()->to('admin/store/pricing/'.$request['shop_id']);
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function storePricingUpdate(Request $request){
        $validator=\Validator::make($request->all(),[
            'price_id'=>"required",
            'title'=>"required",
            'edit_range_from'=>"required",
            'edit_range_to'=>"required",
            'shop_id'=>"required",
            'price'=>"required"
            
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            \DB::beginTransaction();
            try {
                ShopPrice::whereId($request['price_id'])->update([
                    'title'=>$request['title'],
                    'range_from'=>$request['edit_range_from'],
                    'range_to'=>$request['edit_range_to'],
                    'shop_id'=>$request['shop_id'],
                    'price'=>$request['price'],
                    'guide_price'=>$request['guide_price'],
                ]);
                \DB::commit();
                \Session::flash('success','Shop price updated successfully');
                return redirect()->to('admin/store/pricing/'.$request['shop_id']);
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
    public function storePricingDelete($id){
        $pricings=ShopPrice::whereId($id)->first();
        ShopPrice::whereId($id)->delete();
        \Session::flash('success','Shop price deleted successfully');
        return redirect()->to('admin/store/pricing/'.$pricings->shop_id);
    }
    public function storeEdit($id){
        $categories=Category::all();
        $sale_reps=User::whereStatus(1)->whereIsSaleRep(1)->get();
        $store=Shop::whereId($id)->with('categories')->first();
        $setup_statuses=Status::whereType('setup_status')->get();
        return view('admin.store.store_detail',['header'=>'Store Details',
            'store'=>$store,
            'categories'=>$categories,
            'setup_statuses'=>$setup_statuses,
            'sale_reps'=>$sale_reps]);
    }
    public function storeUpdate(Request $request){
        $validator=\Validator::make($request->all(),[
            'display_name'=>"",
            'store_name'=>"",
            'company_name'=>"",
            'url'=>"",
            'alex_rank'=>"",
            'shopify_name'=>"",
            'category_id'=>"",
            'sales_rep'=>"",
            'paypal_account'=>"",
            'variant_id_link_base'=>"",
            'ups_acc_no'=>"",
            'fedex_acc_no'=>"",
            'usps_acc_no'=>"",
            'dhl_acc_no'=>"",
            'other_acc_no'=>"",
            'primary_poc_firstname'=>"",
            'primary_poc_lastname'=>"",
            'primary_poc_phone'=>"",
            'primary_poc_email'=>"",
            'setup_status'=>"",
            'store_processing'=>"",
            'primary_poc_title'=>""
        ]);
        if($validator->fails()){
            \Session::flash('error',$validator->errors()->first());
            return redirect()->back();
        }else{
            try {
                \DB::beginTransaction();
               Shop::whereId($request['id'])->update([
                    'display_name'=>$request['display_name'],
                    'store_name'=>$request['store_name'],
                    'company_name'=>$request['company_name'],
                    'url'=>$request['url'],
                    'alex_rank'=>$request['alex_rank'],
                    'shopify_name'=>$request['shopify_name'],
                    'sales_rep'=>$request['sales_rep'],
                    'paypal_account'=>$request['paypal_account'],
                    'variant_id_link_base'=>$request['variant_id_link_base'],
                    'ups_acc_no'=>$request['ups_acc_no'],
                    'fedex_acc_no'=>$request['fedex_acc_no'],
                    'usps_acc_no'=>$request['usps_acc_no'],
                    'dhl_acc_no'=>$request['dhl_acc_no'],
                    'other_acc_no'=>$request['other_acc_no'],
                    'primary_poc_firstname'=>$request['primary_poc_firstname'],
                    'primary_poc_lastname'=>$request['primary_poc_lastname'],
                    'primary_poc_phone'=>$request['primary_poc_phone'],
                    'primary_poc_email'=>$request['primary_poc_email'],
                    'primary_poc_title'=>$request['primary_poc_title'],
                    'setup_status'=>$request['setup_status'],
                    'store_processing'=>$request['store_processing'],
                ]);
                if(!empty($request['category_id'])){
                    $shop=Shop::find($request['id']);
                    CategoryShop::whereShopId($shop['id'])->delete();
                    $shop->categories()->attach($request['category_id']);
                }
                \DB::commit();
                \Session::flash('success','Store data updated successfully');
                return redirect()->route('admin.stores');
            }catch (Exception $exception){
                \DB::rollBack();
                \Session::flash('error',$exception->getMessage().' '.$exception->getLine());
                return redirect()->back();
            }
        }
    }
}
