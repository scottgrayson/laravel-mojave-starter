<template>
  <span v-show="count">
    {{ count }}
  </span>
</template>

<script>
export default {
  props: ['initialCount'],

  data () {
    return {
      count: 0
    }
  },

  created () {
    this.count = parseInt(this.initialCount)

    bus.$on('cart-updated', (count) => {
      this.count = count
    })
  }
}
</script>
