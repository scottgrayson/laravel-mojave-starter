<template>
  <div class="card">
    <h1 class="text-center pt-3">{{tent.name}}</h1>
    <div class="card-body">
      <div class="d-flex flex-row justify-content-between align-items-center mb-3">
        <a class="btn btn-outline-secondary"
          :class="[campStart === selectedWeek ? 'disabled' : '']">
          Previous
        </a>
        <div class="dropdown">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
            {{weekOf}}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" v-for="(value, key) in weeks"
              @click="selectedWeek = value[0].date">
              Week: {{value[0].date}}</a>
          </div>
        </div>
        <a class="btn btn-outline-secondary"
          :class="[campEnd === selectedWeek ? 'disabled' : '']">
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
        campStart: '',
        campEnd: '',
        selectedWeek: ''
      }
    },
    computed: {
      weekOf () {
        return 'Week Of: '+moment(this.selectedWeek).format('MMMM D, YYYY')
      }
    },
    methods: {
      getReservations (week) {
        axios.get('/api/reservations/week/'+week)
          .then((response) => {
            this.campers = response.data
          })
      }
    },
    created () {
      axios.get('/api/tents/'+this.tent.id)
        .then((response) => {
          this.campers = response.data
        })
      axios.get('/api/camp-dates/')
        .then((response) => {
          this.weeks = response.data.weeks
          this.selectedWeek = response.data.weeks[0][0].date
          this.campStart = response.data.camp_start.date
          this.campEnd = response.data.camp_end.date
        })
    }
  }
</script>
