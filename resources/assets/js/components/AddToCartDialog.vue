<template >
  <v-dialog
    v-model="dialog"
    max-width="500px"
    lazy >
    <v-card v-if="product" >
      <v-toolbar card
                 dark
                 dense
                 color="primary" >
        <v-icon >shopping_cart</v-icon >
        <v-toolbar-title >Add to cart</v-toolbar-title >
      </v-toolbar >
      <v-card-media :src="$utils.imageUrl(product.image)"
                    height="150px" >
        <v-container fill-height
                     fluid >
          <v-layout fill-height >
            <v-flex xs12
                    align-end
                    flexbox >
              <span class="subheading white--text" >{{product.name}}</span >
            </v-flex >
          </v-layout >
        </v-container >
      </v-card-media >
      <v-tooltip top
                 lazy
                 max-width="200px" >
        <v-btn flat
               block
               slot="activator"
               class="mt-0 mb-0" >
          {{$utils.formatMoney(product.price)}}
          <v-icon small
                  right >info
          </v-icon >
        </v-btn >
        <span >{{product.description}}</span >
      </v-tooltip >
      <v-card-text >
        <v-layout row
                  wrap
                  align-center
                  justify-center >
          <v-flex xs8 >
            <v-text-field
              v-model="quantity"
              required
              label="Enter quantity"
              mask="##"
              :rules="[rules.required]"
              @keyup.enter="quantity > 0 ? onConfirm() : ()=>{}"
              placeholder="Quantity" >
            </v-text-field >
          </v-flex >
          <v-flex xs4 >
            <v-btn flat >{{$utils.formatMoney(quantity *product.price)}}</v-btn >
          </v-flex >
        </v-layout >
      </v-card-text >
      <v-card-actions >
        <v-spacer ></v-spacer >
        <v-btn flat
               color="red"
               @click.native="onCancel()" >
          Cancel
        </v-btn >
        <v-btn color="primary"
               @click.native="onConfirm()"
               :disabled="!quantity || quantity < 1" >
          <v-icon left >check</v-icon >
          Confirm
        </v-btn >
      </v-card-actions >
    </v-card >
  </v-dialog >
</template >

<script >

import {mapActions} from 'vuex'
import Base from './Base'


export default {
  extends: Base,
  name: 'add-to-cart-dialog',
  props: {
    product: {
      required: true
    }
  },
  watch: {
    product (val) {
      this.dialog = !!val
    }
  },
  methods: {
    onCancel () {
      this.$emit('onCancel')
      this.quantity = 1
    },
    onConfirm () {
      this.$store.dispatch('addProductToCart', {product: this.product, quantity: parseInt(this.quantity)})
      this.quantity = 1
      this.$emit('onCancel')
    },
    ...mapActions([
      'addProductToCart'
    ])
  },
  data () {
    return {
      dialog: false,
      quantity: 1
    }
  }
}
</script >

<style scoped >

</style >