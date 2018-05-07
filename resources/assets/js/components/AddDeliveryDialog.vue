<template >
  <v-dialog v-model="dialog"
            persistent
            max-width="800px" >
    <v-stepper v-model="step" >
      <v-stepper-header >
        <v-stepper-step step="1"
                        :complete="step > 1" >
          Pick up
        </v-stepper-step >
        <v-stepper-step step="2"
                        :complete="step > 2" >
          Items
        </v-stepper-step >
        <v-stepper-step step="3"
                        :complete="step > 3" >
          Schedule
        </v-stepper-step >
        <v-stepper-step step="4" >
          Confirm Cost
        </v-stepper-step >
      </v-stepper-header >
      <connection-manager ref="connectionManager"
                          v-model="connecting" >
      </connection-manager >
      <v-stepper-items >
        <v-stepper-content step="1" >
          <v-card >
            
            <v-card-text >
              <!--Origin-->
              <google-place-input
                id="origin"
                country="KE"
                :clearable="false"
                :disabled="connecting"
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
                v-on:placechanged="onOriginEntered" >
              
              </google-place-input >
              
              <guide text="Please provide location where item or items will be collected" ></guide >
            
            </v-card-text >
            
            <v-card-actions >
              <v-spacer ></v-spacer >
              <v-btn flat
                     @click.native="onClose(false)"
                     color="red" >Cancel
              </v-btn >
              <v-btn color="primary"
                     :disabled="!originPosition"
                     @click.native="step = 2" >
                Continue
              </v-btn >
            </v-card-actions >
          </v-card >
        </v-stepper-content >
        <v-stepper-content step="2" >
          <v-card-text >
            
            <!--items-->
            <v-list two-line
                    :style="'max-height: '+($vuetify.breakpoint.height*0.40)+'px; '"
                    class="scroll-y" >
              <template v-for="(item,i) in items" >
                <v-list-tile avatar
                             @click=""
                             :key="i" >
                  <v-list-tile-avatar >
                    <img :src="'/storage/'+item.courierOption.icon" >
                  </v-list-tile-avatar >
                  <v-list-tile-content >
                    <v-list-tile-title class="body-2" >
                      <b >{{item.quantity}} -
                          {{(item.quantity === 1 ? item.courierOption.name:
                          item.courierOption.pluralName)}}</b >
                      - {{item.distance/1000}}km
                    </v-list-tile-title >
                    <v-list-tile-sub-title class="primary--text caption" >
                      <b > To: </b >{{item.destinationName}} -
                                    {{item.destinationFormattedAddress}}
                    </v-list-tile-sub-title >
                  </v-list-tile-content >
                  <v-list-tile-action >
                    <v-menu bottom
                            right
                            offset-y >
                      <v-btn slot="activator"
                             light
                             icon >
                        <v-icon >more_vert</v-icon >
                      </v-btn >
                      <v-list dense >
                        <v-list-tile @click="deleteItem(item)" >Delete</v-list-tile >
                      </v-list >
                    </v-menu >
                  </v-list-tile-action >
                </v-list-tile >
                <v-divider v-if="i !== items.length - 1"
                           inset
                           :key="i+items.length" ></v-divider >
              </template >
            </v-list >
            
            <add-delivery-item-dialog :show="addingItem"
                                      @onAddItem="onAddItem"
                                      :courierOptions="courierOptions"
                                      @onClose="addingItem = false" >
            </add-delivery-item-dialog >
            
            <v-btn block
                   :loading="calculatingDirections"
                   flat
                   color="primary"
                   @click.native="addingItem = true"
                   :disabled="connecting || calculatingDirections" >
              <v-icon left
                      dark >add
              </v-icon >
              Add item
              <span slot="loader" >Please wait...</span >
            </v-btn >
            <guide text="One/multiple packages with different/same destination" ></guide >
          </v-card-text >
          <v-card >
            <v-card-actions >
              <v-btn flat
                     @click.native="step = 1" >
                <v-icon left >arrow_back</v-icon >
                Back
              </v-btn >
              <v-spacer ></v-spacer >
              <v-btn flat
                     @click.native="onClose(false)"
                     color="red" >Cancel
              </v-btn >
              <v-btn color="primary"
                     :disabled="!items.length"
                     @click.native="step = 3" >
                Continue
              </v-btn >
            </v-card-actions >
          </v-card >
        </v-stepper-content >
        <v-stepper-content step="3" >
          <v-card >
            <v-card-text >
              <v-layout row
                        wrap >
                <v-flex xs8
                        offset-xs2 >
                  <date-input v-model="scheduleDate"
                              :disabled="connecting"
                              placeholder="Pick up date"
                              :allowedDates="allowedDates" >
                  </date-input >
                  <time-input v-model="scheduleTime"
                              :disabled="connecting"
                              placeholder="Pick up time"
                              :allowedTimes="allowedTimes" >
                  </time-input >
                </v-flex >
              </v-layout >
            </v-card-text >
            
            <v-card-actions >
              <v-btn flat
                     @click.native="step = 2" >
                <v-icon left >arrow_back</v-icon >
                Back
              </v-btn >
              <v-spacer ></v-spacer >
              <v-btn flat
                     @click.native="onClose(false)"
                     color="red" >Cancel
              </v-btn >
              <v-btn color="primary"
                     @click.native="step = 4" >
                Continue
              </v-btn >
            </v-card-actions >
          </v-card >
        </v-stepper-content >
        <v-stepper-content step="4" >
          <v-card >
            <v-card-text >
              
              <v-layout row
                        wrap >
                <v-flex xs8
                        offset-xs2 >
                  <v-icon x-large
                          class="mb-3" >
                    account_balance_wallet
                  </v-icon >
                  <v-tooltip bottom >
                    <v-btn block
                           color="primary"
                           outline
                           large
                           flat
                           slot="activator" >
                      Total Cost Estimate: <b >{{$utils.formatMoney(estimatedCost)}}</b >
                    </v-btn >
                    <span >Urgent Cost Per Kilometer: KES {{costVariables.URGENT_COST_PER_KM}}</span ><br />
                    <span >Non Urgent Cost Per Kilometer: KES {{costVariables.NON_URGENT_COST_PER_KM}}</span >
                    <br />
                    <br />
                    <span >Urgent Cost Per Minute: KES {{costVariables.URGENT_COST_PER_MIN}}</span ><br />
                    <span >Non Cost Per Minute: KES {{costVariables.NON_URGENT_COST_PER_MIN}}</span >
                    <br />
                    <br />
                    <span >Urgent Base Cost: KES {{costVariables.URGENT_BASE_COST}}</span ><br />
                    <span >Non Urgent Base Cost: KES {{costVariables.NON_URGENT_BASE_COST}}</span >
                  </v-tooltip >
                  <v-checkbox v-model="urgent"
                              class="mt-3"
                              label="This is an urgent delivery" >
                  </v-checkbox >
                  <span v-if="itemWithLongestDistance" >Estimated Max Distance: {{itemWithLongestDistance
                                                    .distance}} meters</span >
                  <br />
                  <span v-if="itemWithLongestDistance" >Estimate Max Time: {{itemWithLongestDistance.duration}} seconds</span >
                  <br />
                </v-flex >
              </v-layout >
            
            </v-card-text >
            <v-card-actions >
              <v-btn flat
                     @click.native="step = 3" >
                <v-icon left >arrow_back</v-icon >
                Back
              </v-btn >
              <v-spacer ></v-spacer >
              <v-btn flat
                     @click.native="onClose(false)"
                     color="red" >Cancel
              </v-btn >
              <v-btn color="primary"
                     @click.native="submit" >
                Continue
              </v-btn >
            </v-card-actions >
          </v-card >
        </v-stepper-content >
      </v-stepper-items >
    </v-stepper >
  </v-dialog >
