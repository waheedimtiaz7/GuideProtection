<?php

namespace App\Http\Controllers;

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
        $payouts=new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");
            $senderItem = new PayoutItem();
            $senderItem->setRecipientType('Email')
                ->setNote('Thanks for your patronage!')
                ->setReceiver($shop->paypal_account)
                ->setSenderItemId("2014031400023")
                ->setAmount(new Currency('{
                            "value":'. $request['amount'] .',
                            "currency":"USD"
                        }'));
            $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);
            $request = clone $payouts;
            try {
                $output = $payouts->createSynchronous($this->_api_context);
            } catch (\Exception $ex) {
                print_r($ex->getMessage());
               // ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
                exit(1);
            }


        return $output;
    }

    public function getPaymentStatus(Request $request)
    {
        $payouts=new Payout();
        $status=$payouts->get("UB2SSMFXD8NYG", $this->_api_context );
        echo '<pre>';
        print_r($status);exit;
        \Session::put('error','Payment failed !!');
        //return Redirect::route('paywithpaypal');
    }
}