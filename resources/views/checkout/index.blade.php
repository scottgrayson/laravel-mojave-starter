@extends('layouts.app')

@section('content')
  <h1 class="h3">
    Checkout
  </h1>

  <h2 class="lead">
    Cart Total: ${{ $amount }}
  </h2>

  <p>
    Completing the payment form below will reserve days for your campers.
  </p>

  <div id="dropin-container"></div>

  <br>

  <button id="submit-button" class="btn btn-primary">Purchase</button>
  <a href="{{route('cart.index')}}" class="btn btn-link">
    View Cart
  </a>

@endsection

@section('scripts')
  @parent
  <!-- Load PayPal's checkout.js Library. -->
  <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>

  <!-- Load the client component. -->
  <script src="https://js.braintreegateway.com/web/3.24.1/js/client.min.js"></script>

  <!-- Load the PayPal Checkout component. -->
  <script src="https://js.braintreegateway.com/web/3.24.1/js/paypal-checkout.min.js"></script>

  <script src="https://js.braintreegateway.com/web/dropin/1.4.0/js/dropin.js"></script>

  <script>
    var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: '{{ $clientToken }}',
  selector: '#dropin-container',
  paypal: {
    flow: 'checkout',
    amount: '{{ Cart::total() }}'
  }
}, function (err, instance) {
  if (err) {
    // An error in the create call is likely due to
    // incorrect configuration values or network issues
    return;
  }

  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
      if (err) {
        // An appropriate error will be shown in the UI
        return;
      }

      // Submit payload.nonce to your server
      axios.post('/api/payments', payload)
        .then(res => {
          swal({
            title: 'Payment Successful',
            text: 'Camp dates reserved.',
            icon: 'success',
            buttons: ['Close', 'View Calendar'],
          })
            .then(wantsRedirect => {
              if (wantsRedirect) {
                window.location.href = '/calendar'
              }
            })
        })
    });
  })
});
  </script>
@endsection
