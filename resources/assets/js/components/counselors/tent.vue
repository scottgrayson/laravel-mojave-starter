<template>
  <div class="card">
    <!--h1 class="text-center pt-3">{{tent.name}}</h1-->
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
          <th>Name</th>
          <th>
            Reservations
          </th>
        </tr>
        <tr v-for="(camper, key) in campers"
          scope="row">
          <td>
            <a :href="'/campers/'+camper.id">
              {{camper.name}}
            </a>
          </td>
          <td>
            {{camper.dates[0].date}}
          </td>
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
        camperSelection: {},
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
      parseCampers (week) {
        console.log(week)
        function parseDate (val) {
          return moment(val.date).format('YYYY-MM-DD')
        }
        let selection = Object()
        for (const camper of this.campers) {
          selection[camper.name] = {
            dates: {
              [week]: []
            }
          }
          let dates = camper.dates.map(parseDate)
          for (const x of this.weeks[week]) {
            if (dates.includes(x)) {
              selection[camper.name].dates[week].push(x)
            }
          }
        }
        this.camperSelection = selection
      },
      setWeek (val) {
        this.selectedWeek = val
        this.parseCampers(val)
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
        return 'Week Of: '+moment(this.weeks[val][0]).format('MMMM D, YYYY')
      },
      fetchNext () {
        this.selectedWeek += 1
        this.parseCampers(this.selectedWeek)
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
        this.parseCampers(this.selectedWeek)
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
          select.push(moment(val[x][0].date).format('YYYY-MM-DD') + 
            " - " + moment(val[x][val[x].length - 1].date).format('YYYY-MM-DD'))
        }
        return select
      },
      parseWeeks (val) {
        var select = {} 
        val.forEach(function (value, i) {
          select[i] = []
          value.forEach(function (x, y) {
            select[i].push(moment(x.date).format('YYYY-MM-DD'))
          })
        })
        return select
      },
      fetchCampDates () {
        axios.get('/api/camp-dates/')
          .then((response) => {
            this.weeks = this.parseWeeks(response.data.weeks) 
            this.weekSelection = this.weekSelect(response.data.weeks)
            this.campStart = response.data.camp_start.date
            this.campEnd = response.data.camp_end.date
            this.selectedReadableWeek = this.weekOf(this.selectedWeek)
            this.fetchReservations()
          })
      },
      fetchReservations () {
        axios.get('/api/reservations/'+this.tent.id)
          .then((response) => {
            this.campers = response.data
            this.$nextTick(() => {
              this.parseCampers(0)
            })
          })
      }
    },
    created () {
      this.fetchCampDates()
    }
  }
</script>
