<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-date-picker
                    v-model="date"
                    full-width
                    landscape
                    event-color="green"
                    :events="appointmentDates">
            </v-date-picker>
            <v-container fluid grid-list-md>
                <connection-manager ref="connectionManager"></connection-manager>
                <v-data-iterator content-tag="v-layout"
                                 row
                                 wrap
                                 :items="appointments"
                                 :rows-per-page-items="rowsPerPageItems"
                                 :pagination.sync="pagination">
                    <span slot="no-data" class="pa-5">
                            <p>No appointments or meetings found for {{date}}</p>
                        </span>
                    <v-flex slot="item"
                            slot-scope="props"
                            md8 offset-md2>
                        <v-card :style="'height: '+cardHeight">
                            <div :style="'max-height: '+cardHeight" class="scroll-y pa-3">
                                <h2>{{ props.item.title }}</h2>
                                <h5>{{ props.item.venue }}</h5>
                                <v-chip label small color="accent" text-color="white">
                                    <v-icon left>access_time</v-icon>
                                    {{props.item.allDay ? 'All day'
                                    : props.item.startingAt+' -'+props.item.endingAt}}
                                </v-chip>
                                <v-divider></v-divider>
                                <v-subheader>Internal Participants</v-subheader>
                                <v-list avatar>
                                    <v-list-tile v-for="participant in props.item.internalParticipants"
                                                 :key="participant.id">
                                        <v-list-tile-action>
                                            <v-icon color="primary">person</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{ participant.name }}</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ participant.email }}</v-list-tile-sub-title>
                                            <v-list-tile-sub-title>{{participant.phone}}</v-list-tile-sub-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                                <v-divider></v-divider>
                                <v-subheader>External Participants</v-subheader>
                                <v-list avatar>
                                    <v-list-tile v-for="participant in props.item.externalParticipants"
                                                 :key="participant.id">
                                        <v-list-tile-action>
                                            <v-icon color="primary">person</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{ participant.email }}</v-list-tile-title>
                                            <v-list-tile-sub-title>{{participant.phone}}</v-list-tile-sub-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                                <v-divider></v-divider>
                                <v-subheader>Issues/Items</v-subheader>
                                <template v-for="(issue, index) in props.item.items">
                                    <p :key="issue.id">{{issue.details}}</p>
                                    <v-divider v-if="index !== props.item.items.length - 1"
                                               :key="'div_'+issue.id"></v-divider>
                                </template>
                            </div>
                        </v-card>
                    </v-flex>
                </v-data-iterator>
            </v-container>
        </v-flex>

        <add-appointment-dialog :show="addingAppointment"
                                @onClose="onCloseDialog">
        </add-appointment-dialog>

        <v-fab-transition>
          <v-btn style="margin-bottom: 100px"
                 color="accent"
                 fab
                 dark
                 fixed
                 bottom
                 @click.native="addingAppointment = true"
                 right >
            <v-icon >add</v-icon >
          </v-btn >
        </v-fab-transition>

    </v-layout>
</template>

<script >

import Moment from 'moment'
import Base from './Base.vue'

import {extendMoment} from 'moment-range'
import ConnectionManager from './ConnectionManager'
import AddAppointmentDialog from './AddAppointmentDialog'

const moment = extendMoment(Moment)

  export default {
    extends: Base,
    components: {
      AddAppointmentDialog,
      ConnectionManager
    },
    name: 'appointments',
    data () {
      return {
        date: null,
        rowsPerPageItems: [1],
        pagination: {
          rowsPerPage: 1
        },
        addingAppointment: false,
        appointments: [],
        appointmentDates: [],
      }
    },
    watch: {
      date (val) {
        this.refresh()
      }
    },
    methods: {
      refresh () {
        this.appointments = []
        let that = this
        this.$refs.connectionManager.get('appointments', {
          onSuccess (response) {
            that.appointments = []
            for (let appointment of response.data.data) {
              appointment.active = false
              that.appointmentDates.push(appointment.startingAt)
              that.appointments.push(appointment)
            }
          }
        }, {
          date: this.date
        })
      },
      onCloseDialog (addedAppointmentSuccessfully) {
        this.addingAppointment = false
        this.$utils.log('addedAppointmentSuccessfully: ' + addedAppointmentSuccessfully)
        if (addedAppointmentSuccessfully) {
          this.refresh()
        }
      }
    },
    computed: {
      cardHeight () {
        return (this.$vuetify.breakpoint.height * 0.75) + 'px'
      }
    },
    mounted () {
      this.date = moment().format('YYYY-MM-DD')
      this.refresh()
    }
  }
</script>

<style scoped>

</style>