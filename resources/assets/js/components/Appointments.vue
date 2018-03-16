<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <v-card-text>
                    <table border="1|0">
                        <thead>
                        <tr>
                            <th>.</th>
                            <th v-for="day in daysOfWeek" :key="day.date">
                                <h5>{{day.name}}</h5>
                                <h1>{{day.date}}</h1>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="hour in hoursOfDay">
                            <td>{{hour}}</td>
                            <td v-for="day in daysOfWeek" :key="day.date"
                                @click="onCellClicked({hourOfDay: hour, dayOfWeek:day})"
                                :style="{'background-color': determineCelColor(day, hour)}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--<full-calendar
                            :events="appointments"
                            @changeMonth="changeMonth"
                            @eventClick="eventClick"
                            @dayClick="dayClick"
                            @moreClick="moreClick">
                        <template slot="fc-header-left">
                            <v-btn icon>
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                        </template>
                        <template slot="fc-event-card" slot-scope="p">
                            <p><i class="fa">sadfsd</i> {{ p.event.title }} test</p>
                        </template>
                    </full-calendar>-->
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
            <v-btn class="ma-3"
                   color="accent"
                   fab
                   dark
                   fixed
                   bottom
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

  const moment = extendMoment(Moment)

  export default {
    components: {
      AddAppointmentFullDialog,
      FullCalendar
    },
    name: 'appointments',
    data () {
      return {
        date: '2018-03-02',
        appointmentFullDialog: false,
        selectedCell: null,
        daysOfWeek: [],
        hoursOfDay: [],
        appointments: []
      }
    },
    methods: {
      onCloseDialog (addedAppointmentSuccessfully) {
        this.appointmentFullDialog = false
        if (addedAppointmentSuccessfully) {
          this.loadAppointments()
        }
      },
      loadAppointments () {
        this.axios.get('appointments')
          .then(response => {
            for (let item of response.data.data) {
              this.appointments.push(item)
            }
            //alert(this.appointments)
          }).catch(error => {
          this.$utils.log(error)
        })
      },
      determineCelColor (day, hour) {
        if (this.appointments.length === 0) {
          return 'white'
        }
        let that = this
        let appointment = this.appointments.find(function (a) {
          that.$utils.log(a.startDate + ' === ' + day.fullDate)
          return a.startDate === day.fullDate
        })

        this.$utils.log('+++++++++++++++++++++++++++++++++++++++++++')
        this.$utils.log((appointment && appointment.allDay))

        if (appointment && appointment.allDay) {
          return 'red'
        } else if (appointment && !appointment.allDay) {

          let start = moment(appointment.startTime, 'HH:mm:ss')
          let end = moment(appointment.endTime, 'HH:mm:ss')
          let cellHour = moment(hour, 'HH:mm:ss')

          let range = moment.range(start, end)

          this.$utils.log(cellHour.within(range))

          if (range.contains(cellHour)) {
            return 'yellow'
          } else {
            return 'white'
          }
        } else {
          return 'white'
        }
      },
      onCellClicked (cell) {
        this.selectedCell = cell
        this.appointmentFullDialog = true
      },
      weekdayName (i) {
        switch (i) {
          case 0:
            return 'Sun'
          case 1:
            return 'Mon'
          case 2:
            return 'Tue'
          case 3:
            return 'Wed'
          case 4:
            return 'Thu'
          case 5:
            return 'Fri'
          case 6:
            return 'Sat'
          default:
            return 'N/A'
        }
      }
    },
    mounted () {
      for (let i = 0; i <= 5; i++) {
        let weekday = moment().add(i, 'days')
        this.daysOfWeek.push({
          name: this.weekdayName(weekday.weekday()),
          date: weekday.get('date'),
          fullDate: weekday.format('YYYY-MM-DD'),
        })
      }
      for (let h = 6; h <= 22; h++) {
        if (h < 10) {
          this.hoursOfDay.push('0' + h + ':00:00')
        } else {
          this.hoursOfDay.push(h + ':00:00')
        }
      }

      this.loadAppointments()
    }
  }
</script>

<style scoped>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, th, td {
        border: 1px solid lightgray;
    }

    th {
        height: 40px;
        padding: 15px;
        text-align: left;
    }

    td {
        height: 30px;
        padding: 5px;
        text-align: left;
        vertical-align: center;
    }

    td:nth-child(1) {
        width: 75px;
        vertical-align: bottom;
    }

</style>