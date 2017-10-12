<template>
  <div>
    <input hidden :value="value" :name="name">

    <table class="table table-sm" v-if="meta && meta.length">
      <thead>
        <tr>
          <th>Key</th>
          <th>Value</th>
          <th class="text-right">Remove</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="m in meta" key="m.key">
          <td>
            {{ m.key }}
          </td>
          <td>
            {{ m.value }}
          </td>
          <td class="text-right">
            <button class="btn btn-icon" @click.prevent="remove(m)">
              X
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <form @submit.prevent="append" class="row">
      <div class="col-4">
        <input id="meta-key" type="text" placeholder="key" class="form-control" v-model="newKey"/>
      </div>
      <div class="col">
        <input type="text" placeholder="value" class="form-control" v-model="newValue"/>
      </div>
      <div class="col-2">
        <button class="btn btn-secondary">
          Add
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ['name', 'existing'],

  data () {
    return {
      meta: [],
      newKey: '',
      newValue: '',
    }
  },

  computed: {
    value () {
      return JSON.stringify(this.meta)
    }
  },

  created () {
    this.meta = JSON.parse(this.existing)
  },

  methods: {
    append () {
      this.meta = this.meta.concat([{
        key: this.newKey,
        value: this.newValue
      }])
      this.newValue = ''
      this.newKey = ''
      document.getElementById('meta-key').focus()
    },

    remove (m) {
      this.meta = this.meta.filter(i => i !== m)
    }
  }

}
</script>
