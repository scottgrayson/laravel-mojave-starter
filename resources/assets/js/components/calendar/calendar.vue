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
        // themeSystem: 'bootstrap3'

        events: (start, end, timezone, callback) => {
          callback(this.events)
        }
      })
    })

    // end mounted
  },

  methods: {

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
            title: 'Camp',
            allDay: true,
            start: e.date,
          }
        })
    },

    filteredAvailabilities () {
      return this.availabilities
        .filter(e => {
          return e.tent_id == (this.selectedTentId ? this.selectedTentId : 1)
        })

        .map(e => {
          if (this.selectedTentId) {
            return {
              title: e.tent_limit - e.campers + ' Openings',
              allDay: true,
              start: e.date,
            }
          } else {
            return {
              title: 'Camp',
              allDay: true,
              start: e.date,
            }
          }
        })
    }

    // end computed
  }

}
</script>
