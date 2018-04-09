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

                        <connection-manager ref="connectionManager"
                                            @onConnectionChange="(status)=> {connecting = status}">
                        </connection-manager>

                        <v-card-text>
                            <!--Origin-->
                            <google-place-input
                                    id="origin"
                                    country="KE"
                                    :clearable="false"
                                    :disabled="(addingItem && items.length > 0) || addingSchedule || items.length > 0 ||connecting"
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
                                        :disabled="connecting"
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
                            <v-layout row wrap v-if="items.length">
                                <v-flex xs4>
                                    <v-checkbox hide-details label="Urgent" v-model="urgent"></v-checkbox>
                                </v-flex>
                                <v-flex xs8>
                                    <v-tooltip bottom>
                                        <v-btn block color="accent" outline small flat slot="activator">
                                            Total Cost Estimate: <b>{{$utils.formatMoney(estimatedCost)}}</b>
                                        </v-btn>
                                        <span v-if="itemWithLongestDistance">Estimated Max Distance: {{itemWithLongestDistance.distance/1000}}km</span>
                                        <br/>
                                        <br/>
                                        <!--<span>Estimate Max Time: {{estimatedMaxDuration/60}}min</span><br/>-->
                                        <span>Urgent Cost Per Kilometer: KES {{systemVariables.URGENT_COST_PER_KM}}</span><br/>
                                        <span>Non Urgent Cost Per Kilometer: KES {{systemVariables.NON_URGENT_COST_PER_KM}}</span>
                                        <br/>
                                        <br/>
                                        <span>Urgent Cost Per Minute: KES {{systemVariables.URGENT_COST_PER_MIN}}</span><br/>
                                        <span>Non Cost Per Minute: KES {{systemVariables.NON_URGENT_COST_PER_MIN}}</span>
                                        <br/>
                                        <br/>
                                        <span>Estimate Total Cost: {{$utils.formatMoney(estimatedCost)}}</span>
                                    </v-tooltip>
                                </v-flex>
                            </v-layout>

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
        </v-card-text>
    </v-card>
</template>

<script>
  import PickPackMap from './PickPackMap'
  import DeliveryItemForm from './DeliveryItemForm'
  import GooglePlaceInput from './GooglePlaceInput'
  import EventBus from '../event-bus'
  import moment from 'moment'
  import DateInput from './DateInput'
  import TimeInput from './TimeInput'
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {
      ConnectionManager,
      TimeInput,
      DateInput,
      GooglePlaceInput,
      DeliveryItemForm,
      PickPackMap
    },
    name: 'delivery-form',
    data: () => ({
      urgent: false,
      courierOptions: [],
      systemVariables: [],
      originInput: '',
      originName: null,
      originFormattedAddress: null,
      originVicinity: null,
      originPosition: null,
      error: null,
      errorText: '',
      connecting: false,
      estimatedCost: 0,
      itemWithLongestDistance: null,
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
      urgent: function () {
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
      updateTotalEstimatedCost () {
        if (this.items.length > 0) {
          let estimatedMaxDistance = 0
          for (let i = 0; i < this.items.length; i++) {
            let item = this.items[i]
            if (item.distance > estimatedMaxDistance) {
              estimatedMaxDistance = item.distance
              this.itemWithLongestDistance = item
            }
          }
          let costPerMinute
          let costPerKM
          let baseCost
          if (this.urgent) {
            costPerMinute = this.systemVariables.URGENT_COST_PER_KM * (this.itemWithLongestDistance.distance / 60)
            costPerKM = this.systemVariables.URGENT_COST_PER_MIN * (this.itemWithLongestDistance.duration / 1000)
            baseCost = this.systemVariables.URGENT_BASE_COST
          } else {
            costPerMinute = this.systemVariables.NON_URGENT_COST_PER_KM * (this.itemWithLongestDistance.distance / 60)
            costPerKM = this.systemVariables.NON_URGENT_COST_PER_MIN * (this.itemWithLongestDistance.duration / 1000)
            baseCost = this.systemVariables.NON_URGENT_BASE_COST
          }
          this.estimatedCost = baseCost + costPerMinute + costPerKM
        }
      },
      submit () {
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
        this.$refs.connectionManager.post('/deliveries', {
          onSuccess (response) {
            that.originPosition = null
            that.originFormattedAddress = null
            that.originVicinity = null
            that.note = null
            that.scheduleDate = null
            that.scheduleTime = null
            that.items = []
            that.polyLinePaths = []
            that.estimatedCost = 0
            that.itemWithLongestDistance = null
            that.addingItem = true
            that.$refs.originInput.clear()
            that.$emit('onClose', true)
            EventBus.$emit(that.$actions.addedDelivery)
            that.$utils.log(response)
          }
        }, {
          urgent: this.urgent,
          originName: this.originName,
          originVicinity: this.originVicinity,
          originFormattedAddress: this.originFormattedAddress,
          originLatitude: this.originPosition.lat,
          originLongitude: this.originPosition.lng,
          scheduleDate: this.scheduleDate,
          scheduleTime: this.scheduleTime,
          estimatedCost: this.estimatedCost,
          estimatedMaxDistance: this.itemWithLongestDistance.distance,
          estimatedMaxDuration: this.itemWithLongestDistance.duration,
          items: deliveryItems
        })
      }
    },
    mounted () {
      let that = this
      EventBus.$once('onMapReady', function (mapObject) {
        that.mapObject = mapObject
      })
      //Load courier options
      this.$refs.connectionManager.get('/courierOptions', {
        onSuccess (response) {
          that.$utils.log(response.data.data)
          that.$utils.log(response.data.variables)
          that.systemVariables = response.data.variables
          that.courierOptions = that.courierOptions.concat(response.data.data)
        }
      }, {withVariables: true})
    }
  }
</script>

<style scoped>

</style>