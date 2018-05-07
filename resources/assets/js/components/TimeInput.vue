<template >
  <v-menu
    ref="menu"
    lazy
    :close-on-content-click="false"
    v-model="menu"
    transition="scale-transition"
    offset-y
    full-width
    :disabled="disabled"
    :nudge-right="40"
    max-width="290px"
    min-width="290px"
    :return-value.sync="time" >
    <v-text-field
      slot="activator"
      :label="`Enter ${placeholder}`"
      :placeholder="placeholder"
      v-model="time"
      :disabled="disabled"
      :value="time"
      :error-messages="errorMessages"
      prepend-icon="access_time"
      readonly >
    </v-text-field >
    <v-time-picker v-model="time"
                   @change="onChange"
                   format="24hr"
                   :allowed-hours="allowedTimes.hours"
                   :allowed-minutes="allowedTimes.minutes" >
    </v-time-picker >
  </v-menu >
</template >

<script >
export default {
  name: 'time-input',
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    errorMessages: {
      type: Array,
      default: function () {
        return []
      }
    },
    value: {},
    placeholder: {
      type: String,
      required: true
    },
    allowedTimes: {
      type: Object,
      default: function () {
        return {
          hours: function (value) {
            return true
          },
          minutes: function (value) {
            return true
          }
        }
      }
    }
  },
  data () {
    return {
      menu: false,
      time: null
    }
  },
  methods: {
    onChange (time) {
      this.$refs.menu.save(time)
      this.$emit('input', time)
    }
  }
}
</script >

<style scoped >

</style >