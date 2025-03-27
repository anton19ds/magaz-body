<?php
$stripeSecretKey = 'sk_test_51R6I4lQPlHTMzkKi7ziNvNaoyyy8RCcw5zYs35TrhvsZQ8PVWke17BJhxd3qAiuNDqdDNRQkeSt77EEvu0v6zsnp007EZNAcrA';


\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:8204';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => 'price_1R6IMsQPlHTMzkKiOEeEoTub',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);