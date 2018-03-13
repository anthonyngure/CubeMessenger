<template>
    <v-dialog v-model="dialog" max-width="600px" width="600px">
        <v-card v-if="day">
            <v-toolbar color="primary" dense dark flat card>
                <v-toolbar-title>{{day.name}} - {{day.date}}</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <google-place-input
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
                <v-layout row wrap>
                    <v-flex xs6>
                        <v-menu
                                ref="startTimeMenu"
                                lazy
                                :close-on-content-click="false"
                                v-model="startTimeMenu"
                                transition="scale-transition"
                                offset-y
                                full-width
                                :nudge-right="40"
                                max-width="290px"
                                min-width="290px"
                                :return-value.sync="startTime">
                            <v-text-field
                                    slot="activator"
                                    label="Starting"
                                    v-model="startTime"
                                    prepend-icon="access_time"
                                    readonly>
                            </v-text-field>
                            <v-time-picker v-model="startTime" format="24hr"
                                           @change="$refs.startTimeMenu.save(startTime)"></v-time-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs6>
                        <v-menu
                                ref="endTimeMenu"
                                lazy
                                :close-on-content-click="false"
                                v-model="endTimeMenu"
                                transition="scale-transition"
                                offset-y
                                full-width
                                :nudge-right="40"
                                max-width="290px"
                                min-width="290px"
                                :return-value.sync="endTime">
                            <v-text-field
                                    slot="activator"
                                    label="Ending"
                                    v-model="endTime"
                                    prepend-icon="access_time"
                                    readonly>
                            </v-text-field>
                            <v-time-picker v-model="endTime" format="24hr"
                                           @change="$refs.endTimeMenu.save(endTime)"></v-time-picker>
                        </v-menu>
                    </v-flex>
                </v-layout>
                <v-subheader>Participants</v-subheader>
                <v-layout row wrap>
                    <v-flex xs7>
                        <v-text-field label="Enter participant email"
                                      placeholder="Participant email"
                                      v-model="participantEmail"
                                      required
                                      :rules="[rules.required]"
                                      prepend-icon="email">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs5>
                        <v-text-field label="Enter Participant contact"
                                      placeholder="Participant contact"
                                      v-model="participantContact"
                                      required
                                      :rules="[rules.required, rules.contact]"
                                      type="phone"
                                      mask="##########"
                                      :counter="10"
                                      prepend-icon="phone">
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" flat @click.stop="onClose">Cancel</v-btn>
                <v-btn color="primary" @click.stop="onClose">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import GooglePlaceInput from './GooglePlaceInput'

  export default {
    components: {GooglePlaceInput},
    name: 'add-appointment-dialog',
    props: {
      day: {
        required: true,
      }
    },
    data () {
      return {
        dialog: false,
        participantEmail: null,
        participantContact: null,
        endTimeMenu: false,
        startTimeMenu: false,
        startTime: null,
        endTime: null,
        rules: {
          required: (value) => !!value || 'Required.',
          contact: (value) => {
            return !!value && ('' + value).length === 10 || 'Contact contact must be 10 characters'
          },
        },
        addressData: null,
        placeResultData: null,
      }
    },
    watch: {
      day (day) {
        this.dialog = !!day
      }
    },
    methods: {
      onClose () {
        this.$emit('onClose')
      },
      onLocationEntered (addressData, placeResultData) {
        this.addressData = addressData
        this.placeResultData = placeResultData
      },
    }
  }
</script>

<style scoped>

</style>