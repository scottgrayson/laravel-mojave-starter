<template>
  <div class="row">
    <div v-if="campers.length" class="col-lg-6 offset-col-6">
      <label class="col-sm" for="tent-select">Select a camper to make reservations.</label>
      <select @change="handleCamperUpdate" :value="camper" class="col-sm form-control">
        <option :value="0">No Camper Selected</option>
        <option v-for="c in campers" :value="c.id">{{ c.first_name }} {{ c.last_name }}</option>
      </select>
    </div>

    <br>

    <div class="col-lg-6">
      <label class="col-sm" for="tent-select">Openings for:</label>
      <select placeholder="Select Tent" @change="handleTentUpdate" :value="tent" class="form-control" id="tent-select">
        <option :value="0">No Tent Selected</option>
        <option v-for="t in tents" :value="t.id">{{ t.name }}</option>
      </select>
    </div>
  </div>

</div>
</template>

<script>
import axios from 'axios';
import fullCalendar from 'fullcalendar';
import tentCamperSelect from './tent-camper-select';

export default {
  components: { tentCamperSelect },

  props: {
    camper: {
      default: 0,
    },
    tent: {
      default: 0,
    },
    tents: {
      type: Array,
      required: true
    },
    campers: {
      type: Array,
      default: []
    }
  },

  methods: {
    handleTentUpdate(e) {
      const tentId = parseInt(e.target.value)
      this.$emit('update', {
        tent: tentId,
        camper: 0
      })
    },

    handleCamperUpdate(e) {
      const camperId = parseInt(e.target.value)
      const camper = this.campers.find(c => {
        return c.id == camperId
      })
      this.$emit('update', {
        tent: camper ? camper.tent_id : 0,
        camper: camperId
      })
    }
  }

}
</script>
