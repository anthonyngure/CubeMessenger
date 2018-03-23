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

            <connection-manager ref="connectionManager">
            </connection-manager>

            <v-card>
                <v-card-text>
                    <v-data-iterator
                            content-tag="v-list"
                            :items="appointments"
                            :rows-per-page-items="rowsPerPageItems"
                            :pagination.sync="pagination">
                        <span slot="no-data">
                            <p>No appointments or meetings found for {{date}}</p>
                        </span>
                        <template slot="item" slot-scope="props">
                            <v-list-group no-action :key="props.item.id" v-model="props.item.active">
                                <v-list-tile slot="activator" avatar>
                                    <v-list-tile-action>
                                        <v-chip label small color="accent" text-color="white">
                                            <v-icon left>access_time</v-icon>
                                            {{props.item.allDay ? 'All day long'
                                            : props.item.startTime+' -'+props.item.endTime}}
                                        </v-chip>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ props.item.user.name }} -
                                            <span class="caption">{{ props.item.title }}</span>
                                        </v-list-tile-title>
                                        <v-list-tile-sub-title>{{ props.item.venue }} -
                                            <strong>
                                                {{ props.item.participants.length }} participants
                                            </strong>
                                        </v-list-tile-sub-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <v-list-tile v-for="participant in props.item.participants" :key="participant.id">
                                    <v-list-tile-action>
                                        <v-icon color="primary">person</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ participant.email }}</v-list-tile-title>
                                        <v-list-tile-sub-title>{{participant.phone}}</v-list-tile-sub-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-btn icon @click.native="">
                                            <v-icon color="red">close</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>

                            </v-list-group>
                            <v-divider :key="'div_'+props.item.id"></v-divider>
                        </template>

                    </v-data-iterator>
                </v-card-text>
            </v-card>

        </v-flex>

        <v-flex xs12>
            <add-appointment-full-dialog :appointmentFullDialog.sync="appointmentFullDialog"
                                         :selectedCell="selectedCell"
                                         @onClose="onCloseDialog">
            </add-appointment-full-dialog>
        </v-flex>

        <v-fab-transition>
            <v-btn class="ma-3" color="accent" fab dark fixed bottom
                   @click.native="appointmentFullDialog = true"
                   right>
                <v-icon>add</v-icon>
            </v-btn>
        </v-fab-transition>

    </v-layout>
</template>

<script>

  import FullCalendar from 'vue-fullcalendar/src/fullCalendar'
  import Moment from 'moment'
  import AddAppointmentFullDialog from './AddAppointmentFullDialog'

  import {extendMoment} from 'moment-range'
  import ConnectionManager from './ConnectionManager'

  const moment = extendMoment(Moment)

  export default {
    components: {
      ConnectionManager,
      AddAppointmentFullDialog,
      FullCalendar
    },
    name: 'appointments',
    data () {
      return {
        date: null,
        rowsPerPageItems: [5, 10, 15],
        pagination: {
          rowsPerPage: 5
        },
        appointmentFullDialog: false,
        selectedCell: null,
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
              that.appointmentDates.push(appointment.startDate)
              that.appointments.push(appointment)
            }
          }
        }, {
          date: this.date
        })
      },
      onCloseDialog (addedAppointmentSuccessfully) {
        this.appointmentFullDialog = false
        this.$utils.log('addedAppointmentSuccessfully: ' + addedAppointmentSuccessfully)
        if (addedAppointmentSuccessfully) {
          this.refresh()
        }
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