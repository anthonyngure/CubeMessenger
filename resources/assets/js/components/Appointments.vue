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
                            <td v-for="day in daysOfWeek" :key="day.date" @click="onCellClicked(day)">
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
            <add-appointment-dialog :day="selectedDay"
                                    @onClose="selectedDay = null">
            </add-appointment-dialog>
        </v-flex>

    </v-layout>
</template>

<script>

  import FullCalendar from 'vue-fullcalendar/src/fullCalendar'
  import moment from 'moment'
  import AddAppointmentDialog from './AddAppointmentDialog'

  export default {
    components: {
      AddAppointmentDialog,
      FullCalendar
    },
    name: 'appointments',
    data () {
      return {
        date: '2018-03-02',
        selectedDay: null,
        daysOfWeek: [],
        hoursOfDay: [],
        appointments: []
      }
    },
    methods: {
      changeMonth (start, end, current) {
        console.log('changeMonth', start.format(), end.format(), current.format())
      },
      eventClick (event, jsEvent, pos) {
        console.log('eventClick', event, jsEvent, pos)
      },
      dayClick (day, jsEvent) {
        console.log('dayClick', day, jsEvent)
      },
      moreClick (day, events, jsEvent) {
        console.log('moreCLick', day, events, jsEvent)
      },
      onCellClicked (day) {
        this.selectedDay = day
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
      for (let i = 0; i < 200; i++) {
        this.appointments.push({
          title: 'Sunny Out of Office',
          start: moment('YYYY-MM-DD'),
          end: moment('YYYY-MM-DD')
        })
      }
      for (let i = 0; i <= 5; i++) {
        let weekday = moment().add(i, 'days')
        this.daysOfWeek.push({
          name: this.weekdayName(weekday.weekday()), date: weekday.get('date')
        })
      }
      for (let h = 6; h <= 22; h++) {
        if (h < 10) {
          this.hoursOfDay.push('0' + h + ':00')
        } else {
          this.hoursOfDay.push(h + ':00')
        }
      }
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