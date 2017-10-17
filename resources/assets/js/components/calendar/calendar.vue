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

    <br>

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
    availabilities: {
      type: Array,
      required: true
    },
    campDates: {
      type: Object,
      required: true
    }
  },

  data () {
    return {
      selectedTentId: 0,
      selectedCamperId: 0,
    }
  },

  mounted() {

    this.$nextTick(() => {
      $('#calendar').fullCalendar({
        weekends: false,
        header: {
          left: 'title',
          right: 'prev,next',
        },
        defaultDate: this.campDates.camp_start,
        eventTextColor: 'white',
        eventBorderColor: 'white',
        // themeSystem: 'bootstrap3'

        events: (start, end, timezone, callback) => callback(this.events),
        eventClick: this.handleEventClick
      })
    })

    // end mounted
  },

  methods: {

    handleEventClick(event) {
      if (!event.openings) {
        // no click events for non reservable
        return

      } else {
        this.addToCart(event.start)
      }
    },

    addToCart(date) {
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

      } else if (!this.selectedCamperId) {
        swal({
          title: 'Cannot Reserve',
          text: 'Select a camper before reserving.',
          icon: 'error',
        })
      } else {

        var title = 'Reserve Full Camp Session?'
        var text =  `${this.selectedCamper.name} in ${this.selectedTent.name}`

        if (date != 'full') {
          title = 'Reserve Day?'
          text =  `${this.selectedCamper.name} in ${this.selectedTent.name} on ${moment(date).format('l')}`
        }

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
                date: date
              })
                .then(() => {
                  swal({
                    icon: 'success',
                    text: 'Item added to cart.'
                  })
                })
                .catch(() => {
                  swal({
                    icon: 'error',
                    text: 'Item was not added to cart.'
                  })
                })
            }
          })
      }
    },

    handleTentCamperUpdate({ tent, camper }) {
      this.selectedTentId = tent
      this.selectedCamperId = camper
      this.refetchEvents()
    },

    refetchEvents() {
      $('#calendar').fullCalendar('refetchEvents')
    },

    // end methods
  },

  computed: {

    events () {
      return this.filteredAvailabilities.concat(this.filteredReservations)
    },

    filteredReservations () {
      return this.reservations
        .filter(e => {
          return e.tent_id == this.selectedTentId || !this.selectedTentId
        })
        .map(e => {
          return {
            title: e.title,
            allDay: true,
            start: e.date,
            className: 'badge badge-success'
          }
        })
    },

    filteredAvailabilities () {
      return this.availabilities
        .filter(e => {
          const reserved = this.filteredReservations.find(r => r.start == e.date)
          return !reserved && (e.tent_id == (this.selectedTentId ? this.selectedTentId : 1))
        })
        .map(e => {
          if (this.selectedTentId) {
            const openings = (e.tent_limit - e.campers) > 0
            const className = 'badge ' + (openings ? 'pointer badge-primary' : 'badge-secondary')

            return {
              title: openings ? 'Reserve Day' : 'No Openings',
              allDay: true,
              start: e.date,
              className: className,
              openings: openings
            }
          } else {
            return {
              title: 'Camp',
              allDay: true,
              start: e.date,
              className: 'badge badge-secondary'
            }
          }
        })
    },

    fullCampAvailable () {
      return this.filteredAvailabilities.every(i => i.openings);
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
