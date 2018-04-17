<template>
    <v-dialog v-model="dialog" :max-width="maxWidth" persistent>
        <v-stepper v-model="step" alt-labels>
            <v-stepper-header>
                <v-stepper-step step="1" :complete="step > 1">Venue</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="step > 2">Internal Participants</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3" :complete="step > 3">External Participants</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="4" :complete="step > 4">Meeting Details</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="5">Scheduling</v-stepper-step>
            </v-stepper-header>
            <connection-manager ref="connectionManager" v-model="connecting">
            </connection-manager>
            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-card flat>
                        <v-layout row wrap>
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
                                        validate-on-blur
                                        single-line>
                                </v-select>
                            </v-flex>
                            <v-flex xs12>
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
                                        prepend-icon="edit_location">
                                </v-text-field>

                            </v-flex>
                        </v-layout>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red" @click.native="onCancel" flat>Cancel</v-btn>
                            <v-btn color="primary" :disabled="!venue" @click.native="step = 2">Continue</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-card flat>
                        <v-subheader>Select meeting internal participants</v-subheader>
                        <v-select
                                :items="users"
                                v-model="internalParticipants"
                                label="Select internal participants"
                                deletable-chips
                                :disabled="connecting"
                                clearable
                                multiple
                                required
                                :rules="[() => internalParticipants.length > 0 || 'You must choose at least one']"
                                persistent-hint
                                chips
                                tags
                                :search-input.sync="search"
                                :loading="loadingUsers">
                        </v-select>
                        <v-card-actions>
                            <v-btn flat @click.native="step = 1">
                                <v-icon left>arrow_back</v-icon>
                                Back
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                            <v-btn color="primary" :disabled="!internalParticipants.length" @click.native="step = 3">
                                Continue
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-card flat>
                        <v-subheader>Add meeting external participants</v-subheader>
                        <template v-for="(participant, index) in externalParticipants">
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
                            <v-spacer></v-spacer>
                            <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                            <v-btn color="primary" :disabled="!externalParticipantsValidate" @click.native="step = 4">
                                Continue
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
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
                        <v-slide-y-transition>
                            <div v-if="title">
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
                            </div>
                        </v-slide-y-transition>
                        <v-card-actions>
                            <v-btn flat @click.native="step = 3">
                                <v-icon left>arrow_back</v-icon>
                                Back
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                            <v-btn color="primary" @click.native="step = 5">Continue</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="5">
                    <v-card flat>
                        <v-layout row wrap>
                            <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                                <date-input v-model="startDate"
                                            :disabled="connecting"
                                            placeholder="Starting date "
                                            :allowedDates="allowedDates">
                                </date-input>
                            </v-flex>
                            <v-flex xs6 v-if="!allDay" class="pl-5">
                                <time-input v-model="startTime"
                                            :disabled="connecting"
                                            placeholder="Starting time"
                                            :allowedTimes="allowedTimes">
                                </time-input>
                            </v-flex>
                            <v-flex v-bind="{[`xs${allDay ? 12 : 6}`]: true}">
                                <date-input v-model="endDate"
                                            :disabled="connecting"
                                            placeholder="Ending date"
                                            :allowedDates="allowedDates">
                                </date-input>
                            </v-flex>
                            <v-flex xs6 v-if="!allDay" class="pl-5">
                                <time-input v-model="endTime"
                                            :disabled="connecting"
                                            placeholder="Ending time"
                                            :allowedTimes="allowedTimes">
                                </time-input>
                            </v-flex>

                            <v-flex xs10 offset-xs1>
                                <v-checkbox label="All day" hide-details :disabled="connecting"
                                            v-model="allDay"></v-checkbox>
                            </v-flex>
                        </v-layout>
                        <v-card-actions>
                            <v-btn flat @click.native="step = 4">
                                <v-icon left>arrow_back</v-icon>
                                Back
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn @click.native="onCancel" color="red" flat>Cancel</v-btn>
                            <v-btn color="primary" @click.native="step = 1">Continue</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-dialog>
</template>

<script>

  import BaseDialog from './BaseDialog'
  import GooglePlaceInput from './GooglePlaceInput'
  import ConnectionManager from './ConnectionManager'
  import DateInput from './DateInput'
  import TimeInput from './TimeInput'

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
        search: null,
        loadingUsers: false,
        users: [],
        externalParticipants: [],
        itemsToDiscuss: [],
        allDay: false,
        startDate: null,
        startTime: null,
        endDate: null,
        endTime: null,
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
      show (val) {
        this.dialog = !!val
      },
      venueType (val) {
        this.venue = null
      },
      search (val) {
        val && this.queryUsers(val)
      }
    },
    computed: {
      maxWidth () {
        return (this.$vuetify.breakpoint.width * 0.65) + 'px'
      },
      externalParticipantsValidate () {
        let pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

        let validParticipants = 0

        for (let participant of this.externalParticipants) {

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
      }
    },
    methods: {
      queryUsers (val) {
        this.loadingUsers = true
        this.axios.get('userSuggestions', {
          params: {
            search: val,
          }
        }).then(response => {
          this.users = []
          for (let item of response.data.data) {
            this.users.push(item.name)
          }
          this.loadingUsers = false
        })
          .catch(error => {
            this.loadingUsers = false
            this.$utils.log(error)
          })
      },
      onCancel () {
        this.venueType = null
        this.venue = null
        this.step = 0
        this.$emit('onClose')
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
          errors: {
            email: [],
            phone: []
          }
        })
      },
      removeItemToDiscuss (itemToDiscuss) {
        this.itemsToDiscuss.splice(this.itemsToDiscuss.indexOf(itemToDiscuss), 1)
        this.itemsToDiscuss = [...this.itemsToDiscuss]
      },
      addItemToDiscuss () {
        this.itemsToDiscuss.push({
          error: null,
          text: null
        })
      }
    }
  }
</script>

<style scoped>

</style>