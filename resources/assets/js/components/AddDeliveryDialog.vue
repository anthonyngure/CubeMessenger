<template>
    <v-dialog lazy v-model="dialog" persistent :max-width="maxWidth">
        <v-stepper v-model="step">
            <v-stepper-header>
                <v-stepper-step step="1" :complete="step > 1">Courier option</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="step > 2">Name of step 2</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3">Name of step 3</v-stepper-step>
            </v-stepper-header>

            <connection-manager ref="connectionManager"></connection-manager>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-card>
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
                                v-on:placechanged="onOriginEntered">
                        </google-place-input>
                        <!--items-->
                        <v-list three-line :style="'max-height: '+($vuetify.breakpoint.height*0.35)+'px; '"
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
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" flat :disabled="!originPosition"
                                   @click.native="showAddingItemDialog = true">
                                + Add Item
                            </v-btn>
                            <v-btn flat>Cancel</v-btn>
                            <v-btn color="primary" @click.native="step = 2">Continue</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-dialog v-model="showAddingItemDialog" lazy :max-width="maxInnerDialogWidth">
                        <delivery-item-form
                                :courierOptions="courierOptions"
                                :disabled="connecting"
                                @onAddItem="onAddItem"
                                @onClose="showAddingItemDialog = false"
                                ref="itemInputForm">
                        </delivery-item-form>
                    </v-dialog>
                    <v-btn color="primary" @click.native="showAddingItemDialog = true">Continue</v-btn>
                    <v-btn color="primary" @click.native="step = 3">Continue</v-btn>
                    <v-btn flat>Cancel</v-btn>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card>
                    <v-btn color="primary" @click.native="step = 1">Continue</v-btn>
                    <v-btn flat>Cancel</v-btn>
                </v-stepper-content>
            </v-stepper-items>

        </v-stepper>
    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import GooglePlaceInput from './GooglePlaceInput'
  import DeliveryItemForm from './DeliveryItemForm'
  import EventBus from '../event-bus'

  export default {
    name: 'AddDeliveryDialog',
    components: {DeliveryItemForm, GooglePlaceInput, ConnectionManager},
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    data () {
      return {
        step: 1,
        showAddingItemDialog: false,
        connecting: false,
        dialog: null,
        courierOptions: [],
        costVariables: [],
        urgent: false,
        originInput: '',
        originName: null,
        originFormattedAddress: null,
        originVicinity: null,
        originPosition: null,
        error: null,
        errorText: '',
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
      }
    },
    watch: {
      show (val) {
        this.dialog = !!val
        if (val && this.courierOptions.length === 0) {
          let that = this
          setTimeout(function () {
            that.loadCourierOptions()
          }, 300)
        }
      }
    },
    computed: {
      maxWidth () {
        return (this.$vuetify.breakpoint.width * 0.50) + 'px'
      },
      maxInnerDialogWidth () {
        return (this.$vuetify.breakpoint.width * 0.45) + 'px'
      }
    },
    methods: {
      loadCourierOptions () {
        //Load courier options
        let that = this
        this.$refs.connectionManager.get('/courierOptions', {
          onSuccess (response) {
            that.costVariables = response.data.costVariables
            that.courierOptions = that.courierOptions.concat(response.data.data)
          }
        }, {withCostVariables: true})
      },

      onOriginEntered (addressData, placeResultData) {
        this.originFormattedAddress = placeResultData.formatted_address
        this.originVicinity = placeResultData.vicinity
        this.originName = placeResultData.name
        this.originPosition = {
          lat: placeResultData.geometry.location.lat(),
          lng: placeResultData.geometry.location.lng()
        }
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
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.items.push(item)
            that.calculatingDirections = false

          } else {
            that.$utils.log('Directions request failed due to ' + status)
          }
        })
      },

    }
  }
</script>

<style scoped>

</style>