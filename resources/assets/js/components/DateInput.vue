<template>
    <v-menu
            ref="menu"
            lazy
            :close-on-content-click="false"
            v-model="menu"
            transition="scale-transition"
            offset-y
            full-width
            :no-title="noTitle"
            :disabled="disabled"
            :nudge-right="40"
            max-width="290px"
            min-width="290px"
            :return-value.sync="date">
        <v-text-field
                slot="activator"
                :label="`Enter ${placeholder}`"
                :placeholder="placeholder"
                v-model="date"
                prepend-icon="event"
                :error-messages="errorMessages"
                :value="date"
                :disabled="disabled"
                readonly
        ></v-text-field>
        <v-date-picker v-model="date" @change="onChange"
                       format="24hr"
                       :allowed-dates="allowedDates.dates">
        </v-date-picker>
    </v-menu>
</template>

<script>
  import moment from 'moment'

  export default {
    name: 'date-input',
    props: {
      disabled: {
        type: Boolean,
        default: false
      },
      noTitle: {
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
      allowedDates: {
        type: Object,
        default: function () {
          return {
            callback: function (date) {
              //YYYY/MM/DD
              let givenDate = moment(date, 'YYYY/MM/DD')
              return moment().diff(givenDate, 'days') <= 0
              //const [, , day] = date.split('-')
              //return parseInt(day, 10) % 2 === 0
            }
          }
        }
      },
    },
    data () {
      return {
        menu: false,
        date: null
      }
    },
    methods: {
      onChange (date) {
        this.$refs.menu.save(date)
        this.$emit('input', date)
      }
    }
  }
</script>

<style scoped>

</style>