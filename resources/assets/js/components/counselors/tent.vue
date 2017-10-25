<template>
  <div class="card">
    <h1 class="text-center pt-3">{{tent.name}}</h1>
    <div class="card-body">
      <div class="d-flex flex-row justify-content-between align-items-center mb-3">
        <a class="btn btn-outline-secondary">
          Previous
        </a>
        <div class="dropdown">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
            {{weekOf}}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" v-for="(value, key) in weeks">Week: {{value}}</a>
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
    computed: {
      weekOf () {
        return 'Week Of: '+moment(this.selectedWeek).format('MMMM D, YYYY')
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
          this.selectedWeek = response.data[0][0].date
        })
    }
  }
</script>
