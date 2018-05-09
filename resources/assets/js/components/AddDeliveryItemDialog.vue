<template >
  <v-dialog v-model="dialog"
            lazy
            persistent
            max-width="600px" >
    <v-card raised
            class="mt-1" >
      <v-card-text class="mb-0 pb-0" >
        <v-layout wrap
                  row >
          <v-flex xs10
                  offset-xs1 >
            
            <!--<guide v-if="courierOption"
                   :text="courierOption.description" >
            </guide >-->
            
            <v-radio-group v-if="courierOptions.length"
                           v-model="courierOption"
                           row
                           hide-details
                           class="mb-3" >
              <v-radio v-for="(courierOption, i) in courierOptions"
                       :key="courierOption.id"
                       :value="courierOption"
                       v-if="courierOption.active"
                       :label="courierOption.name" >
              </v-radio >
            </v-radio-group >
          </v-flex >
        </v-layout >
        <google-place-input class="mb-2"
                            id="destination"
                            country="KE"
                            :clearable="false"
                            :disabled="!courierOption"
                            :enable-geolocation="true"
                            label="Enter destination location"
                            placeholder="Destination location"
                            prepend-icon="edit_location"
                            :required="true"
                            :rules="[rules.required]"
                            :load-google-api="false"
                            :google-api-key="$utils.googleMapsKey"
                            ref="destinationInput"
                            :hint="!placeResultData ? '' : placeResultData.formatted_address"
                            persistent-hint
                            :hide-details="false"
                            types="establishment"
                            v-on:placechanged="onDestinationEntered" >
        </google-place-input >
        <v-layout row
                  wrap >
          <v-flex xs5 >
            <v-text-field :disabled="!placeResultData"
                          label="Enter recipient name"
                          placeholder="Recipient name"
                          v-model="recipientName"
                          required
                          :rules="[rules.required]"
                          prepend-icon="person" >
            </v-text-field >
          </v-flex >
          <v-flex xs1 ></v-flex >
          <v-flex xs6 >
            <v-text-field :disabled="!placeResultData"
                          label="Enter recipient contact"
                          placeholder="Recipient contact"
                          v-model="recipientContact"
                          required
                          :rules="[rules.required, rules.recipientContact]"
                          type="phone"
                          mask="##########"
                          :counter="10"
                          prepend-icon="phone" >
            </v-text-field >
          </v-flex >
        </v-layout >
        <v-text-field
          :disabled="!recipientContact"
          :label="quantityHint"
          :placeholder="quantityHint"
          v-model="quantity"
          :rules="[rules.required, rules.quantity]"
          required
          mask="###"
          prepend-icon="format_list_numbered" >
        </v-text-field >
        <v-text-field
          name="note"
          rows="2"
          prepend-icon="note"
          v-model="note"
          label="Write a short note"
          placeholder="Write a short note"
          multi-line >
        </v-text-field >
      </v-card-text >
      <v-card-actions >
        <v-spacer ></v-spacer >
        <v-btn flat
               color="red"
               @click.native="close" >Cancel
        </v-btn >
        <v-btn small
               color="primary"
               :disabled="invalidForm"
               @click.native="onAddItem" >Add item
        </v-btn >
      </v-card-actions >
    </v-card >
  </v-dialog >
</template >

<script >

import GooglePlaceInput from './GooglePlaceInput'
import Guide from './Guide'

export default {
  name: 'AddDeliveryItemDialog',
  components: {
    Guide,
    GooglePlaceInput
  },
  props: {
    courierOptions: {
      type: Array,
      required: false,
      default: function () {
        return []
      }
    },
    show: {
      type: Boolean,
      required: true
    }
  },
  data: () => ({
    dialog: null,
    note: null,
    recipientContact: null,
    recipientName: null,
    quantity: 1,
    courierOption: null,
    addressData: null,
    placeResultData: null,
    rules: {
      required: (value) => !!value || 'Required.',
      recipientContact: (value) => {
        return !!value && ('' + value).length === 10 || 'Recipient contact must be 10 characters'
      },
      quantity: (value) => !!value && parseInt(value) >= 1 && parseInt(value) <= 100
        || 'Quantity cannot be less than 1 and greater than 100'
    }
  }),
  watch: {
    show (val) {
      this.dialog = !!val
    }
  },
  computed: {
    quantityHint: function () {
      if (this.courierOption) {
        return 'Number of ' + this.courierOption.pluralName
      } else {
        return 'Number of items'
      }
    },
    invalidForm: function () {
      return !this.courierOption || !this.addressData || !this.placeResultData
        || ('' + this.recipientContact).length !== 10 || !this.recipientName
        || this.quantity < 1 || this.quantity > 100
    }
  },
  methods: {
    onDestinationEntered (addressData, placeResultData) {
      this.addressData = addressData
      this.placeResultData = placeResultData
    },
    onAddItem: function () {
      let item = {
        recipientContact: this.recipientContact,
        recipientName: this.recipientName,
        note: this.note,
        quantity: this.quantity,
        courierOption: this.courierOption,
        destinationFormattedAddress: this.placeResultData.formatted_address,
        destinationVicinity: this.placeResultData.vicinity,
        destinationName: this.placeResultData.name,
        destinationPosition: {
          lat: this.placeResultData.geometry.location.lat(),
          lng: this.placeResultData.geometry.location.lng()
        }
      }
      this.destinationInput = ''
      this.courierOption = null
      this.note = null
      this.recipientContact = null
      this.recipientName = null
      this.quantity = 1
      this.addressData = null
      this.placeResultData = null
      this.$refs.destinationInput.clear()
      this.$emit('onAddItem', item)
    },
    close: function () {
      this.destinationInput = ''
      this.courierOption = null
      this.note = null
      this.recipientContact = null
      this.recipientName = null
      this.quantity = 1
      this.addressData = null
      this.placeResultData = null
      this.$refs.destinationInput.clear()
      this.$emit('onClose')
    }
  }
}
</script >

<style scoped >

</style >