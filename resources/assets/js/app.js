
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')
window.bus = new Vue()

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./utils/utc-to-local')

//Vue.component('vue-socket', require('./components/VueSocket.vue'))
Vue.component('camp-calendar', require('./components/calendar/calendar.vue'))
Vue.component('cart-count', require('./components/cart/cart-count.vue'))

const app = new Vue({
  el: '#app'
})
