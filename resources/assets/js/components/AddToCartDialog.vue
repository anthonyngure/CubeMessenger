<template>
    <v-dialog
            v-model="dialog"
            max-width="400px"
            lazy>
        <v-card v-if="product">
            <v-toolbar card dark dense color="primary">
                <v-icon>shopping_cart</v-icon>
                <v-toolbar-title>Add to cart</v-toolbar-title>
            </v-toolbar>
            <connection-manager ref="connectionManager"
                                @onConnectionChange="(status)=>{connecting = status}">
            </connection-manager>
            <v-card-media :src="$utils.imageUrl(product.image)" height="150px">
                <v-container fill-height fluid>
                    <v-layout fill-height>
                        <v-flex xs12 align-end flexbox>
                            <span class="subheading white--text">{{product.name}}</span>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-media>
            <v-tooltip top lazy max-width="200px">
                <v-btn flat block slot="activator" class="mt-0 mb-0">
                    Ksh. {{product.price}}
                    <v-icon small right>info</v-icon>
                </v-btn>
                <span>{{product.description}}</span>
            </v-tooltip>
            <v-card-text>
                <v-text-field
                        v-model="quantity"
                        required
                        :disabled="connecting"
                        label="Enter quantity"
                        mask="###"
                        placeholder="Quantity">
                </v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn flat color="red"
                       :disabled="connecting"
                       @click.native="$emit('onClose')">
                    Cancel
                </v-btn>
                <v-btn color="primary"
                       @click.native="submit" :disabled="!quantity || connecting">
                    <v-icon left>check</v-icon>
                    Confirm
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>


  import ConnectionManager from './ConnectionManager'
  import EventBus from '../event-bus'

  export default {
    components: {ConnectionManager},
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
      submit () {
        let that = this
        this.$refs.connectionManager.post('shopOrders', {
          onSuccess (response) {
            that.connecting = false
            that.quantity = null
            EventBus.$emit('onShopProductOrdered')
            that.$emit('onClose', true)
          }
        }, {
          quantity: this.quantity,
          shopProductId: this.product.id
        })
      }
    },
    data () {
      return {
        dialog: false,
        quantity: null,
        connecting: false,
      }
    },
  }
</script>

<style scoped>

</style>