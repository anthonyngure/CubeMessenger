<template >
  <v-dialog v-model="show"
            persistent
            max-width="800px"
            lazy >
    <v-card >
      <connection-manager ref="connectionManager"
                          v-model="connecting" ></connection-manager >
      <v-data-table
        :style="'max-height: '+($vuetify.breakpoint.height * 0.45)+'px;'" class="scroll-y"
        :headers="headers"
        :items="cartProducts"
        hide-actions >
        <template slot="items"
                  slot-scope="props" >
          <td class="text-xs-left" >{{props.item.product.name}}</td >
          <td class="text-xs-left" >{{props.item.product.price}}</td >
          <td class="text-xs-left" >{{props.item.quantity}}</td >
          <td class="text-xs-left" >{{$utils.formatMoney((props.item.quantity * props.item.product.price))}}</td >
          <td class="layout row wrap" >
            <v-btn icon
                   @click.native="removeProductFromCart(props.item)" >
              <v-icon color="red" >delete
              </v-icon >
            </v-btn >
          </td >
        </template >
      </v-data-table >
      <v-card-actions >
        <v-btn @click.native="show = false"
               color="accent"
               flat >
          Close
        </v-btn >
        <v-btn color="red"
               flat
               :disabled="!cartProducts.length"
               @click.native="()=>{removeAllProductsFromCart(); show =false}" >
          Clear All
        </v-btn >
        <v-btn color="primary"
               :disabled="!cartProducts.length"
               @click.native="submit" >Submit
        </v-btn >
        <v-spacer ></v-spacer >
        <v-btn color="primary"
               flat >
          Total {{$utils.formatMoney(cartTotal)}}
        </v-btn >
        <v-spacer ></v-spacer >
      </v-card-actions >
    </v-card >
  </v-dialog >
</template >

<script >

import EventBus from '../event-bus'
import {mapGetters, mapActions} from 'vuex'
import ConnectionManager from './ConnectionManager'

export default {
  name: 'CartDialog',
  components: {ConnectionManager},
  data () {
    return {
      show: false,
      connecting: false,
      headers: [
        //text: 'Item Id', sortable: true, value: 'product.id'},
        {text: 'Item', sortable: true, value: 'product.name', isMoney: true},
        {text: 'Price/Item', sortable: true, value: 'product.price'},
        {text: 'Quantity', sortable: true, value: 'quantity'},
        {text: 'Total Cost', sortable: true, value: 'total'},
        {text: 'Actions', sortable: false, value: 'actions'}
      ]
    }
  },
  mounted () {
    let that = this
    EventBus.$on(this.$actions.clickedToolbarCartIcon, function () {
      that.show = true
    })
  },
  computed: mapGetters({
    cartProducts: 'cartProducts',
    cartTotal: 'cartTotal'
  }),
  methods: {
    submit () {
      let that = this
      let orders = []
      this.cartProducts.forEach(function (cartProduct) {
        orders.push({
          productId: cartProduct.product.id,
          quantity: cartProduct.quantity
        })
      })
      this.$refs.connectionManager.post('orders', {
        onSuccess (response) {
          that.$store.dispatch('removeAllProductsFromCart')
          that.show = false
        }
      }, orders)
    },
    ...mapActions([
      'removeProductFromCart',
      'removeAllProductsFromCart'
    ])
  }
}
</script >

<style scoped >

</style >