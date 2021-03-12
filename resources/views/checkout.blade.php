@extends('layouts/app')

@section('content')
  <div class="checkout-loading">
    <div class="checkout-head">
      <svg class="shopping-icon" viewBox="0 0 24 24">
        <path fill="#ffffff55" d="M17,18A2,2 0 0,1 19,20A2,2 0 0,1 17,22C15.89,22 15,21.1 15,20C15,18.89 15.89,18 17,18M1,2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.3,11.97C16.96,12.58 16.3,13 15.55,13H8.1L7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7C5.89,17 5,16.1 5,15C5,14.65 5.09,14.32 5.24,14.04L6.6,11.59L3,4H1V2M7,18A2,2 0 0,1 9,20A2,2 0 0,1 7,22C5.89,22 5,21.1 5,20C5,18.89 5.89,18 7,18M16,11L18.78,6H6.14L8.5,11H16Z" />
      </svg>
      {{ $product->name }}
    </div>
    <div class="price">{{ number_format($product->price) }}</span> /mo</div>
    <button class="payment-method" onclick="onCheckout()">
      Checkout: {{ number_format($product->price) }}
    </button>
  </div>
@endsection

@section("script")
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $client_key }}"></script>
<script type="text/javascript">
  function onCheckout () {
    fetch("/tx/create", {
      method: "POST",
      body: JSON.stringify({
        id: "{{ $product_id }}",
      }),
      headers: {
        "Content-Type": "application/json"
      }
    }).then(res => res.json()).then(result => {
      const token = result.token;

      snap.pay(token, {
        onSuccess: function(payResult) {
          alert("Transaction Success");
        },
        onPending: function(payResult) {
          alert("Transaction Pending");
        },
        onError: function(payResult) {
          alert("Transaction Error");
        },
      })
    }).catch(function() {
      alert("Error Get Token");
    })
  }
</script>
@endsection
