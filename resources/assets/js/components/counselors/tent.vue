<template>
</template>

<script>
  export default {
    props: {
      tent: {
        required: true,
        type: Object
      }
    },
    data () {
      return {
      }
    },
    created () {
      axios.get('/api/tent/'+this.tent.id)
        .then((response) => {
          console.log(response)
        })
    }
  }
</script>
