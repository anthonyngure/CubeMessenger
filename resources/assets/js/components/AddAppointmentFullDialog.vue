<template>
    <v-dialog
            v-model="appointmentFullDialog"
            fullscreen
            transition="dialog-bottom-transition"
            :overlay="false"
            scrollable>
        <v-card tile>
            <v-toolbar card dark color="primary">
                <v-btn icon @click.native="$emit('onClose')" dark>
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>Add an Appointment/Meeting</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark flat @click.native="validate">Save</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>

                <v-layout row wrap style="width: 75%; margin: 0 auto">

                    <v-flex xs12>
                        <connection-manager ref="connectionManager"
                                            @onConnectionChange="onConnectionChange"
                                            @onSuccess="onConnectionManagerSuccess">
                        </connection-manager>
                    </v-flex>

                    <v-flex xs4>
                        <v-subheader class="mt-2">Appointment/Meeting venue type</v-subheader>
                    </v-flex>
                    <v-flex xs8>
                        <v-select
                                :items="venueTypes"
                                v-model="venueType"
                                :disabled="connecting"
                                clearable
                                item-text="text"
                                item-value="value"
                                label="Select venue type"
                                :error-messages="errors.venueType"
                                validate-on-blur
                                single-line>
                        </v-select>
                    </v-flex>

                    <v-flex xs12 class="mb-3">
                        <google-place-input
                                :disabled="connecting"
                                v-if="venueType === 2"
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
                                :error-messages="errors.venue"
                                types="establishment"
                                v-on:placechanged="onLocationEntered">
                        </google-place-input>

                        <v-text-field
                                v-if="venueType === 1"
                                :disabled="connecting"
                                required
                                label="Enter appointment/Meeting venue"
                                placeholder="Appointment/Meeting venue e.g Office, Boardroom or Room 10"
                                v-model="venue"
                                :error-messages="errors.venue"
                                prepend-icon="edit_location">
                        </v-text-field>

                    </v-flex>

                    <v-flex xs4>
                        <v-subheader class="mt-2">Appointment/Meeting with</v-subheader>
                    </v-flex>
                    <v-flex xs8>
                        <v-select
                                :items="$auth.user().client.users"
                                v-model="appointmentWith"
                                item-text="name"
                                item-value="id"
                                label="Select user"
                                deletable-chips
                                :disabled="connecting"
                                :error-messages="errors.appointmentWith"
                                clearable
                                chips>
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="data.parent.selectItem(data.item)"
                                        :selected="data.selected"
                                        class="chip--select-multi"
                                        :key="JSON.stringify(data.item)">
                                    <v-avatar>
                                        <img :src="`storage/${data.item.avatar}`">
                                    </v-avatar>
                                    {{ data.item.name }}
                                </v-chip>
                            </template>
                            <template slot="item" slot-scope="data">
                                <template>
                                    <v-list-tile-avatar>
                                        <img :src="`storage/${data.item.avatar}`">
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                                        <v-list-tile-title v-html="data.item.email"></v-list-tile-title>
                                    </v-list-tile-content>
                                </template>
                            </template>
                        </v-select>
                    </v-flex>

                    <v-flex xs12>
                        <v-text-field
                                label="Enter a title"
                                :disabled="connecting"
                                placeholder="Title e.g Website development progress meeting"
                                v-model="title"
                                :error-messages="errors.title"
                                required
                                prepend-icon="title">
                        </v-text-field>
                    </v-flex>

                    <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                        <date-input v-model="startDate"
                                    :disabled="connecting"
                                    placeholder="Starting date"
                                    :allowedDates="allowedDates"
                                    :error-messages="errors.startDate">
                        </date-input>
                    </v-flex>
                    <v-flex xs6 v-if="!allDay" class="pl-5">
                        <time-input v-model="startTime"
                                    :disabled="connecting"
                                    placeholder="Starting time"
                                    :allowedTimes="allowedTimes"
                                    :error-messages="errors.startTime">
                        </time-input>
                    </v-flex>
                    <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                        <date-input v-model="endDate"
                                    :disabled="connecting"
                                    placeholder="Ending date"
                                    :allowedDates="allowedDates"
                                    :error-messages="errors.endDate">
                        </date-input>
                    </v-flex>
                    <v-flex xs6 v-if="!allDay" class="pl-5">
                        <time-input v-model="endTime"
                                    :disabled="connecting"
                                    placeholder="Ending time"
                                    :allowedTimes="allowedTimes"
                                    :error-messages="errors.endTime">
                        </time-input>
                    </v-flex>

                    <v-flex xs10 offset-xs1>
                        <v-checkbox label="All day" hide-details :disabled="connecting" v-model="allDay"></v-checkbox>
                    </v-flex>


                    <v-flex xs12>

                        <v-subheader>Appointment participants</v-subheader>
                        <template v-for="(participant, index) in participants">
                            <v-layout row wrap :key="index">
                                <v-flex xs6>
                                    <v-text-field
                                            :disabled="connecting"
                                            placeholder="Participant email address"
                                            label="Enter participant email address"
                                            v-model="participant.email"
                                            :error-messages="participant.errors.email"
                                            prepend-icon="email">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs5 class="pl-5">
                                    <v-text-field
                                            :disabled="connecting"
                                            placeholder="Participant phone number"
                                            label="Enter participant phone number"
                                            :error-messages="participant.errors.phone"
                                            v-model="participant.phone"
                                            mask="##########"
                                            prepend-icon="phone">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs1>
                                    <v-btn icon :disabled="connecting" @click.native="removeParticipant(participant)">
                                        <v-icon>close</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>

                        <v-btn class="mb-3" flat color="primary" @click.native="addParticipant" :disabled="connecting">
                            <v-icon left dark>add</v-icon>
                            Add participant
                        </v-btn>

                        <v-text-field
                                name="note"
                                rows="2"
                                prepend-icon="note"
                                v-model="note"
                                :disabled="connecting"
                                label="Write a short note"
                                placeholder="Write a short note"
                                multi-line>
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <div style="flex: 1 1 auto;"/>
        </v-card>
    </v-dialog>
