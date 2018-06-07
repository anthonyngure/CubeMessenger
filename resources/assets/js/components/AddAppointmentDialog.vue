<template>
    <v-dialog v-model="dialog" :max-width="maxWidth" persistent lazy>
        <v-stepper v-model="step" vertical>
            <v-stepper-step step="1" :complete="step > 1">Venue</v-stepper-step>
            <v-stepper-content step="1">
                <v-card flat>
                    <v-card-text>
                        <v-select
                                :items="venueTypes"
                                v-model="venueType"
                                :disabled="connecting"
                                clearable
                                item-text="text"
                                item-value="value"
                                label="Select appointment/meeting venue type venue type"
                                validate-on-blur
                                single-line>
                        </v-select>
                        <google-place-input
                                :disabled="connecting"
                                v-show="venueType === 2"
                                id="destination"
                                country="KE"
                                :clearable="false"
                                :enable-geolocation="true"
                                label="Enter location"
                                placeholder="Location"
                                prepend-icon="edit_location"
                                :required="true"
                                :rules="[rules.required]"
                                :load-google-api="false"
                                :google-api-key="$utils.googleMapsKey"
                                ref="locationInput"
                                :hint="!placeResultData ? '' : placeResultData.formatted_address"
                                persistent-hint
                                :hide-details="false"
                                types="establishment"
                                v-on:placechanged="onLocationEntered">
                        </google-place-input>
                        <v-text-field
                                v-show="venueType === 1"
                                :disabled="connecting"
                                required
                                label="Enter appointment/Meeting venue"
                                placeholder="Appointment/Meeting venue e.g Office, Boardroom or Room 10"
                                v-model="venue"
                                prepend-icon="edit_location">
                        </v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red" @click.native="onCancel" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="!venue" @click.native="step = 2">Continue</v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
            <v-stepper-step step="2" :complete="step > 2">Internal Participants</v-stepper-step>
            <v-stepper-content step="2">
                <v-card flat>
                    <v-select
                            :items="users"
                            v-model="internalParticipants"
                            label="Select internal participants"
                            deletable-chips
                            :disabled="connecting"
                            clearable
                            item-text="name"
                            multiple
                            required
                            :rules="[() => internalParticipants.length > 0 || 'You must choose at least one']"
                            persistent-hint
                            chips
                            tags
                            :search-input.sync="search"
                            :loading="loadingUsers">
                        <template slot="selection" slot-scope="data">
                            <v-chip close
                                    @input="data.parent.selectItem(data.item)"
                                    :selected="data.selected"
                                    class="chip--select-multi"
                                    :key="JSON.stringify(data.item)">
                                <v-avatar>
                                    <img :src="$utils.imageUrl(data.item.avatar)">
                                </v-avatar>
                                {{ data.item.name }}
                            </v-chip>
                        </template>
                    </v-select>
                    <v-card-actions>
                        <v-btn flat @click.native="step = 1">
                            <v-icon left>arrow_back</v-icon>
                            Back
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="!internalParticipants.length"
                               @click.native="step = 3">
                            Continue
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
            <v-stepper-step step="3" :complete="step > 3">External Participants</v-stepper-step>
            <v-stepper-content step="3">
                <v-card flat>
                    <template v-for="(participant, index) in externalParticipants">
                        <v-layout row wrap :key="index">
                            <v-flex xs3>
                                <v-text-field
                                        :disabled="connecting"
                                        placeholder="Participant name"
                                        label="Enter participant name"
                                        v-model="participant.name"
                                        :error-messages="participant.errors.name"
                                        prepend-icon="email">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs5 class="px-5">
                                <v-text-field
                                        :disabled="connecting"
                                        placeholder="Participant email address"
                                        label="Enter participant email address"
                                        v-model="participant.email"
                                        :error-messages="participant.errors.email"
                                        prepend-icon="email">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field
                                        :disabled="connecting"
                                        placeholder="Participant phone number"
                                        label="Enter participant phone number"
                                        v-model="participant.phone"
                                        :error-messages="participant.errors.phone"
                                        mask="##########"
                                        prepend-icon="phone">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs1>
                                <v-btn icon :disabled="connecting"
                                       @click.native="removeExternalParticipant(participant)">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </template>

                    <v-btn block flat color="primary" @click.native="addExternalParticipant"
                           :disabled="connecting">
                        <v-icon left dark>add</v-icon>
                        Add participant
                    </v-btn>
                    <v-card-actions>
                        <v-btn flat @click.native="step = 2">
                            <v-icon left>arrow_back</v-icon>
                            Back
                        </v-btn>
                        <v-spacer/>
                        <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="!externalParticipantsValidate"
                               @click.native="step = 4">
                            Continue
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
            <v-stepper-step step="4" :complete="step > 4">Title/Topic</v-stepper-step>
            <v-stepper-content step="4">
                <v-card flat>
                    <v-text-field
                            label="Enter meeting title/subject"
                            :disabled="connecting"
                            placeholder="Title/Subject e.g Website development progress meeting"
                            v-model="title"
                            required
                            prepend-icon="title">
                    </v-text-field>
                    <v-card-actions>
                        <v-btn flat @click.native="step = 3">
                            <v-icon left>arrow_back</v-icon>
                            Back
                        </v-btn>
                        <v-spacer/>
                        <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="!title || connecting"
                               @click.native="step = 5">Continue
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
            <v-stepper-step step="5">Issues/Items/Agenda</v-stepper-step>
            <v-stepper-content step="5">
                <v-card flat>
                    <template v-for="(itemToDiscuss, index) in itemsToDiscuss">
                        <v-layout row wrap>
                            <v-flex xs11>
                                <v-text-field
                                        :disabled="connecting"
                                        placeholder="An item to discuss"
                                        label="Enter item to discuss"
                                        v-model="itemToDiscuss.text"
                                        :error-messages="itemToDiscuss.error"
                                        prepend-icon="note">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs1>
                                <v-btn icon :disabled="connecting"
                                       @click.native="removeItemToDiscuss(itemToDiscuss)">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </template>
                    <v-btn block flat color="primary" @click.native="addItemToDiscuss"
                           :disabled="connecting">
                        <v-icon left dark>add</v-icon>
                        Add item to discuss
                    </v-btn>

                    <v-card-actions>
                        <v-btn flat @click.native="step = 4">
                            <v-icon left>arrow_back</v-icon>
                            Back
                        </v-btn>
                        <v-spacer/>
                        <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="connecting || !itemsToDiscussValidate"
                               @click.native="step = 6">Continue
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
            <v-stepper-step step="6">Meeting Time</v-stepper-step>
            <v-stepper-content step="6">
                <v-card flat>
                    <v-layout row wrap>
                        <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                            <date-input v-model="startDate"
                                        :disabled="connecting"
                                        placeholder="Starting date"
                                        :error-messages="startDateErrors"
                                        :allowedDates="allowedStartDates">
                            </date-input>
                        </v-flex>
                        <v-flex xs6 v-show="!allDay" class="pl-5">
                            <time-input v-model="startTime"
                                        :disabled="connecting"
                                        placeholder="Starting time"
                                        :allowedTimes="allowedStartTimes">
                            </time-input>
                        </v-flex>
                        <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                            <date-input v-model="endDate"
                                        :disabled="connecting || !startDate"
                                        placeholder="Ending date"
                                        ref="endDate"
                                        :allowedDates="allowedEndDates">
                            </date-input>
                        </v-flex>
                        <v-flex xs6 v-if="!allDay" class="pl-5">
                            <time-input v-model="endTime"
                                        :disabled="connecting"
                                        ref="endTime"
                                        placeholder="Ending time"
                                        :allowedTimes="allowedEndTimes">
                            </time-input>
                        </v-flex>
                        <v-flex xs10 offset-xs1>
                            <v-checkbox label="All day" hide-details :disabled="connecting"
                                        v-model="allDay"/>
                        </v-flex>
                        <v-flex xs12>
                            <connection-manager ref="connectionManager" v-model="connecting"/>
                        </v-flex>
                    </v-layout>

                    <v-alert type="error" :value="invalidInternalParticipants.length > 0">
                        <v-list>
                            <v-list-tile v-for="participant in invalidInternalParticipants" :key="participant.id">
                                <v-list-tile-content>
                                    <v-list-tile-title>{{participant.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>has another appointment/meeting on the selected timing
                                    </v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-alert>

                    <v-card-actions>
                        <v-btn flat @click.native="step = 4">
                            <v-icon left>arrow_back</v-icon>
                            Back
                        </v-btn>
                        <v-spacer/>
                        <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                        <v-btn color="primary" :disabled="invalidInternalParticipants.length > 0"
                               @click.native="submit">Finish
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-stepper-content>
        </v-stepper>
    </v-dialog>
</template>

<script>

  import BaseDialog from './BaseDialog'
  import GooglePlaceInput from './GooglePlaceInput'
  import ConnectionManager from './ConnectionManager'
  import DateInput from './DateInput'
  import TimeInput from './TimeInput'
  import moment from 'moment'
  import EventBus from '../event-bus'

  export default {
    extends: BaseDialog,
    components: {TimeInput, DateInput, ConnectionManager, GooglePlaceInput, BaseDialog},
    name: 'AddAppointmentDialog',
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    data () {
      return {
        dialog: false,
        connecting: false,
        step: 0,
        venueType: null,
        venueTypes: [
          {
            text: 'On site i.e In office, boardroom or a room',
            value: 1
          },
          {
            text: 'Off site i.e In a building or hotel',
            value: 2
          }
        ],
        venue: null,
        rules: {
          required: (value) => !!value || 'Required.',
          contact: (value) => {
            return !!value && ('' + value).length === 10 || 'Contact contact must be 10 characters'
          },
        },
        addressData: null,
        placeResultData: null,
        title: null,
        internalParticipants: [],
        invalidatingAppointments: [],
        search: null,
        loadingUsers: false,
        users: [],
        externalParticipants: [],
        itemsToDiscuss: [],
        allDay: false,
        startDate: null,
        //Hold an array of startDate Errors
        startDateErrors: [],
        startTime: null,
        endDate: null,
        endTime: null,
        allowedStartDates: {
          dates: function (date) {
            //YYYY/MM/DD
            let givenDate = moment(date)
            return moment().diff(givenDate, 'days') <= 0
            //const [, , day] = date.split('-')
            //return parseInt(day, 10) % 2 === 0
          }
        },
      }
    },
    watch: {
      show (val) {
        this.dialog = !!val
      },
      venueType (val) {
        this.venue = null
      },
      search (val) {
        val && this.queryUsers(val)
      },
      startDate (val) {
        this.$refs.endDate.onChange(null)
      },
      startTime (val) {
        this.$refs.endTime.onChange(null)
      },
      invalidatingAppointments (val) {
        this.$utils.log(val)
      }
    },
    computed: {
      allowedStartTimes () {
        let that = this
        return {
          hours: function (value) {
            //that.$utils.log(that.startDate)
            //that.$utils.log((that.startDate && moment().isSame(moment(that.startDate, 'YYYY-MM-DD'), 'day')))
            return (that.startDate && moment().isSame(moment(that.startDate, 'YYYY-MM-DD')))
              ? (value >= moment().hour() && value <= 22)
              : true
          },
          minutes: function (value) {
            return true
          }
        }
      },
      allowedEndDates () {
        let that = this
        return {
          dates: function (date) {
            //YYYY/MM/DD
            return moment(moment(date)).isSameOrAfter(moment(that.startDate, 'YYYY-MM-DD'))
            //const [, , day] = date.split('-')
            //return parseInt(day, 10) % 2 === 0
          }
        }
      },
      allowedEndTimes () {
        let that = this
        return {
          hours: function (value) {
            //return value > moment(that.startTime, 'HH:mm:ss').hour() && value <= 22
            return (that.endDate && moment().isSame(moment(that.endDate, 'YYYY-MM-DD')))
              ? (value >= moment().hour() && value <= 22)
              : true
          },
          minutes: function (value) {
            return value > moment(that.startTime, 'HH:mm:ss').minute()
          }
        }
      },
      invalidInternalParticipants () {
        if (this.startDate && (this.startTime || this.allDay) && this.endDate && (this.endTime || this.allDay)) {
          //Find invalid selected internal participants based on dates
          let that = this
          this.invalidatingAppointments = []
          return this.internalParticipants.filter(function (participant) {
            //Check if participant has a meeting in the selected duration
            //Find all appointments with a startingAt and endingAt within the selection
            let appointments = participant.appointments.filter(function (appointment) {

              that.$utils.log(appointment)

              let startDateIsInThisAppointment = moment(that.startDate, 'YYYY-MM-DD').isBetween(
                moment(appointment.startingAt, 'YYYY-MM-DD'),
                moment(appointment.endingAt, 'YYYY-MM-DD'),
                null,
                '[]'
              )

              let endDateIsInThisAppointment = moment(that.endDate, 'YYYY-MM-DD').isBetween(
                moment(appointment.startingAt, 'YYYY-MM-DD'),
                moment(appointment.endingAt, 'YYYY-MM-DD'),
                null,
                '[]'
              )

              if (that.allDay) {

                //Check selected startDate and endDate are within
                return startDateIsInThisAppointment || endDateIsInThisAppointment

              } else if (startDateIsInThisAppointment || endDateIsInThisAppointment) {

                //If selected startDate or endDate are within this appointment
                //Check if selected times are within

                let appointmentStartingAtHour = moment(appointment.startingAt).hour()
                that.$utils.log('appointmentStartingAtHour = ' + appointmentStartingAtHour)
                let appointmentStartingAtMin = moment(appointment.startingAt).minute()
                that.$utils.log('appointmentStartingAtMin = ' + appointmentStartingAtMin)

                let appointmentEndingAtHour = moment(appointment.endingAt).hour()
                that.$utils.log('appointmentEndingAtHour = ' + appointmentEndingAtHour)
                let appointmentEndingAtMin = moment(appointment.endingAt).minute()
                that.$utils.log('appointmentEndingAtMin = ' + appointmentEndingAtMin)

                let selectedStartingAtHour = moment(that.startTime, 'HH:mm:ss').hour()
                that.$utils.log('selectedStartingAtHour = ' + selectedStartingAtHour)
                let selectedStartingAtMin = moment(that.startTime, 'HH:mm:ss').minute()
                that.$utils.log('selectedStartingAtMin = ' + selectedStartingAtMin)

                let selectedEndingAtHour = moment(that.endTime, 'HH:mm:ss').hour()
                that.$utils.log('selectedEndingAtHour = ' + selectedEndingAtHour)
                let selectedEndingAtMin = moment(that.endTime, 'HH:mm:ss').minute()
                that.$utils.log('selectedEndingAtMin = ' + selectedEndingAtMin)

                let startTimeIsInThisAppointment = moment().hour(selectedStartingAtHour).minute(selectedStartingAtMin)
                  .isBetween(
                    moment().hour(appointmentStartingAtHour).minute(appointmentStartingAtMin),
                    moment().hour(appointmentEndingAtHour).minute(appointmentEndingAtMin),
                    null,
                    '[]'
                  )
                let endTimeIsInThisAppointment = moment().hour(selectedEndingAtHour).minute(selectedEndingAtMin)
                  .isBetween(
                    moment().hour(appointmentStartingAtHour).minute(appointmentStartingAtMin),
                    moment().hour(appointmentEndingAtHour).minute(appointmentEndingAtMin),
                    null,
                    '[]'
                  )

                return startTimeIsInThisAppointment || endTimeIsInThisAppointment

              } else {
                return false
              }
            })

            that.invalidatingAppointments = that.invalidatingAppointments.concat({
              participant: participant,
              appointments: appointments
            })
            //The participant is invalid if has an appointment on the selected startDate
            return appointments.length > 0
          })
        } else {
          return []
        }
      },
      maxWidth () {
        return (this.$vuetify.breakpoint.width * 0.60) + 'px'
      },
      externalParticipantsValidate () {
        let pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

        let validParticipants = 0

        for (let participant of this.externalParticipants) {

          if (participant.name) {
            participant.errors.name = []
          } else {
            participant.errors.name = ['Enter a valid name']
          }

          if (participant.email && pattern.test(participant.email)) {
            participant.errors.email = []
          } else {
            participant.errors.email = ['Enter a valid email address']
          }

          if (participant.phone && ('' + participant.phone).length === 10) {
            participant.errors.phone = []
          } else {
            participant.errors.phone = ['Enter a valid phone number']
          }

          if (participant.email && pattern.test(participant.email) && ('' + participant.phone).length === 10) {
            validParticipants++
          }
        }

        return validParticipants === this.externalParticipants.length
      },
      itemsToDiscussValidate () {

        let validItems = 0

        for (let itemToDiscuss of this.itemsToDiscuss) {
          if (!itemToDiscuss.text) {
            itemToDiscuss.error = ['This field can not be empty']
          } else {
            itemToDiscuss.error = []
            validItems++
          }
        }

        return validItems === this.itemsToDiscuss.length
      }
    },
    methods: {
      queryUsers (val) {
        this.loadingUsers = true
        this.axios.get('appointments/userSuggestions', {
          params: {
            search: val,
          }
        }).then(response => {
          this.users = []
          this.users = this.users.concat(response.data.data)
          this.loadingUsers = false
        })
          .catch(error => {
            this.loadingUsers = false
            this.$utils.log(error)
          })
      },
      onCancel (successful) {
        this.venueType = null
        this.venue = null
        this.step = 1
        this.title = null
        this.startDate = null
        this.startTime = null
        this.endDate = null
        this.endTime = null
        this.allDay = false
        this.internalParticipants = []
        this.externalParticipants = []
        this.itemsToDiscuss = []
        this.$emit('onClose', successful)
      },
      onLocationEntered (addressData, placeResultData) {
        this.addressData = addressData
        this.placeResultData = placeResultData
        this.venue = placeResultData.formatted_address
      },
      removeExternalParticipant (participant) {
        this.externalParticipants.splice(this.externalParticipants.indexOf(participant), 1)
        this.externalParticipants = [...this.externalParticipants]
      },
      addExternalParticipant () {
        this.externalParticipants.push({
          email: null,
          phone: null,
          name: null,
          errors: {
            email: [],
            phone: [],
            name: [],
          }
        })
      },
      removeItemToDiscuss (itemToDiscuss) {
        this.itemsToDiscuss.splice(this.itemsToDiscuss.indexOf(itemToDiscuss), 1)
        this.itemsToDiscuss = [...this.itemsToDiscuss]
      },
      addItemToDiscuss () {
        this.itemsToDiscuss.push({
          error: [],
          text: null
        })
      },
      submit () {
        let appointment = {
          venue: this.venue,
          title: this.title,
          startDate: this.startDate,
          startTime: this.startTime,
          endDate: this.endDate,
          endTime: this.endTime,
          allDay: this.allDay,
          internalParticipants: [],
          externalParticipants: [],
          itemsToDiscuss: [],
        }

        for (let itemToDiscuss of this.itemsToDiscuss) {
          appointment.itemsToDiscuss.push(itemToDiscuss.text)
        }

        for (let participant of this.internalParticipants) {
          appointment.internalParticipants.push(participant.id)
        }

        for (let participant of this.externalParticipants) {
          appointment.externalParticipants.push({
            email: participant.email,
            phone: participant.phone,
            name: participant.name,
          })
        }
        this.$utils.log(appointment)
        let that = this
        this.$refs.connectionManager.post('appointments', {
          onSuccess (response) {
            that.onCancel(true)
            EventBus.$emit(that.$actions.addedAppointment)
          }
        }, appointment)
      }
    },
    mounted () {
      var offset = new Date().getTimezoneOffset()
      let appointmentStartingAt = moment('2018-04-20 14:00:00')
      let selectedStartingAt = moment('14:00', 'HH:mm')
      this.$utils.log('appointmentStartingAt Hour ' + appointmentStartingAt.hour())
      this.$utils.log('selectedStartingAt Hour ' + selectedStartingAt.hour())
    }
  }
</script>

<style scoped>

</style>