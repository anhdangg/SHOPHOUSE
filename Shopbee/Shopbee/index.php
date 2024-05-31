<?php
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient('sk_test_51N9rxbGNEwXQC17lvxHBFTDKbZbE9Fz8QMcgoWhMlE0Rv6SWsPnRoXZ1cxj5PFF3LMZITEBbfCQ1teGeqhoZBJFi00Udv86La4');

// Use an existing Customer ID if this is a returning customer.
$customer = $stripe->customers->create(
    [
        'name' => 'An',
        'address' => [
            'line1' => 'Demo Address',
            'postal_code' => '738933',
            'city' => 'Ho Chi Minh',
            'country' => 'Ho Chi Minh',
            'state' => 'Ho Chi Minh'
        ]
    ]
);
$ephemeralKey = $stripe->ephemeralKeys->create([
  'customer' => $customer->id,
], [
  'stripe_version' => '2022-11-15',
]);
$paymentIntent = $stripe->paymentIntents->create([
  'amount' => 10,
  'currency' => 'vnd',
  'customer' => $customer->id,
  // In the latest version of the API, specifying the `automatic_payment_methods` parameter
  // is optional because Stripe enables its functionality by default.
  'automatic_payment_methods' => [
    'enabled' => 'true',
  ],
]);

echo json_encode(
  [
    'paymentIntent' => $paymentIntent->client_secret,
    'ephemeralKey' => $ephemeralKey->secret,
    'customer' => $customer->id,
    'publishableKey' => 'pk_test_51N9rxbGNEwXQC17lfE44gnaQICdOPJPoLKFPpmvSa5iNmHoNyfex4OKFAzFcd8ViJqVCLNOrIqMZrNDlzw2nEuVK007h6quzav'
  ]
);
http_response_code(200);