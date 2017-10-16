<template>
  <div>
    <div v-if="campers.length" class="row align-items-center">
      <label class="col" for="tent-select">Select a camper To make reservations.</label>
      <select @change="handleCamperUpdate" class="col form-control">
        <option :value="0">No Camper Selected</option>
        <option v-for="c in campers" :value="c.id">{{ c.name }}</option>
      </select>
    </div>

    <br>

    <div class="row align-items-center">
      <label class="col" for="tent-select">Select a tent to view openings.</label>
      <select @change="handleTentUpdate" class="col form-control" id="tent-select">
        <option :value="0">No Tent Selected</option>
        <option v-for="t in tents" :value="t.id">{{ t.name }}</option>
      </select>
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
      const tentId = e.target.value
      this.$emit('update', {
        tent: tentId,
        camper: 0
      })
    },

    handleCamperUpdate(e) {
      const camperId = e.target.value
      const tent = this.tents.find(t => {
        return t.id == e.tent_id
      })
      this.$emit('update', {
        tent: tent.id,
        camper: camperId
      })
    }
  }

}
</script>
