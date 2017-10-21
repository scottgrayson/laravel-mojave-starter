<template>
  <div>
    <h1 class="h2">
      Camp Calendar
    </h1>

    <tent-camper-select
      :tent="query.tent"
      :camper="query.camper"
      :campers="campers"
      :tents="tents"
      @update="handleTentCamperUpdate"
      ></tent-camper-select>

    <br>

    <div v-if="daysReserved.length" class="alert alert-success text-center">
      {{ daysReserved.length }}/{{ openDays.length }} days reserved for {{ selectedCamper.name }}
    </div>

    <div v-show="!query.tent" class="text-center text-muted alert px-0">
      Select a tent{{ campers.length ? ' or camper' : '' }} to view openings
    </div>

    <div class="alert px-0" v-if="query.tent">
      <h4>
        Reserve By Day
      </h4>
      <div class="row align-items-center">
        <div class="col-md text-muted">
          <p>
            {{ availableDays.length }}/{{ openDays.length }} Days Available for {{ selectedTent.name }}
          </p>
          <p v-if="query.camper">
            {{ selectedDays.length }}/{{ availableDays.length }} Days Selected for {{ selectedCamper.name }}
          </p>
        </div>
        <div class="col-md text-right">
          <button @click="selectAll" class="btn btn-sm btn-secondary">
            All
          </button>
          <button @click="selectNone" class="btn btn-sm btn-secondary">
            None
          </button>
          <button @click="addToCart" class="btn btn-sm btn-secondary">
            Update Cart
          </button>
        </div>
      </div>
    </div>

    <div class="camp-calendar" id='calendar'></div>

  </div>
</template>

<script>
import Query from '../../utils/query'
import tentCamperSelect from './tent-camper-select'