</template>

<script>

  import moment from 'moment'
  import GooglePlaceInput from './GooglePlaceInput'
  import TimeInput from './TimeInput'
  import DateInput from './DateInput'
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {
      ConnectionManager,
      DateInput,
      TimeInput,
      GooglePlaceInput
    },
    name: 'add-appointment-full-dialog',
    props: {
      appointmentFullDialog: {
        type: Boolean,
        default: false,
      },
      selectedCell: {}
    },
    data () {
      return {

        errors: {
          venueType: [],
          appointmentWith: [],
          startDate: [],
          startTime: [],
          endDate: [],
          endTime: [],
          title: [],
          venue: [],
          participants: [],
        },

        venueType: null,
        appointmentWith: null,

        startDate: null,
        startTime: null,

        endDate: null,
        endTime: null,

        title: null,
        venue: null,

        allDay: false,
        connecting: false,

        participants: [],
        note: null,

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

        rules: {
          required: (value) => !!value || 'Required.',
          contact: (value) => {
            return !!value && ('' + value).length === 10 || 'Contact contact must be 10 characters'
          },
        },

        addressData: null,
        placeResultData: null,

        allowedDates: {
          dates: function (date) {
            //YYYY/MM/DD
            let givenDate = moment(date, 'YYYY/MM/DD')
            return moment().diff(givenDate, 'days') <= 0
            //const [, , day] = date.split('-')
            //return parseInt(day, 10) % 2 === 0
          }
        },

        allowedTimes: {
          hours: function (value) {
            return value >= moment().hour() && value <= 22
          },
          minutes: function (value) {
            return value % 30 === 0
          }
        }
      }
    },
    watch: {
      startDate (startDate) {
        this.$utils.log(startDate)
      }
    },
    methods: {
      onConnectionManagerSuccess (response) {
        this.$emit('onClose', true)
      },
      onConnectionChange (connecting) {
        this.connecting = connecting
      },
      removeParticipant (participant) {
        this.participants.splice(this.participants.indexOf(participant), 1)
        this.participants = [...this.participants]
      },
      addParticipant () {
        this.participants.push({
          email: null,
          phone: null,
          errors: {
            email: [],
            phone: []
          }
        })
      },
      onLocationEntered (addressData, placeResultData) {
        this.addressData = addressData
        this.placeResultData = placeResultData
        this.venue = placeResultData.formatted_address
      },
      validate () {
        let pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

        let validParticipants = 0

        for (let participant of this.participants) {

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

          if (participant.email && pattern.test(participant.email)
            && participant.phone
            && ('' + participant.phone).length === 10) {
            validParticipants++
          }
        }

        this.errors.venueType = !this.venueType ? ['Please select Appointment/Meeting venue type'] : []
        this.errors.venue = !this.venue ? ['Please select Appointment/Meeting venue type'] : []
        this.errors.appointmentWith = !this.appointmentWith ? ['Please select Appointment/Meeting with'] : []
        this.errors.title = !this.title ? ['Please select Appointment/Meeting with'] : []
        this.errors.startDate = !this.startDate ? ['Please specify Appointment/Meeting starting date'] : []
        this.errors.startTime = !this.startTime && !this.allDay ? ['Please specify Appointment/Meeting starting time'] : []
        this.errors.endDate = !this.endDate ? ['Please specify Appointment/Meeting ending date'] : []
        this.errors.endTime = !this.endTime && !this.allDay ? ['Please specify Appointment/Meeting ending time'] : []

        if ((validParticipants === this.participants.length)
          && this.venueType
          && this.venue
          && this.appointmentWith
          && this.title
          && this.startDate
          && (this.startTime || this.allDay)
          && this.endDate
          && (this.endTime || this.allDay)) {


          let appointment = {
            venue: this.venue,
            with: this.appointmentWith,
            title: this.title,
            startDate: this.startDate,
            startTime: this.startTime,
            endDate: this.endDate,
            endTime: this.endTime,
            allDay: this.allDay,
            note: this.allDay,
            participants: []
          }

          for (let participant of this.participants) {
            appointment.participants.push({
              email: participant.email,
              phone: participant.phone,
            })
          }
          this.$utils.log(appointment)

          this.$refs.connectionManager.store('appointments', {
            venue: appointment.venue,
            with: appointment.with,
            title: appointment.title,
            startDate: appointment.startDate,
            startTime: appointment.startTime,
            endDate: appointment.endDate,
            endTime: appointment.endTime,
            allDay: appointment.allDay,
            participants: appointment.participants
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>