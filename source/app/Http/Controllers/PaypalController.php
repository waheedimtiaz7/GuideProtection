<?php

namespace App\Http\Controllers;

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

        $payouts=new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

            $senderItem = new PayoutItem();
            $senderItem->setRecipientType('Email')
                ->setNote('Thanks for your patronage!')
                ->setReceiver('shirt-supplier-one@gmail.com')
                ->setSenderItemId("2014031400023")
                ->setAmount(new Currency('{
                            "value":"1.0",
                            "currency":"USD"
                        }'));

            $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);
            $request = clone $payouts;

            try {
                $output = $payouts->createSynchronous($this->_api_contex);
            } catch (\Exception $ex) {


                ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
                exit(1);
            }


            ResultPrinter::printResult("Created Single Synchronous Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);

        return $output;
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            \Session::put('success','Payment success !!');
            return Redirect::route('paywithpaypal');
        }

        \Session::put('error','Payment failed !!');
        return Redirect::route('paywithpaypal');
    }
}