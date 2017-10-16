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

      } else if (!this.campers.length) {
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
        swal({
          title: 'Add to Cart?',
          text: `Reserve a spot for ${this.selectedCamper.name} in ${this.selectedTent.name} on ${moment(event.start).format('l')}?`,
          icon: 'warning',
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
              title: openings ? 'Reserve Now' : 'No Openings',
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
