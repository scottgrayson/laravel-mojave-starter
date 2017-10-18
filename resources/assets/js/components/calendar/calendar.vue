<template>
  <div>
    <h1 class="h2">
      Camp Calendar
    </h1>

    <tent-camper-select
      :tent="selectedTentId"
      :camper="selectedCamperId"
      :campers="campers"
      :tents="tents"
      @update="handleTentCamperUpdate"
      ></tent-camper-select>

    <br>

    <div v-if="fullCampAvailable" class="alert alert-primary d-flex justify-content-around align-items-center">
      Full camp openings {{ selectedTent ? ' for ' + selectedTent.name : '' }}
      <button v-if="fullCampAvailable" class="btn btn-outline-primary" @click="addToCart('full')">
        Reserve Full Camp
      </button>
    </div>
    <div v-else-if="!fullCampAvailable && selectedTent" class="text-center alert alert-secondary">
      Full camp not available{{ selectedTent ? ' for ' + selectedTent.name : '' }}. Reserve by day below.
    </div>
    <div v-else class="text-center text-muted">
      Select a tent{{ campers.length ? ' or camper' : '' }} to view openings
    </div>

    <div class="alert" v-if="selectedCamperId">
      <h4>
        Reserve By Day
      </h4>
      <div class="row">
        <small class="col text-muted">
          {{ selectedDays.length }} Day{{ selectedDays.length == 1 ? '' : 's' }} Selected
        </small>
        <div class="btn-group btn-group-sm" role="group">
          <button class="btn btn-secondary">
            All
          </button>
          <button class="btn btn-secondary">
            None
          </button>
          <button class="btn btn-secondary">
            Update Cart
          </button>
        </div>
      </div>
    </div>

    <div id='calendar'></div>

  </div>
</template>

<script>
import axios from 'axios';
import fullCalendar from 'fullcalendar';
import tentCamperSelect from './tent-camper-select';

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
      selectedTentId: 0,
      selectedCamperId: 0,
      selectedDays: [],
      availabilities: [],
      cartItems: [],
    }
  },

  created () {
    this.fetchAvailabilities()
  },

  mounted () {

    this.$nextTick(() => {
      $('#calendar').fullCalendar({
        weekends: false,
        header: {
          left: 'title',
          right: 'prev,next',
        },
        defaultDate: this.openDays.length ? this.openDays[0] : '',
        eventTextColor: 'white',
        eventBorderColor: 'white',
        // themeSystem: 'bootstrap3'
        events: (start, end, timezone, callback) => callback(this.events()),
        eventClick: this.handleEventClick
      })
    })

    // end mounted
  },

  methods: {

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

      } else if (!this.selectedCamperId) {
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

      if (this.canReserve()) {
        // Toggle Selected Day
        const date = event.start.format('YYYY-MM-DD')
        const index = this.selectedDays.indexOf(date)
        if (index > -1) {
          this.selectedDays.splice(index, 1)
        } else {
          this.selectedDays.push(date)
        }

        this.reloadCalendar()
      }
    },

    addToCart () {

      const title = `Reserve ${this.selectedDays.length} Days?`
      const text =  `${this.selectedCamper.name} in ${this.selectedTent.name} on ${moment(date).format('l')}`

      swal({
        title: title,
        text: text,
        icon: 'warning',
        buttons: ['Cancel', 'Add to Cart'],
      })
        .then(wantsToAdd => {
          if (wantsToAdd) {
            axios.post('cart', {
              camper_id: this.selectedCamperId,
              tent_id: this.selectedTentId,
              dates: this.selectedDays,
            })
              .then(() => {
                swal({
                  icon: 'success',
                  title: 'Cart Updated.'
                })
              })
              .catch(() => {
                swal({
                  icon: 'error',
                  text: 'There was a problem updating your cart.'
                })
              })
          }
        })
    },

    handleTentCamperUpdate({ tent, camper }) {
      this.selectedTentId = tent
      this.selectedCamperId = camper
      this.reloadCalendar()
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

    events () {
      return this.openDays.map(date => {

        const reserved = this.reservations.find(r => {
          return r.date == date && r.camper_id == this.selectedCamperId
        })
        if (reserved) {
          return {
            title: 'Reserved',
            start: date,
            className: 'badge badge-success'
          }
        }

        const filled = this.availabilities.find(r => {
          return r.date == date && r.tent_id == this.selectedTentId && r.tent_limit <= r.campers
        })
        if (filled) {
          return {
            start: date,
            title: 'No Openings',
            className: 'badge badge-secondary'
          }
        }

        const selected = this.selectedDays.indexOf(date) !== -1
        if (selected) {
          return {
            start: date,
            title: 'Unselect Day',
            openings: true,
            selected: true,
            className: 'badge badge-warning text-dark pointer'
          }
        }

        const available = this.availabilities.find(r => {
          return r.date == date && r.tent_id == this.selectedTentId
        })
        if (available) {
          return {
            start: date,
            title: 'Reserve Day',
            openings: true,
            className: 'badge badge-primary pointer'
          }
        }

        return {
          title: 'Camp',
          className: 'badge badge-secondary',
          start: date
        }
      })
    },

    // end methods
  },

  computed: {


    fullCampAvailable () {
      return this.availabilities
        .filter(i => i.tent_id == this.selectedTentId)
        .every(i => i.tent_limit > i.campers);
    },

    selectedCamper () {
      return this.campers.find(c => c.id == this.selectedCamperId)
    },

    selectedTent () {
      return this.tents.find(t => t.id == this.selectedTentId)
    }
    // end computed
  }

}
</script>
