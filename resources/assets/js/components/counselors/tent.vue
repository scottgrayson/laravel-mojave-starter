<template>
  <div>
    <!--h1 class="text-center">{{tent.name}}</h1-->
    <hr>
  <div>
    <div class="d-flex flex-row justify-content-between align-items-center m-2">
      <a class="btn btn-outline-secondary">
        Previous
      </a>
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
          Dropdown button
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" v-for="(value, key) in weeks">{{key}}</a>
        </div>
      </div>
      <a class="btn btn-outline-secondary">
        Next
      </a>
    </div>
    <ul class="list-group">
      <li v-for="camper in campers"
        class="list-group-item">
        {{camper.name}}
      </li>
    </ul>
  </div>
</div>
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
        weeks: [],
        campers: {},
        selectedWeek: ''
      }
    },
    created () {
      axios.get('/api/tents/'+this.tent.id)
        .then((response) => {
          this.campers = response.data
        })
      axios.get('/api/camp-dates/')
        .then((response) => {
          this.weeks = response.data
          console.log(response.data)
        })
    }
  }
</script>
