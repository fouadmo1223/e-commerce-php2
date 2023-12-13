<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pay.css">
    <title>Payment Page</title>
</head>
<body>
    <div class="container">
        <h2>Payment Details</h2>
        <form id="payment-form">
            <label for="card-element" style="margin-bottom:10px">
                Credit or debit card
            </label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
            <button id="submit">Submit Payment</button>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var stripe = Stripe('YOUR_STRIPE_PUBLIC_KEY');
    var elements = stripe.elements();
    
    var card = elements.create('card');
    card.mount('#card-element');
    
    var form = document.getElementById('payment-form');
    var errorElement = document.getElementById('card-errors');
    
    form.addEventListener('submit', function (event) {
        event.preventDefault();
    
        stripe.createToken(card).then(function (result) {
            if (result.error) {
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });
    
    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
    
        form.submit();
    }
});

    </script>
    <!-- <script src="scripts.js"></script> -->
</body>
</html>
