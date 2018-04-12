<template>
    <v-dialog persistent v-model="dialog" max-width="600px">
        <v-stepper v-model="step">
            <v-stepper-header>
                <v-stepper-step step="1" :complete="step > 1">Option</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="step > 2">Days</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3">Quantity</v-stepper-step>
            </v-stepper-header>
            <v-stepper-items>
                <connection-manager ref="connectionManager" v-model="connecting"></connection-manager>
                <v-stepper-content step="1">
                    <v-select v-model="optionId"
                              :items="options"
                              hide-details
                              class="mb-1"
                              item-text="name"
                              item-value="id"
                              label="Select a subscription option"
                              placeholder="Subscription option">
                    </v-select>
                    <v-slide-y-transition>
                        <v-card flat tile v-if="option">
                            <v-list :style="'max-height: '+($vuetify.breakpoint.height * 0.30)+'px;'" class="scroll-y">
                                <template v-for="(optionItem, index) in option.items">
                                    <v-list-tile @click="selectedOptionItem = optionItem" :key="index">
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{optionItem.name}}</v-list-tile-title>
                                            <v-list-tile-sub-title>{{$utils.formatMoney(optionItem.price)}}
                                            </v-list-tile-sub-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-divider v-if="index < option.items.length"
                                               :key="option.items.length + index"></v-divider>
                                </template>
                            </v-list>
                            <v-chip class="mt-3" label outline color="info" small>
                                <v-icon left>info</v-icon>
                                Select {{option.name}} to subscribe to from the above list
                            </v-chip>
                        </v-card>
                    </v-slide-y-transition>
                    <v-card>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn flat @click.native="onClose(false)" color="red">Cancel</v-btn>
                            <v-btn color="primary" v-if="selectedOptionItem" @click.native="step = 2">
                                Subscribe for {{selectedOptionItem.name}}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-slide-y-transition>
                        <v-card v-if="weekdays.length && step === 2">
                            <v-list dense :style="'max-height: '+($vuetify.breakpoint.height * 0.45)+'px;'"
                                    class="scroll-y">
                                <v-list-tile v-for="item in weekdays" :key="item.id">
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ item.name }}</v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-checkbox v-model="item.selected"></v-checkbox>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                            <v-chip class="mt-3 caption" label outline color="info" small>
                                <v-icon left>info</v-icon>
                                Select on which days we should deliver your subscription from the above list
                            </v-chip>
                            <v-card-actions>
                                <v-btn flat @click.native="step = 1">
                                    <v-icon left>arrow_back</v-icon>
                                    Back
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" flat v-if="selectedOptionItem" @click="step = 1">
                                    <v-icon left>check_circle</v-icon>
                                    {{selectedOptionItem.name}} @ {{$utils.formatMoney(selectedOptionItem.price)}}
                                </v-btn>
                                <v-btn flat @click.native="onClose(false)" color="red">Cancel</v-btn>
                                <v-btn color="primary" :disabled="selectedWeekdays <= 0"
                                       @click.native="step = 3">
                                    Continue
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-slide-y-transition>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-card flat tile>
                        <v-layout row wrap align-center justify-center>
                            <v-flex xs12>
                                <p class="caption accent text--white px-5" v-if="showSubscriptionPeriodGuide">
                                    {{renewEveryMonthHint}}
                                </p>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field
                                        v-model="quantity"
                                        required
                                        mask="###"
                                        label="Enter quantity"
                                        :disabled="connecting"
                                        :hide-details="renewEveryMonth"
                                        placeholder="Quantity to be delivered">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs7 class="pl-5">
                                <v-checkbox label="Renew every month"
                                            :disabled="connecting"
                                            v-model="renewEveryMonth"
                                            hide-details>
                                </v-checkbox>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field
                                        v-if="!renewEveryMonth"
                                        v-model="terminationDate"
                                        :required="!renewEveryMonth"
                                        :disabled="connecting"
                                        hide-details
                                        @focus="showSelectTerminationDateDialog = true"
                                        label="Select date to terminate this subscription"
                                        placeholder="Date to terminate this subscription">
                                </v-text-field>
                            </v-flex>
                        </v-layout>


                        <v-dialog v-model="showSelectTerminationDateDialog" max-width="290px" lazy>
                            <v-card tile flat>
                                <v-date-picker v-model="terminationDate" :allowed-dates="allowedDates"></v-date-picker>
                            </v-card>
                        </v-dialog>

                        <v-list dense :style="'max-height: '+($vuetify.breakpoint.height * 0.30)+'px;'"
                                class="scroll-y" v-if="terminationDate || renewEveryMonth">
                            <v-list-tile v-for="item in weekdays" :key="item.id" v-if="item.selected">
                                <v-list-tile-content>
                                    <v-list-tile-sub-title>
                                        {{ item.days+' '+item.name+''+((item.days > 1) ? 's' : '') }}
                                        <b>
                                            {{renewEveryMonth ? ' this month ' : ' between now and '+terminationDate}}
                                        </b>
                                    </v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>

                        <v-slide-y-transition>
                            <div v-if="terminationDate || renewEveryMonth">
                                <v-btn color="primary" small flat outline>
                                    Total Item Cost : <b> {{$utils.formatMoney(costs.item)}}</b>
                                </v-btn>
                                <v-btn color="primary" small flat outline>
                                    Total Delivery Cost : <b> {{$utils.formatMoney(costs.delivery)}}</b>
                                </v-btn>
                                <v-chip class="mt-3 caption" label outline color="info" small>
                                    <v-icon left>info</v-icon>
                                    {{costsDescription}}
                                </v-chip>
                            </div>
                        </v-slide-y-transition>

                        <v-card-actions>
                            <v-btn flat @click.native="step = 2">
                                <v-icon left>arrow_back</v-icon>
                                Back
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" flat v-if="selectedOptionItem" @click="step = 1">
                                <v-icon left>check_circle</v-icon>
                                {{selectedOptionItem.name}} @ {{$utils.formatMoney(selectedOptionItem.price)}}
                            </v-btn>
                            <v-btn flat @click.native="onClose(false)" color="red">Cancel</v-btn>
                            <v-btn color="primary"
                                   :disabled="!quantity || connecting || (!terminationDate && !renewEveryMonth)"
                                   @click.native="submit">
                                Continue
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>

            </v-stepper-items>
        </v-stepper>

    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import moment from 'moment'
  import EventBus from '../event-bus'

  export default {
    name: 'AddSubscriptionDialog',
    components: {ConnectionManager},
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    data () {
      return {
        showSubscriptionPeriodGuide: false,
        connecting: false,
        showSelectTerminationDateDialog: false,
        dialog: false,
        step: 1,
        options: [],
        option: null,
        optionId: null,
        selectedOptionItem: null,
        weekdays: [],
        quantity: null,
        terminationDate: null,
        renewEveryMonth: true,
        daysToDeliver: 0,
      }
    },
    watch: {
      show (val) {
        this.dialog = !!val
        if (val && this.options.length === 0) {
          let that = this
          setTimeout(function () {
            that.loadSubscriptionOptions()
          }, 300)
        }
      },
      optionId (val) {
        if (val) {

          this.option = this.options.find(function (element) {
            return element.id === val
          })
          this.selectedOptionItem = null
        }

      },
      showSubscriptionPeriodGuide (val) {
        if (val) {
          let that = this
          setTimeout(function () {
            that.showSubscriptionPeriodGuide = false
          }, 5000)
        }
      },
      step (val) {
        if (val === 3) {
          this.updateDays()
          this.showSubscriptionPeriodGuide = true
        }
      },
      renewEveryMonth (val) {
        this.showSubscriptionPeriodGuide = true
        this.updateDays()
      },
      terminationDate (val) {
        if (val) {
          this.showSelectTerminationDateDialog = false
          this.renewEveryMonth = false
          this.showSubscriptionPeriodGuide = true
          this.updateDays()
        }
      },
    },
    computed: {
      renewEveryMonthHint () {
        return this.renewEveryMonth ? 'Un check "Renew every month" to specify a date to terminate this subscription' :
          'Check "Renew every month" to renew this subscription every month'
      },
      costsDescription () {
        return 'Above are costs '
          + (this.renewEveryMonth ? ' for this month' : ' between now and ' + this.terminationDate)
          + ' (' + this.daysToDeliver + ' days)'
      },
      selectedWeekdays () {
        let selected = 0
        for (let schedule of this.weekdays) {
          if (schedule.selected) {
            selected++
          }
        }
        return selected
      },
      costs () {

        if (this.step === 3) {
          this.daysToDeliver = 0

          for (let weekday of this.weekdays) {
            if (weekday.selected) {
              this.daysToDeliver += weekday.days
            }
          }

          return {
            item: (this.selectedOptionItem.price * this.quantity) * this.daysToDeliver,
            delivery: this.option.deliveryCost * this.quantity * this.daysToDeliver
          }
        } else {
          return {
            item: 0,
            delivery: 0
          }
        }
      }
    },
    methods: {
      onClose (val) {
        this.step = 1
        this.optionId = null
        this.option = null
        this.selectedOptionItem = null
        this.terminationDate = null
        this.renewEveryMonth = true
        this.quantity = null
        this.options = []
        for (let i = 0; i < this.weekdays.length; i++) {
          this.weekdays[i].selected = false
        }
        this.$emit('onClose', val)
      },
      allowedDates (date) {
        //YYYY/MM/DD
        let givenDate = moment(date)
        return moment().diff(givenDate, 'days') <= 0
        //const [, , day] = date.split('-')
        //return parseInt(day, 10) % 2 === 0
      },

      resetDays () {
        //Initialize days of weekdays in the subscribed period
        for (let i = 0; i < this.weekdays.length; i++) {
          this.weekdays[i].days = 0
        }
      },

      updateDays () {

        this.resetDays()

        if (this.renewEveryMonth) {

          //Date today
          let currentDayOfThisMonth = moment(this.systemVariables.date).date()
          this.$utils.log('currentDayOfThisMonth = ' + currentDayOfThisMonth)

          //Date of the last day of this month
          let lastDayOfThisMonth = moment(this.systemVariables.date).endOf('month').date()
          this.$utils.log('lastDayOfThisMonth = ' + lastDayOfThisMonth)

          //Add one to #currentDayOfThisMonth so as not to include today
          for (let i = (currentDayOfThisMonth + 1); i <= lastDayOfThisMonth; i++) {
            //Weekday number of the date
            let weekdayNumber = moment().date(i).weekday()
            //Updates number of days of the weekday number in the current month
            this.updateWeekdayDays(weekdayNumber)
          }
        } else if (this.terminationDate) {
          //Calculate days to deliver until the termination date

          let terminationDayOfYear = moment(this.terminationDate).dayOfYear()
          let currentDayOfYear = moment().dayOfYear()

          //Add one to #currentDayOfYear so as not to include today
          for (let i = (currentDayOfYear + 1); i <= terminationDayOfYear; i++) {
            //Weekday number of the day of year
            let weekdayNumber = moment().dayOfYear(i).weekday()
            //Updates number of days of the weekday number in the current month
            this.updateWeekdayDays(weekdayNumber)
          }
        }
      },

      updateWeekdayDays (weekdayNumber) {
        //Check if weekday number is selected, if selected update days of that weekday in the subscription period
        for (let i = 0; i < this.weekdays.length; i++) {
          let weekday = this.weekdays[i]
          if (weekday.number === weekdayNumber && weekday.selected) {
            this.weekdays[i].days++
            break
          }
        }
      },
      submit () {
        let selectedWeekdayNumbers = []
        for (let weekday of this.weekdays) {
          if (weekday.selected) {
            selectedWeekdayNumbers.push(weekday.number)
          }
        }
        let subscription = {
          renewEveryMonth: this.renewEveryMonth,
          terminationDate: this.terminationDate,
          weekdays: selectedWeekdayNumbers.join('#'),
          quantity: this.quantity,
          deliveryCost: this.costs.delivery,
          itemCost: this.costs.item,
          optionItemId: this.selectedOptionItem.id,
          optionId: this.optionId,
        }

        let that = this

        this.$refs.connectionManager.post('subscriptions', {
          onSuccess (response) {
            EventBus.$emit(that.$actions.addedSubscription)
            that.onClose(true)
          }
        }, subscription)
      },
      loadSubscriptionOptions () {
        let that = this
        this.$refs.connectionManager.get('subscriptionOptions', {
          onSuccess (response) {
            that.options = []
            that.options = that.options.concat(response.data.data)
            that.systemVariables = response.data.systemVariables
            that.weekdays = []
            that.weekdays.push({name: 'Monday', number: 1, days: 0})
            that.weekdays.push({name: 'Tuesday', number: 2, days: 0})
            that.weekdays.push({name: 'Wednesday', number: 3, days: 0})
            that.weekdays.push({name: 'Thursday', number: 4, days: 0})
            that.weekdays.push({name: 'Friday', number: 5, days: 0})
            that.weekdays.push({name: 'Saturday', number: 6, days: 0})
            that.weekdays.push({name: 'Sunday', number: 0, days: 0})
          }
        }, {withSystemVariables: true})
      },
    },
  }
</script>

<style scoped>

</style>