</template >

<script >
import GooglePlaceInput from './GooglePlaceInput'
import EventBus from '../event-bus'
import Guide from './Guide'
import ConnectionManager from './ConnectionManager'
import AddDeliveryItemDialog from './AddDeliveryItemDialog'
import moment from 'moment'
import DateInput from './DateInput'
import TimeInput from './TimeInput'

export default {
  name: 'AddDeliveryDialog',
  components: {TimeInput, DateInput, AddDeliveryItemDialog, ConnectionManager, Guide, GooglePlaceInput},
  props: {
    show: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      dialog: false,
      addingItem: false,
      connecting: false,
      step: 1,
      originInput: '',
      originName: null,
      originFormattedAddress: null,
      originVicinity: null,
      originPosition: null,
      items: [],
      courierOptions: [],
      costVariables: [],
      directionsService: new google.maps.DirectionsService(),
      calculatingDirections: false,
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
      urgent: false,
      itemWithLongestDistance: null
    }
  },
  computed: {
    estimatedCost () {
      if (this.items.length > 0) {
        let estimatedMaxDistance = 0
        for (let i = 0; i < this.items.length; i++) {
          let item = this.items[i]
          if (item.distance > estimatedMaxDistance) {
            estimatedMaxDistance = item.distance
            this.itemWithLongestDistance = item
          }
        }
        let timeCost
        let distanceCost
        let baseCost
        if (this.urgent) {
          distanceCost = this.costVariables.URGENT_COST_PER_KM * (this.itemWithLongestDistance.distance / 1000)
          timeCost = this.costVariables.URGENT_COST_PER_MIN * (this.itemWithLongestDistance.duration / 60)
          baseCost = this.costVariables.URGENT_BASE_COST
        } else {
          distanceCost = this.costVariables.NON_URGENT_COST_PER_KM * (this.itemWithLongestDistance.distance / 1000)
          timeCost = this.costVariables.NON_URGENT_COST_PER_MIN * (this.itemWithLongestDistance.duration / 60)
          baseCost = this.costVariables.NON_URGENT_BASE_COST
        }
  
        this.$utils.log("distanceCost: "+distanceCost)
        this.$utils.log("timeCost: "+timeCost)
        this.$utils.log("baseCost: "+baseCost)
        let totalCost = baseCost + timeCost + distanceCost
        this.$utils.log("Total cost: "+totalCost)
        let profitMargin = 0.16 * totalCost
        this.$utils.log("profitMargin: "+profitMargin)
        let valueAddedTax = 0.16 * (totalCost + profitMargin)
        this.$utils.log("valueAddedTax: "+valueAddedTax)
        
        return totalCost + profitMargin + valueAddedTax
      }
      
      return 0
    }
  },
  watch: {
    show (val) {
      this.dialog = !!val
    }
  },
  methods: {
    onOriginEntered (addressData, placeResultData) {
      this.originFormattedAddress = placeResultData.formatted_address
      this.originVicinity = placeResultData.vicinity
      this.originName = placeResultData.name
      this.originPosition = {
        lat: placeResultData.geometry.location.lat(),
        lng: placeResultData.geometry.location.lng()
      }
      EventBus.$emit('onOriginChanged', this.originPosition)
    },
    onClose (successful) {
      this.step = 1
      this.originPosition = null
      this.originFormattedAddress = null
      this.originVicinity = null
      this.note = null
      this.scheduleDate = null
      this.scheduleTime = null
      this.items = []
      this.itemWithLongestDistance = null
      this.addingItem = false
      this.$refs.originInput.clear()
      this.$emit('onClose', successful)
    },
    onAddItem (item) {
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
          that.items.push(item)
          that.calculatingDirections = false
        } else {
          that.$utils.log('Directions request failed due to ' + status)
        }
      })
    },
    deleteItem (item) {
      let that = this
      let newItems = this.items.filter(function (it) {
        return it.destinationPosition.lat !== item.destinationPosition.lat
      })
      this.items = []
      for (let i of newItems) {
        this.items.push(i)
      }
    },
    submit () {
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
          courierOptionId: item.courierOption.id
        })
      }
      let that = this
      this.$refs.connectionManager.post('/deliveries', {
        onSuccess (response) {
          that.onClose(true)
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
    //Load courier options
    this.$refs.connectionManager.get('/courierOptions', {
      onSuccess (response) {
        that.$utils.log(response.data.data)
        that.$utils.log(response.data.variables)
        that.costVariables = response.data.costVariables
        that.courierOptions = that.courierOptions.concat(response.data.data)
      }
    }, {withCostVariables: true})
  }
  
}
</script >

<style scoped >

</style >