<template>
  <div class="card">
    <h1 class="text-center pt-3">{{tent.name}}</h1>
    <div class="card-body">
      <div class="d-flex flex-row justify-content-between align-items-center mb-3">
        <a class="btn btn-outline-secondary"
          @click="fetchPrevious"
          :class="[firstWeek ? 'disabled' : '']">
          Previous
        </a>
        <div class="dropdown">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
            {{selectedReadableWeek}}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" v-for="(value, key) in weekSelection"
              @click="setWeek(key), selectedReadableWeek = weekOf(key)">
              {{value}}
            </a>
          </div>
        </div>
        <a class="btn btn-outline-secondary"
          :class="[lastWeek ? 'disabled' : '']"
          @click="fetchNext">
          Next
        </a>
      </div>
      <table class="table table-responsive">
        <tr>
          <th>#</th>
          <th>Allergies</th>
          <th>Name</th>
          <th>Monday</th>
          <th>Tuesday</th>
          <th>Wednesday</th>
          <th>Thursday</th>
          <th>Friday</th>
        </tr>
        <tr v-for="(camper, key) in campers"
          scope="row">
          <td>{{key + 1}}</td>
          <td v-if="camper.allergies !== null">
            <svg id="i-alert" viewBox="0 0 32 32" 
              width="32" 
              height="32" 
              fill="none"
              stroke="currentcolor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2">
              <path d="M16 3 L30 29 2 29 Z M16 11 L16 19 M16 23 L16 25" />
            </svg>
          </td>
          <td v-else>
            None
          </td>
          <td>
            <a :href="'/campers/'+camper.id">
              {{camper.name}}
            </a>
          </td>
          <td>X</td>
          <td>X</td>
          <td>X</td>
          <td>X</td>
          <td>X</td>
        </tr>
      </table>
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
        weekSelection: [],
        campers: {},
        campStart: '',
        campEnd: '',
        firstWeek: true,
        lastWeek: false,
        selectedWeek: 0,
        selectedReadableWeek: ''
      }
    },
    methods: {
      setWeek (val) {
        this.selectedWeek = val
        if (val === 0) {
          this.firstWeek = true
          this.lastWeek = false
        } else if (val === (this.weeks.length - 1)) {
          this.firstWeek = false
          this.lastWeek = true
        } else {
          this.firstWeek = false
          this.lastWeek = false
        }
      },
      weekOf (val) {
        return 'Week Of: '+moment(this.weeks[val][0].date).format('MMMM D, YYYY')
      },
      fetchNext () {
        this.selectedWeek += 1
        if (this.selectedWeek === (Object.keys(this.weeks).length - 1)) {
          this.lastWeek = true
        } else {
          this.firstWeek = false
          this.lastWeek = false
        }
        this.selectedReadableWeek = this.weekOf(this.selectedWeek)
      },
      fetchPrevious () {
        this.selectedWeek -= 1
        if (this.selectedWeek === 0) {
          this.firstWeek = true
        } else {
          this.firstWeek = false
          this.lastWeek = false
        }
        this.selectedReadableWeek = this.weekOf(this.selectedWeek)
      },
      weekSelect (val) {
        var select = []
        for (const x in val) {
          select.push(moment(val[x][0].date).format('YYYY-MM-DD') + " - " + moment(val[x][val[x].length - 1].date).format('YYYY-MM-DD'))
        }
        this.weekSelection = select
      }
    },
    created () {
      axios.get('/api/reservations/'+this.tent.id)
        .then((response) => {
          this.campers = response.data
        })
      axios.get('/api/camp-dates/')
        .then((response) => {
          this.weeks = response.data.weeks
          this.weekSelect(response.data.weeks)
          this.campStart = response.data.camp_start.date
          this.campEnd = response.data.camp_end.date
          this.selectedReadableWeek = this.weekOf(this.selectedWeek)
        })
    }
  }
</script>
