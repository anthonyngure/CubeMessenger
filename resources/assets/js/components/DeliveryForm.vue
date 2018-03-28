<template>
    <v-card :style="'height: '+$vuetify.breakpoint.height+'px'">
        <v-toolbar card dark color="primary">
            <v-btn icon @click.native="onClose">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Add a delivery</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn flat @click.native="onClose">Close</v-btn>
            </v-toolbar-items>
            <v-menu bottom right offset-y>
                <v-btn slot="activator" dark icon>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list dense>
                    <v-list-tile @click="onClose">Close</v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
        <v-card-text class="pa-0 ma-0">
            <v-layout row wrap>
                <v-flex xs5
                        :style="'max-height: '+($vuetify.breakpoint.height  - 100)+'px; ' +
                         'height: '+($vuetify.breakpoint.height  - 100)+'px'"
                        class="scroll-y">
                    <v-card tile>
                        <v-card-text>
                            <!--Origin-->
                            <google-place-input
                                    id="origin"
                                    country="KE"
                                    :clearable="false"
                                    :disabled="(addingItem && items.length > 0) || addingSchedule || items.length > 0"
                                    :enable-geolocation="true"
                                    label="Enter pickup location"
                                    placeholder="Pickup location"
                                    prepend-icon="edit_location"
                                    :required="true"
                                    :load-google-api="false"
                                    :value="originInput"
                                    ref="originInput"
                                    types="establishment"
                                    :hint="originFormattedAddress"
                                    persistent-hint
                                    :hide-details="false"
                                    v-on:placechanged="onOriginEntered">

                            </google-place-input>
                            <!--Schedule-->
                            <v-slide-x-transition>
                                <v-card v-show="addingSchedule">
                                    <v-card-text>
                                        <date-input v-model="scheduleDate"
                                                    :disabled="connecting"
                                                    placeholder="Pick up date"
                                                    :allowedDates="allowedDates">
                                        </date-input>
                                        <time-input v-model="scheduleTime"
                                                    :disabled="connecting"
                                                    placeholder="Pick up time"
                                                    :allowedTimes="allowedTimes">
                                        </time-input>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="red" @click.native="addingSchedule = false">Cancel
                                        </v-btn>
                                        <v-btn small color="primary" :disabled="!scheduleDate || !scheduleTime"
                                               @click.native="addingSchedule = false">Finish
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-slide-x-transition>
                            <!--Add item form-->
                            <v-slide-x-transition>
                                <delivery-item-form
                                        v-show="addingItem"
                                        :courierOptions="courierOptions"
                                        :cancelable="items.length > 0"
                                        @onAddItem="onAddItem"
                                        @onClose="addingItem = false"
                                        ref="itemInputForm">
                                </delivery-item-form>
                            </v-slide-x-transition>
                            <!--items-->
                            <v-list three-line :style="'max-height: '+($vuetify.breakpoint.height*0.55)+'px; '"
                                    class="scroll-y">
                                <template v-for="(item,i) in items">
                                    <v-list-tile avatar @click="" :key="i">
                                        <v-list-tile-avatar>
                                            <img :src="'/storage/'+item.courierOption.icon">
                                        </v-list-tile-avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="body-2">
                                                <b>{{item.quantity}} -
                                                    {{(item.quantity === 1 ? item.courierOption.name:
                                                    item.courierOption.pluralName)}}</b>
                                                - {{item.distance/1000}}km
                                            </v-list-tile-title>
                                            <v-list-tile-sub-title class="primary--text caption">
                                                <b> To: </b>{{item.destinationName}} -
                                                {{item.destinationFormattedAddress}}
                                            </v-list-tile-sub-title>
                                        </v-list-tile-content>
                                        <v-list-tile-action>
                                            <v-menu bottom right offset-y>
                                                <v-btn slot="activator" light icon>
                                                    <v-icon>more_vert</v-icon>
                                                </v-btn>
                                                <v-list dense>
                                                    <v-list-tile @click="deleteItem(item)">Delete</v-list-tile>
                                                </v-list>
                                            </v-menu>
                                        </v-list-tile-action>
                                    </v-list-tile>
                                    <v-divider v-if="i !== items.length - 1" inset
                                               :key="i+items.length"></v-divider>
                                </template>
                            </v-list>
                            <!--Total cost estimate-->
                            <v-progress-linear v-if="calculatingDirections" :indeterminate="true" hide-details>
                            </v-progress-linear>
                            <v-tooltip bottom>
                                <v-btn block color="accent" outline small flat slot="activator"
                                       v-if="items.length">
                                    Total Cost Estimate: <b> {{totalEstimatedCostFormatted}}</b>
                                </v-btn>
                                <span>Estimated Max Distance: {{estimatedMaxDistance/1000}}km</span><br/>
                                <!--<span>Estimate Max Time: {{estimatedMaxDuration/60}}min</span><br/>-->
                                <span>Cost Per Kilometer: KES 30.00</span><br/>
                                <span>Cost Per Minute: KES 4.00</span><br/>
                                <span>Estimate Total Cost: {{totalEstimatedCostFormatted}}</span>
                            </v-tooltip>

                        </v-card-text>
                        <v-card-actions v-if="!addingItem && !addingSchedule">
                            <v-btn color="primary" block flat outline small
                                   :disabled="!originPosition"
                                   @click.native="addingItem = true">
                                + Add Item
                            </v-btn>
                            <v-btn color="primary" block flat outline small
                                   :disabled="!items.length"
                                   @click.native="addingSchedule = true">
                                <v-icon class="mr-1">schedule</v-icon>
                                Schedule
                            </v-btn>
                            <v-btn small @click.native="submit" color="primary"
                                   :disabled="connecting || !estimatedCost || !items.length">
                                Submit Delivery
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
                <v-flex xs7>
                    <pick-pack-map></pick-pack-map>
                </v-flex>
            </v-layout>
            <v-dialog v-model="submittingDialog"
                      max-width="350px"
                      lazy persistent>
                <v-card>
                    <v-card-text>
                        <v-progress-linear v-show="connecting" :indeterminate="true"></v-progress-linear>
                        <p v-show="connecting" class="text-xs-center">Please wait....</p>
                        <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                            {{errorText}}
                        </v-alert>
                        <p v-show="!connecting && !error">Delivery added successfully</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn :color="error ? 'red' : 'primary'" flat v-show="!connecting"
                               @click.native="onCloseSubmittingDialog">
                            {{error ? 'Cancel' : 'Close'}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card-text>
    </v-card>
</template>

<script>
  import PickPackMap from './PickPackMap'
  import DeliveryItemForm from './DeliveryItemForm'
  import GooglePlaceInput from './GooglePlaceInput'
  import EventBus from '../event-bus'
  import formatCurrency from 'format-currency'
  import moment from 'moment'
  import DateInput from './DateInput'
  import TimeInput from './TimeInput'

  export default {
    components: {
      TimeInput,
      DateInput,
      GooglePlaceInput,
      DeliveryItemForm,
      PickPackMap
    },
    name: 'delivery-form',
    data: () => ({
      drawerOpen: true,
      courierOptions: [],
      originInput: '',
      originName: null,
      originFormattedAddress: null,
      originVicinity: null,
      originPosition: null,
      error: null,
      errorText: '',
      connecting: false,
      submittingDialog: false,
      estimatedCost: 0,
      estimatedMaxDuration: 0,
      estimatedMaxDistance: 0,
      totalEstimatedCostFormatted: null,
      note: null,
      scheduleDate: null,
      allowedDates: {
        dates: function (date) {
          //YYYY/MM/DD
          let givenDate = moment(date, 'YYYY/MM/DD')
          return moment().diff(givenDate, 'days') <= 0
          //const [, , day] = date.split('-')
          //return parseInt(day, 10) % 2 === 0
        }
      },
      scheduleTime: null,
      allowedTimes: {
        hours: function (value) {
          return value >= moment().hour()
        },
        minutes: function (value) {
          return value % 15 === 0
        }
      },
      addingItem: true,
      addingSchedule: false,
      mapObject: null,
      items: [],
      polyLinePaths: [],
      directionsService: new google.maps.DirectionsService(),
      calculatingDirections: false
    }),
    watch: {
      items: function () {
        this.updateTotalEstimatedCost()
      },
      polyLinePaths (polyLinePaths) {
        EventBus.$emit('onPolyLinePathsUpdated', polyLinePaths)
      }
    },
    methods: {
      deleteItem (item) {
        let that = this
        let newItems = this.items.filter(function (it) {
          that.$utils.log(it.destinationPosition.lat)
          that.$utils.log(item.destinationPosition.lat)
          that.$utils.log('--------------------------')
          return it.destinationPosition.lat !== item.destinationPosition.lat
        })
        this.items = []
        for (let i of newItems) {
          this.items.push(i)
        }
      },
      onClose () {
        this.$emit('onClose', false)
      },
      onOriginEntered (addressData, placeResultData) {
        //this.$utils.log(addressData)
        //this.$utils.log(placeResultData)
        //this.$utils.log(addressData.latitude)
        //this.$utils.log(placeResultData.geometry.location.lat())
        EventBus.$emit('closeSnackbarNotification', 'Pickup location not specified!',
          'pickupLocationNotSpecified')
        this.originFormattedAddress = placeResultData.formatted_address
        this.originVicinity = placeResultData.vicinity
        this.originName = placeResultData.name
        this.originPosition = {
          lat: placeResultData.geometry.location.lat(),
          lng: placeResultData.geometry.location.lng()
        }
        EventBus.$emit('onOriginChanged', this.originPosition)
      },
      onAddItem (item) {
        if (!this.originPosition) {
          EventBus.$emit('showSnackbarNotification', 'Pickup location not specified!',
            'pickupLocationNotSpecified')
          return
        }
        this.$refs.itemInputForm.close()
        this.addingItem = false
        this.calculatingDirections = true
        let that = this
        this.directionsService.route({
          origin: this.originPosition.lat + ',' + this.originPosition.lng,
          destination: item.destinationPosition.lat + ',' + item.destinationPosition.lng,
          travelMode: 'DRIVING'
        }, function (result, status) {
          that.$utils.log(result)
          if (status === 'OK') {

            let leg = result.routes[0].legs[0]
            item.distance = leg.distance.value
            item.duration = leg.duration.value

            let polyLinePath = []
            let steps = leg.steps
            for (let i = 0; i < steps.length; i++) {
              let nextSegment = steps[i].path
              for (let j = 0; j < nextSegment.length; j++) {
                polyLinePath.push(nextSegment[j])
              }
            }
            that.polyLinePaths.push(polyLinePath)
            that.items.push(item)


            /*that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)*/
            that.calculatingDirections = false

          } else {
            that.$utils.log('Directions request failed due to ' + status)
          }
        })
      },
      onCloseSubmittingDialog () {
        this.submittingDialog = false
        if (!this.error) {
          this.originPosition = null
          this.originFormattedAddress = null
          this.originVicinity = null
          this.note = null
          this.scheduleDate = null
          this.scheduleTime = null
          this.items = []
          this.polyLinePaths = []
          this.estimatedCost = 0
          this.totalEstimatedCostFormatted = null
          this.addingItem = true
          this.$refs.originInput.clear()
          this.$emit('onClose', true)
        }
      },
      updateTotalEstimatedCost () {
        let totalBaseCosts = 0
        this.estimatedMaxDistance = 0
        for (let i = 0; i < this.items.length; i++) {
          let item = this.items[i]
          totalBaseCosts = +item.quantity * parseFloat(item.courierOption.baseCost)
          if (item.distance > this.estimatedMaxDistance) {
            this.estimatedMaxDistance = item.distance
            this.estimatedMaxDuration = item.duration
          }
        }
        let costPerMinute = (this.estimatedMaxDuration / 60)
        let costPerKM = 3.15 * (this.estimatedMaxDistance / 1000)
        this.estimatedCost = totalBaseCosts + costPerMinute + costPerKM
        let opts = {format: '%s%v', symbol: 'KES '}
        this.totalEstimatedCostFormatted = formatCurrency(this.estimatedCost, opts)
      },
      formatDate (date) {
        if (!date) {
          return null
        }
        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) {
          return null
        }
        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
      submit () {
        this.submittingDialog = true
        this.connecting = true
        this.error = false
        let deliveryItems = []
        for (let item of this.items) {
          deliveryItems.push({
            destinationName: item.destinationName,
            destinationVicinity: item.destinationVicinity,
            destinationFormattedAddress: item.destinationFormattedAddress,
            destinationLatitude: item.destinationPosition.lat,
            destinationLongitude: item.destinationPosition.lng,
            estimatedDistance: item.distance,
            estimatedDuration: item.duration,
            note: item.note,
            recipientContact: item.recipientContact,
            recipientName: item.recipientName,
            quantity: item.quantity,
            courierOptionId: item.courierOption.id,
          })
        }
        let that = this
        this.axios.post('/deliveries', {
          originName: this.originName,
          originVicinity: this.originVicinity,
          originFormattedAddress: this.originFormattedAddress,
          originLatitude: this.originPosition.lat,
          originLongitude: this.originPosition.lng,
          scheduleDate: this.scheduleDate,
          scheduleTime: this.scheduleTime,
          estimatedCost: this.estimatedCost,
          estimatedMaxDistance: this.estimatedMaxDistance,
          estimatedMaxDuration: this.estimatedMaxDuration,
          items: deliveryItems
        }).then(function (response) {
          that.connecting = false
          that.$utils.log(response)
        }).catch(function (error) {
          that.connecting = false
          that.error = true
          if (error.response) {
            that.errorText = error.response.data
          } else {
            that.errorText = 'An error occurred'
          }
        })
      }
    },
    mounted () {
      let that = this
      EventBus.$once('onMapReady', function (mapObject) {
        that.mapObject = mapObject
      })
      //Load courier options
      this.axios.get('/courierOptions')
        .then(response => {
          console.info('Data = ' + response.data.data.length)
          this.courierOptions = this.courierOptions.concat(response.data.data)
        }).catch(e => {
        //console.error('Error ' + e);
      })
    }
  }
</script>

<style scoped>

</style>