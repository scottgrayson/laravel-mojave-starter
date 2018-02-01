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
      initError: '',
      dropin: '',
      selectedPaymentOption: '',
      braintree: null,
      processing: false
    }
  },

  created () {
    var button = document.querySelector('#submit-button')

    var dropin = require('braintree-web-drop-in')

    dropin.create({
      authorization: this.authorization,
      container: '#dropin-container',
      card: {
        cardholderName: {
          required: true
        }
      },
      paypal: {
        flow: 'vault',
      }
    }, (err, instance) => {
      if (err) {
        this.initError = 'There was a problem loading the checkout form.'
        // An error in the create call is likely due to
        // incorrect configuration values or network issues
        return
      }

      instance.on('paymentOptionSelected', (event) => {
        this.selectedPaymentOption = event.paymentOption
      })

      $('[data-braintree-id=toggle]').click(() => {
        this.selectedPaymentOption = ''
      })

      this.braintree = instance
      this.dropin = dropin
    })
  },

  methods: {
    submit () {
      this.processing = true
        swal({
          title: 'Processing...',
          text: 'Your payment is being processed',
          icon: 'info',
          button: false,
          closeOnClickOutside: false,
          closeOnEsc: false
        })

      this.braintree.requestPaymentMethod((err, payload) => {
        if (err) {
          this.processing = false
          swal.close()
          // An appropriate error will be shown in the UI
          return
        }

        // Submit payload.nonce to your server
        axios.post('/api/payments', payload)
          .then((response) => {
            window.location.href = '/invoices/'+response.data.invoice_id
          })
          .catch((error) => {
            this.processing = false
            swal({
              text: 'Error processing payment.',
              icon: 'error'
            })
          })
      })
    }
  }
}
</script>
