<template>
  <div class="alert alert-primary alert-notify" v-if="received">
    {{ message.message + " " + message.name }} 
  </div>
</template>
<script>
export default {
  data () {
    return {
      received: false,
      message: {}
    }
  },
  created () {
    Echo.channel('user.'+window.User.email)
      .listen('.New', (e) => {
        this.message = e
        this.received = true
      })
  }
}
</script>
