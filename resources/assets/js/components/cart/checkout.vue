<template>
  <div>
    <h1 class="h3">
      Checkout
    </h1>

    <h2 class="lead">
      Cart Total: ${{ amount }}
    </h2>

    <p>
      Completing the payment form below will reserve days for your campers.
    </p>

    <div v-show="initError" class="alert alert-danger">
      {{ initError }}
    </div>

    <div id="dropin-container"></div>

    <br>

    <button @click="submit" v-show="!initError" id="submit-button" class="btn btn-primary">
      Purchase
    </button>
    <a href="/cart" class="btn btn-link">
      View Cart
    </a>

  </div>
</template>

<script>
export default {
  props: {
    authorization: {
      type: String,
      required: true
    },
    amount: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      initError: ''
    }
  },

  created () {
    var button = document.querySelector('#submit-button')

    var dropin = require('braintree-web-drop-in')

    dropin.create({
      authorization: this.authorization,
      selector: '#dropin-container',
      paypal: {
        flow: 'checkout',
        amount: this.amount
      }
    }, (err, instance) => {
      if (err) {
        this.initError = 'There was a problem loading the checkout form.'
        // An error in the create call is likely due to
        // incorrect configuration values or network issues
        return
      }

      this.braintree = instance
    })
  },

  methods: {
    submit () {
      this.braintree.requestPaymentMethod((err, payload) => {
        if (err) {
          // An appropriate error will be shown in the UI
          return
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
      })
    }
  }
}
</script>
