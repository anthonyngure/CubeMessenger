<template >
  <v-select
    :id="'#'+header.id"
    :key="'#'+header.id"
    :items="items"
    :hint="editing ? header.edit_hint : header.create_hint"
    v-model="itemId"
    :label="header.text"
    :required="required"
    :rules="required ? [rules.required] : []"
    :disabled="disabled"
    item-text="name"
    item-value="id"
    single-line
    autocomplete
    cache-items
    persistent-hint
    :search-input.sync="query"
    :loading="searching" >
  </v-select >
</template >

<script >
import Base from './Base.vue'

export default {
  name: 'CrudRemoteSelect',
  extends: Base,
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    editing: {
      type: Boolean,
      default: true
    },
    required: {
      type: Boolean,
      default: true
    },
    header: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      itemId: null,
      query: null,
      searching: false,
      items: []
    }
  },
  watch: {
    query (val) {
      if (val) {
        this.search(val)
      }
    },
    itemId (val) {
      this.$utils.log(val)
      this.$emit('input', val)
    }
  },
  methods: {
    search (val) {
      this.$utils.log('Searching... ' + val)
      this.searching = true
      this.axios.get(this.header.options, {
        params: {
          search: val
        }
      }).then(response => {
          this.searching = false
          this.items = []
          this.items = this.items.concat(response.data.data)
        })
        .catch(error => {
          this.searching = false
          this.$utils.log(error)
        })
    }
  }
}
</script >

<style scoped >

</style >