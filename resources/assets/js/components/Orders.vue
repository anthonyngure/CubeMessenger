<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <v-card-text>
                    <connection-manager ref="connectionManager">
                    </connection-manager>
                    <v-tabs fixed-tabs
                            v-model="currentTab"
                            slider-color="accent"
                            lazy
                            grow>
                        <v-tab href="#new">New</v-tab>
                        <v-tab href="#confirmed">Confirmed</v-tab>
                        <v-tab href="#delivered">Delivered</v-tab>
                    </v-tabs>

                    <v-container fluid grid-list-md v-if="orders.length">
                        <v-layout row wrap>
                            <v-flex xs3 v-for="(order, n) in orders" :key="n">
                                <v-card>
                                    <v-card-media
                                            :src="$utils.imageUrl(order.shopProduct.image)"
                                            height="150px">
                                        <v-container fill-height fluid>
                                            <v-layout fill-height>
                                                <v-flex xs12 align-end flexbox>
                                                    <span class="subheading white--text">{{order.shopProduct.name}}</span>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card-media>

                                    <v-tooltip top lazy max-width="175px">
                                        <v-btn flat block slot="activator">
                                            Ksh. {{order.shopProduct.price}}
                                            <v-icon small right>info</v-icon>
                                        </v-btn>
                                        <span>{{order.shopProduct.description}}</span>
                                    </v-tooltip>

                                    <v-card-title primary-title class="mt-0">
                                        <div>
                                            <span class="grey--text">Quantity: {{order.quantity}}</span><br>
                                            <span>Total: {{$utils.formatMoney(order.shopProduct.price * order.quantity)}}</span><br/>
                                            <span>Ordered At:
                                                <timeago class="accent--text"
                                                         :since="order.createdAt">
                                                </timeago>
                                            </span><br/>
                                            <span v-if="currentTab !== 'new'">Confirmed At:
                                                <timeago class="accent--text"
                                                         :since="order.confirmedAt">
                                                </timeago>
                                                <br/>
                                            </span>
                                            <span v-if="currentTab === 'delivered'">Delivered At:
                                                <timeago class="accent--text"
                                                         :since="order.deliveredAt">
                                                </timeago>
                                                <br/>
                                            </span>
                                        </div>
                                    </v-card-title>

                                    <v-card-actions v-if="currentTab === 'new'">
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="red" small outline
                                               @click.native="selectedProduct = product">
                                            <v-icon left small>close</v-icon>
                                            Cancel
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>

                    <v-layout class="pa-5" v-if="!orders.length && !loading" row wrap align-center justify-center>
                        <p>No data available</p>
                    </v-layout>

                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import Base from './Base.vue'

  export default {
    extends: Base,
    components: {ConnectionManager},
    name: 'orders',
    data () {
      return {
        currentTab: null,
        loading: false,
        selectedProduct: null,
        orders: [],
      }
    },
    methods: {
      refresh () {
        let that = this
        that.loading = true
        this.$refs.connectionManager.get('shopOrders', {
          onSuccess (response) {
            that.orders = []
            that.orders = that.orders.concat(response.data.data)
            that.loading = false
          }
        }, {
          filter: this.currentTab
        })
      }
    },
    watch: {
      currentTab (val) {
        if (val) {
          this.orders = []
          this.refresh()
        }
      }
    },
    mounted () {
      this.currentTab = 'new'
    }
  }
</script>

<style scoped>

</style>