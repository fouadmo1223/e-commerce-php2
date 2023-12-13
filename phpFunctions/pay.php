<?php
require_once('vendor/autoload.php'); // Include Stripe PHP library

\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['stripeToken'];

    try {
        \Stripe\Charge::create([
            'amount' => 1000, // Amount in cents
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Example Charge',
        ]);

        echo 'Payment successful!';
    } catch (\Stripe\Exception\CardException $e) {
        // Card was declined
        echo $e->getError()->message;
    } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly
        echo $e->getError()->message;
    } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API
        echo $e->getError()->message;
    } catch (\Stripe\Exception\AuthenticationException $e) {
        // Authentication with Stripe's API failed
        echo $e->getError()->message;
    } catch (\Stripe\Exception\ApiConnectionException $e) {
        // Network communication with Stripe failed
        echo $e->getError()->message;
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Generic error
        echo $e->getError()->message;
    }
}
?>