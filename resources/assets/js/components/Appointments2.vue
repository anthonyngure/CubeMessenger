<template>
    <v-layout row wrap>
        <v-flex xs12>

            <connection-manager ref="connectionManager"
                                @onSuccess="onConnectionManagerSuccess">
            </connection-manager>

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
                                :style="{'background-color': cellColor(hour, day)}"
                                @click="onCellClicked({hourOfDay: hour, dayOfWeek:day})">
                                {{rowCells[hour + '_' + day.date]}}
                                <!--<br/>
                                {{rowCells.length > 0 ? rowCells[day].text : ''}}-->
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
        date: '2018-03-02',
        appointmentFullDialog: false,
        selectedCell: null,
        daysOfWeek: [],
        hoursOfDay: [],
        appointments: [],
        rowCells: []
      }
    },
    methods: {
      onCloseDialog (addedAppointmentSuccessfully) {
        this.appointmentFullDialog = false
        this.$utils.log('addedAppointmentSuccessfully: ' + addedAppointmentSuccessfully)
        if (addedAppointmentSuccessfully) {
          this.$refs.connectionManager.index('appointments')
        }
      },
      cellColor (hour, day) {
        let key = hour + '_' + day.date
        if (this.rowCells[key]) {
          return this.rowCells[key].color
        } else {
          return 'white'
        }
      },
      onConnectionManagerSuccess (response) {
        this.appointments = []
        this.appointments = this.appointments.concat(response.data.data)

        for (let day of this.daysOfWeek) {

          for (let hour of this.hoursOfDay) {
            let key
            key = hour + '_' + day.date
            this.rowCells[key]['event'] = 'Event'
            let cellAppointmentAndColor = this.getCellAppointmentAndColor(day, hour)
            this.rowCells[key]['color'] = cellAppointmentAndColor.color
            this.rowCells[key]['appointment'] = cellAppointmentAndColor.appointment
            this.$utils.log(this.rowCells[key])
          }
        }

        //This will trigger a re render of the UI
        let tempDaysOfWeek = this.daysOfWeek
        this.daysOfWeek = []
        this.daysOfWeek = tempDaysOfWeek

      },
      getCellAppointmentAndColor (day, hour) {
        let ret = {
          color: 'white',
          appointment: null,
        }
        if (this.appointments.length === 0) {
          return ret
        }
        let that = this
        let appointment = this.appointments.find(function (a) {
          that.$utils.log(a.startDate + ' === ' + day.fullDate)
          return a.startDate === day.fullDate
        })

        ret.appointment = appointment

        if (appointment && appointment.allDay) {
          ret.color = 'red'
        } else if (appointment && !appointment.allDay) {

          let start = moment(appointment.startTime, 'HH:mm:ss')
          let end = moment(appointment.endTime, 'HH:mm:ss')
          let cellHour = moment(hour, 'HH:mm:ss')

          let range = moment.range(start, end)

          this.$utils.log(cellHour.within(range))

          if (range.contains(cellHour)) {
            return ret.color = 'yellow'
          } else {
            return ret.color = 'white'
          }
        } else {
          return ret.color = 'white'
        }

        return ret
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
        this.hoursOfDay.push(h)
      }


      for (let day of this.daysOfWeek) {

        for (let hour of this.hoursOfDay) {
          let key
          key = hour + '_' + day.date
          let cell = {
            day: day,
            hour: hour,
            key: key,
            event: null
          }
          this.rowCells[key] = cell

        }
      }

      this.$utils.log(this.rowCells)


      this.$refs.connectionManager.index('appointments')
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