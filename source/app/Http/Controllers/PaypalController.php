<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\PaypalPayment;
use App\Models\Shop;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Currency;
use PayPal\Api\PayoutItem;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Payout;
class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function payWithPaypal()
    {
        return view('paywithpaypal');
    }

    public function postPaymentWithpaypal(Request $request)
    {
        $shop=Shop::whereId($request['shop_id'])->first();
        $check=Claim::whereId($request['claim_id'])->first();
        if(!empty($check->payout_batch_id)){
            return response()->json(['error'=>true,'message'=>'This claim has already been submitted for payout.']);
        }
        $payouts=new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");
            $senderItem = new PayoutItem();
            $senderItem->setRecipientType('Email')
                ->setNote('Thanks for your patronage!')
                ->setReceiver("spencerbknight@gmail.com")
                ->setSenderItemId($check->id)
                ->setAmount(new Currency('{
                            "value":'. $request['amount'] .',
                            "currency":"USD"
                        }'));
            $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);
            $request = clone $payouts;
            try {
                $output = $payouts->createSynchronous($this->_api_context);
                if(isset($output->batch_header) && !isset($output->batch_header->errors)){
                    $id=PaypalPayment::create([
                        'payout_batch_id'=>$output->batch_header->payout_batch_id,
                        'batch_status'=>$output->batch_header->batch_status,
                        'sender_batch_header'=>$output->batch_header->sender_batch_header->sender_batch_id,
                        'link'=>$output->links[0]->href,
                        'claim_id'=>$request['claim_id'],
                        'shop_id'=>$request['shop_id']
                    ]);
                    Claim::whereId($request['claim_id'])->update([
                        'payout_batch_id'=>$output->batch_header->payout_batch_id,'paypal_payment_id'=>$id->id
                    ]);
                    return response()->json(['success'=>true,'message'=>'Payout created successfully']);
                }else{
                    return response()->json(['error'=>true,'message'=>$output]);
                }

            } catch (\Exception $ex) {
                return response()->json(['error'=>true,'message'=>$ex->getMessage()]);
            }
    }

    public function getPaymentStatus(Request $request)
    {
        $payouts=new Payout();
        $status=$payouts->get("MJBQ95HF75KNY", $this->_api_context );
        echo '<pre>';
        print_r($status);exit;
        \Session::put('error','Payment failed !!');
        //return Redirect::route('paywithpaypal');
    }
}