<template>
  <div>
    <div v-if="campers.length && user" class="row pt-3">
      <div class="col">
        <div v-for="camper in campers" class="card m-1">
          <div class="card-body">
            <p class="m-0">
              {{camper.first_name}}
            </p>
            <p class="m-0">
              - Days Available for {{tents.find(t => t.id == camper.tent_id).name}}
              <span class="badge badge-primary">{{ availableDays.length }}/{{ openDays.length }}</span>
            </p>
            <p class="m-0">
              - Days Reserved
              <span class="badge badge-success">{{ availableDays.length }}/{{ openDays.length }}</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <tent-camper-select
              :tent="query.tent"
              :camper="query.camper"
              :campers="campers"
              :tents="tents"
              @update="handleTentCamperUpdate"
              ></tent-camper-select>
            <div class="my-2">
              <div v-if="!daysAdded && selectedCamper" class="alert alert-secondary">
                Select Days For: {{selectedCamper.first_name}} 
              </div>
              <div v-if="daysAdded && !reservedDays" class="alert alert-success">
                Checkout To Reserve Your Days
              </div>
              <div v-if="daysAdded && reservedDays" class="alert alert-success">
                Checkout To Reserve Additional Days For: {{selectedCamper.first_name}}
              </div>
              <div v-if="!daysAdded && !selectedCamper" class="alert alert-info">
                Select Camper To Add Days
              </div>
            </div>
            <div class="d-flex align-items-around">
              <div class="btn-group m-1">
                <a class="btn btn-sm btn-link disabled">
                  Select
                </a>
                </small>
                <button @click="selectAll" class="btn btn-sm btn-outline-secondary" :disabled="user === false">
                  All
                </button>
                <button @click="selectNone" class="btn btn-sm btn-outline-secondary" :disabled="user === false">
                  None
                </button>
              </div>
              <button @click="addToCart" class="ml-auto btn btn-sm btn-success m-1" :disabled="user === false">
                Checkout
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!--/div-->
    <hr>
    <div class="row">
      <div class="col-lg mb-3">
        <div class="camp-calendar" id='calendar1'></div>
      </div>
      <div class="col-lg">
        <div class="camp-calendar" id='calendar2'></div>
      </div>
    </div>
    <br>
    <h4>Events</h4>
    <ul style="list-style:none">
      <li v-for="e in eventTypes">
        <span class="pr-2">{{ e.event_type.emoji }}</span>
        <a v-if="e.event_type && e.event_type.link" :href="e.event_type.link">
          <b>{{ e.event_type.name }}</b>
        </a>
        <b v-else>{{ e.event_type.name }}</b>
      </li>
    </ul>
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
      otherEvents: [],
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
    this.fetchOtherEvents()
    this.fetchCart()
  },

  mounted () {

    const calendar1Config = {
      weekends: false,
      height: 'auto',
      header: {
        left: 'title',
        right: false
      },
      fixedWeekCount: false,
      showNonCurrentDates: false,
      defaultDate: this.openDays.length ? this.openDays[0] : '',
      eventTextColor: 'white',
      eventBorderColor: 'white',
      //themeSystem: 'bootstrap3',
      events: (start, end, timezone, callback) => {
        callback(this.otherEvents.concat(this.events))
      },
      eventClick: this.handleEventClick
    }

    const nextMonth = !calendar1Config.defaultDate ? '' : moment(calendar1Config.defaultDate)
      .add('months', 1)
      .startOf('month')
      .format('YYYY-MM-DD')

    const calendar2Config = Object.assign({}, calendar1Config, {
      defaultDate: nextMonth
    })

    this.$nextTick(() => {
      $('#calendar1').fullCalendar(calendar1Config)
      $('#calendar2').fullCalendar(calendar2Config)

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
      if (!window.User) {
        swal({
          title: 'Cannot Reserve',
          text: 'You must login/register before you can reserve.',
          icon: 'error',
          buttons: ['Cancel', 'Login/Register'],
        })
          .then(wantsRedirect => {
            if (wantsRedirect) {
              window.location.href = '/login'
            }
          })
        return false
      }
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
        const text =  `${this.selectedCamper.first_name} in ${this.selectedTent.name}`

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
                    title: 'Cart Updated',
                    buttons: ['Close', 'View Cart']
                  })
                    .then(wantsRedirect => {
                      if (wantsRedirect) {
                        window.location.href = '/cart'
                      }
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
      $('#calendar1').fullCalendar('refetchEvents')
      $('#calendar2').fullCalendar('refetchEvents')
    },

    fetchAvailabilities () {
      axios.get('/api/availabilities')
        .then(res => {
          this.availabilities = res.data
        })
    },

    fetchOtherEvents () {
      axios.get('/api/events')
        .then(res => {
          this.otherEvents = res.data.map(event => {
            return Object.assign(event, {
              title: event.event_type.emoji,
              start: event.date,
              backgroundColor: 'transparent',
              className: 'cal-emoji'
            })
          })
        })
    },

    fetchCart () {
      axios.get('/api/cart-items')
        .then(this.parseCartResponse)
    },

    // end methods
  },

  computed: {

    daysAdded () {
      return this.selectedDays.length > 0
    },

    reservedDays () {
      return this.daysReserved.length > 0
    },

    user () {
      if (window.User) {
        return true
      }
      return false
    },

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
            className: 'cal-badge bg-success'
          }
        }

        const filled = this.availabilities.find(r => {
          return r.date == date && r.tent_id == this.query.tent && r.tent_limit <= r.campers
        })
        if (filled) {
          return {
            start: date,
            title: 'No Openings',
            className: 'cal-badge bg-light text-dark'
          }
        }

        const selected = this.selectedDays.indexOf(date) !== -1
        if (selected) {
          return {
            start: date,
            title: 'Selected',
            openings: true,
            selected: true,
            className: 'cal-badge bg-primary pointer'
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
            className: 'cal-badge bg-secondary pointer'
          }
        }

        return {
          title: 'Camp',
          className: 'cal-badge bg-secondary',
          start: date
        }
      })
    },

    eventTypes () {
      return this.otherEvents.reduce((acc, e) => {
        if (acc.find(el => e.event_type_id === el.event_type_id)) {
          return acc
        }
        return acc.concat(e)
      }, [])
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