export default {
  components: { tentCamperSelect },

  props: {
    tents: {
      type: Array,
      required: true
    },
    campers: {
      type: Array,
      default: []
    },
    reservations: {
      type: Array,
      required: true
    },
    openDays: {
      type: Array,
      required: true
    }
  },

  data () {
    return {
      query: new Query({
        tent: 0,
        camper: 0,
      }),
      selectedDays: [],
      availabilities: [],
      cartItems: [],
      calendarMounted: false,
    }
  },

  created () {
    if (location.search) {
      this.query.parse(location.search)

      if (this.query.camper) {
        const camper = this.campers.find(c => c.id == this.query.camper)
        if (camper) {
          this.query.tent = camper.tent_id
        } else {
          this.query.camper = 0
          this.query.tent = 0
        }
      } else if (this.query.tent) {
        const tent = this.tents.find(t => t.id == this.query.tent)
        this.query.tent = tent ? tent.id : 0
      }

      this.query.push()
    }

    this.fetchAvailabilities()
    this.fetchCart()
  },

  mounted () {

    this.$nextTick(() => {
      $('#calendar').fullCalendar({
        weekends: false,
        height: 'auto',
        header: {
          left: 'title',
          right: 'prev,next',
        },
        defaultDate: this.openDays.length ? this.openDays[0] : '',
        eventTextColor: 'white',
        eventBorderColor: 'white',
        //themeSystem: 'bootstrap3',
        events: (start, end, timezone, callback) => callback(this.events),
        eventClick: this.handleEventClick
      })

      this.calendarMounted = true;
    })

    // end mounted
  },

  watch: {
    events: function () {
      if (this.calendarMounted) {
        this.reloadCalendar()
      }
    },
  },

  methods: {

    selectAll () {
      this.selectedDays = this.events
        .filter(e => e.openings)
        .map(e => e.start)
    },

    selectNone () {
      this.selectedDays = []
    },

    getSelectedDaysFromCart () {
      this.selectedDays = this.cartItems
        .filter(i => i.camper_id == this.query.camper && i.date)
        .map(i => {
          return i.date
        })
    },

    canReserve () {
      if (!this.campers.length) {
        swal({
          title: 'Cannot Reserve',
          text: 'You must register a camper before reserving.',
          icon: 'error',
          buttons: ['Later', 'Register Camper'],
        })
          .then(wantsRedirect => {
            if (wantsRedirect) {
              window.location.href = '/campers/create'
            }
          })
        return false

      } else if (!this.query.camper) {
        swal({
          title: 'Cannot Reserve',
          text: 'Select a camper before reserving.',
          icon: 'error',
        })
        return false

      } else {
        return true
      }
    },

    handleEventClick(event) {
      if (!event.openings) {
        // no click events for non reservable
        return
      }

      // Toggle Selected Day
      const date = event.start.format('YYYY-MM-DD')
      const index = this.selectedDays.indexOf(date)
      if (index > -1) {
        this.selectedDays.splice(index, 1)
      } else {
        this.selectedDays.push(date)
      }
    },

    addToCart () {
      if (this.canReserve()) {
        const title = 'Reserve ' + this.selectedDays.length + ' Days?'
        const text =  `${this.selectedCamper.name} in ${this.selectedTent.name}`

        swal({
          title: title,
          text: text,
          icon: 'warning',
          buttons: ['Cancel', 'Add to Cart'],
        })
          .then(wantsToAdd => {
            if (wantsToAdd) {
              axios.post('api/cart-items', {
                camper_id: this.query.camper,
                tent_id: this.query.tent,
                dates: this.selectedDays,
              })
                .then(res => {
                  this.parseCartResponse(res)
                  bus.$emit('cart-updated', res.data.length)
                  swal({
                    icon: 'success',
                    title: 'Cart Updated.'
                  })
                })
                .catch((e) => {
                  console.log(e)
                  swal({
                    icon: 'error',
                    text: 'There was a problem updating your cart.'
                  })
                })
            }
          })
      }
    },

    parseCartResponse (res) {
      this.cartItems = res.data
      this.getSelectedDaysFromCart()
    },

    handleTentCamperUpdate({ tent, camper }) {
      this.query.tent = tent
      this.query.camper = camper
      this.query.push()
      this.getSelectedDaysFromCart()
    },

    reloadCalendar () {
      $('#calendar').fullCalendar('refetchEvents')
    },

    fetchAvailabilities () {
      axios.get('/api/availabilities')
        .then(res => {
          this.availabilities = res.data
        })
    },

    fetchCart () {
      axios.get('/api/cart-items')
        .then(this.parseCartResponse)
    },

    // end methods
  },

  computed: {

    events () {
      return this.openDays.map(date => {

        const reserved = this.reservations.find(r => {
          return r.date == date && r.camper_id == this.query.camper
        })
        if (reserved) {
          return {
            title: 'Reserved',
            reserved: true,
            start: date,
            className: 'badge badge-success'
          }
        }

        const filled = this.availabilities.find(r => {
          return r.date == date && r.tent_id == this.query.tent && r.tent_limit <= r.campers
        })
        if (filled) {
          return {
            start: date,
            title: 'No Openings',
            className: 'badge badge-light text-dark'
          }
        }

        const selected = this.selectedDays.indexOf(date) !== -1
        if (selected) {
          return {
            start: date,
            title: 'Selected',
            openings: true,
            selected: true,
            className: 'badge badge-primary pointer'
          }
        }

        const available = this.availabilities.find(r => {
          return r.date == date && r.tent_id == this.query.tent
        })
        if (available) {
          return {
            start: date,
            title: 'Available',
            openings: true,
            className: 'badge badge-secondary pointer'
          }
        }

        return {
          title: 'Camp',
          className: 'badge badge-secondary',
          start: date
        }
      })
    },

    daysReserved () {
      return this.events.filter(e => e.reserved)
    },

    availableDays () {
      return this.events.filter(e => e.openings)
    },

    selectedCamper () {
      return this.campers.find(c => c.id == this.query.camper)
    },

    selectedTent () {
      return this.tents.find(t => t.id == this.query.tent)
    }

    // end computed
  }

}
</script>
