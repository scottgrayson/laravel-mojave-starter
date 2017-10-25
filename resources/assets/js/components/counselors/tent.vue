<template>
  <div class="card">
    <h1 class="text-center pt-3">{{tent.name}}</h1>
    <div class="card-body">
      <div class="d-flex flex-row justify-content-between align-items-center mb-3">
        <a class="btn btn-outline-secondary"
          @click="fetchPrevious"
          :class="[campStart === weeks[selectedWeek][0].date ? 'disabled' : '']">
          Previous
        </a>
        <div class="dropdown">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
            {{weekOf}}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" v-for="(value, key) in weeks"
              @click="selectedWeek = key">
              {{weeks[key][0].date}}
            </a>
          </div>
        </div>
        <a class="btn btn-outline-secondary"
          @click="fetchNext"
          :class="[campEnd === weeks[selectedWeek][0].date ? 'disabled' : '']">
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
        selectedWeek: 0
      }
    },
    computed: {
      weekOf () {
        return 'Week Of: '+moment(this.weeks[this.selectedWeek][0].date).format('MMMM D, YYYY')
      }
    },
    methods: {
      fetchNext () {
        this.selectedWeek += 1
        this.getReservations(this.selectedWeek)
      },
      fetchPrevious () {
        this.selectedWeek -= 1
        this.getReservations(this.selectedWeek)
      },
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
          this.campStart = response.data.camp_start.date
          this.campEnd = response.data.camp_end.date
        })
    }
  }
</script>
