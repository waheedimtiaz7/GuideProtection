<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'client_id' => 'AcVA_MW2bnS4xvIa8wm9-nB5-EX916RxfEsWeo4KBBFEb0EGjyF2D-6bBAF8Y84DWIPbQQd-OqggrcD9',
    'secret' => 'EP9jZODB4S5mnGl5FGJCyoZaIG05O2O6BJkC33cekyeEmsDaNMQNboWLXy3ZtIwOcmvUfBn-M1AhYeeL',
    'settings' => array(
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];
/*return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'client_id'         => env('AcVA_MW2bnS4xvIa8wm9-nB5-EX916RxfEsWeo4KBBFEb0EGjyF2D-6bBAF8Y84DWIPbQQd-OqggrcD9', ''),
        'client_secret'     => env('EP9jZODB4S5mnGl5FGJCyoZaIG05O2O6BJkC33cekyeEmsDaNMQNboWLXy3ZtIwOcmvUfBn-M1AhYeeL', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => '',
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
    'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
];*/
