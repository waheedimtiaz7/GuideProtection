<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaypalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CustomerController::class,'index']);
Route::post('/check_order', [CustomerController::class,'checkOrder'])->name('check_order');
Route::get('/file-claim/{id}', [CustomerController::class,'fileClaim']);
Route::post('/get-claim-details', [CustomerController::class,'getClaimDetails']);
Route::post('/submit-claim-form', [CustomerController::class,'submitClaimForm']);
Route::get('/success-page', [CustomerController::class,'successPage']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::group(['prefix'=>'admin'],function (){
    Route::get("/",[LoginController::class,'login'])->name('login');
    Route::post("verify-login",[LoginController::class,'verifyLogin'])->name('verify_login');
    Route::group(['middleware'=>'auth'],function (){
        Route::group(['middleware'=>'admin'],function (){
            ////////////////////////Users////////////////////////////////////
            Route::get("users",[UserController::class,'index'])->name('admin.users');
            Route::get("user/create",[UserController::class,'create'])->name('admin.user_create');
            Route::post("user/store",[UserController::class,'store'])->name('admin.user_store');
            Route::get("user/edit/{id}",[UserController::class,'edit'])->name('admin.user_edit');
            Route::post("user/update",[UserController::class,'update'])->name('admin.user_update');
            //////////////////////////////////Category////////////////////////////////
            Route::get('categories',[ProductController::class,'categories'])->name('admin.categories');
            Route::post('category/store',[ProductController::class,'categoryStore'])->name('admin.category_store');
            Route::get('category/edit/{id}',[ProductController::class,'categoryEdit'])->name('admin.category_edit');
            Route::post('category/update',[ProductController::class,'categoryUpdate'])->name('admin.category_update');
            Route::get('category/delete/{id}',[ProductController::class,'categoryDestroy'])->name('admin.category_delete');
            //////////////////////////////////Templates////////////////////////////////
            Route::get('templates',[TemplateController::class,'index'])->name('admin.templates');
            Route::post('template/store',[TemplateController::class,'store'])->name('admin.template_store');
            Route::get('template/edit/{id}',[TemplateController::class,'edit'])->name('admin.template_edit');
            Route::post('template/update',[TemplateController::class,'update'])->name('admin.template_update');
            Route::get('template/delete/{id}',[TemplateController::class,'destroy'])->name('admin.template_delete');
            Route::post('send-mail',[TemplateController::class,'sendMail'])->name('send_mail');
            ////////////////////////Stores////////////////////////////////////
            Route::get("stores",[ProductController::class,'stores'])->name('admin.stores');
            Route::get('store/edit/{id}',[ProductController::class,'storeEdit'])->name('admin.store_edit');
            Route::post('store/update/{id}',[ProductController::class,'storeUpdate'])->name('admin.update_store');
            Route::get('store/pricing/{id}',[ProductController::class,'storePricing'])->name('admin.store_pricing');
            Route::post('store/price-create',[ProductController::class,'storePricingCreate'])->name('admin.store_price_create');
            Route::post('store/price-update',[ProductController::class,'storePricingUpdate'])->name('admin.store_price_update');
            Route::get('store/price-delete/{id}',[ProductController::class,'storePricingDelete'])->name('admin.store_price_delete');
            ////////////////////////Pages////////////////////////////////////
            Route::get('static-pages',[PageController::class,'index'])->name('admin.static_pages');
            Route::post('static-page/store',[PageController::class,'store'])->name('admin.page_store');
            Route::get('static-page/edit/{id}',[PageController::class,'edit'])->name('admin.page_edit');
            Route::post('static-page/update',[PageController::class,'update'])->name('admin.page_update');
            Route::get('static-page/delete/{id}',[PageController::class,'destroy'])->name('admin.page_delete');
        });
        //////////////////////////////////Claims////////////////////////////////
        Route::get("claims",[ClaimController::class,'index'])->name('admin.claims');
        Route::post("get-claims",[ClaimController::class,'getClaims'])->name('admin.get_claims');
        Route::get("claim-detail/{order_id}",[ClaimController::class,'claimDetail'])->name('admin.claim_detail');
        Route::post("claim-store-file",[ClaimController::class,'claimStoreFile'])->name('admin.claim_store_file');
        Route::post("update-claim",[ClaimController::class,'updateClaim'])->name('admin.update_claim');
        Route::post("save-discount-code",[ClaimController::class,'saveDiscountCode'])->name('admin.save_discount_code');
        Route::post("save-gift-card",[ClaimController::class,'saveGiftCard'])->name('admin.save_gift_card');
        Route::get("delete-claim-file/{id}",[ClaimController::class,'claimDeleteFile'])->name('admin.claim_delete_file');
        Route::get("get-mail-detail/{id}",[ClaimController::class,'getMailDetail'])->name('get_mail_detail');
        //////////////////////////////////Reports////////////////////////////////
        Route::get('reports',[ReportController::class,'index'])->name('admin.reports');
        Route::post('reports/get_report',[ReportController::class,'get_report']);
        Route::get('reports/run_report/{id}',[ReportController::class,'run_report']);
        Route::post('reports/run_report/{id}',[ReportController::class,'run_report']);
        Route::post('reports/save_report/{id}',[ReportController::class,'save_report']);
        Route::get('reports/load_report/{id}',[ReportController::class,'load_report']);
        Route::post('reports/delete_report/{id}',[ReportController::class,'delete_report']);
        Route::post('reports/run_report_with_parameters',[ReportController::class,'run_report_with_parameters']);
        Route::get('reports/set_report_session_value',[ReportController::class,'set_report_session_value']);
        Route::post('reports/set_report_session_value',[ReportController::class,'set_report_session_value']);
        Route::post('reports/generate_report_csv',[ReportController::class,'generate_report_csv']);
        Route::get('reports/generate_report_csv',[ReportController::class,'generate_report_csv']);
        Route::post('paypal', [PaypalController::class,'postPaymentWithpaypal'])->name('paymentWithPaypal');
        Route::get('paypal', [PaypalController::class,'getPaymentStatus'])->name('status');
        Route::post("logout",function (Illuminate\Http\Request $request){
            Session::flush();
            Auth::logout();
            $request->session()->invalidate();
            return redirect('admin');
        })->name('admin.logout');
    });

});
Route::get('/{slug}', [PageController::class,'getPage']);
