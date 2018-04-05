<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-tabs fixed-tabs
                    v-model="currentTab"
                    slider-color="accent"
                    lazy
                    grow>
                <v-tab href="#pendingApproval">Pending Approval</v-tab>
                <v-tab href="#pendingDelivery">Pending Delivery</v-tab>
                <v-tab href="#delivered">Delivered</v-tab>
                <v-tab href="#rejected">Rejected</v-tab>
            </v-tabs>
            <v-card>
                <v-container fluid grid-list-md>
                    <connection-manager ref="connectionManager"
                                        @onConnectionChange="(status)=> {loading = status}">
                    </connection-manager>
                    <v-data-iterator
                            content-tag="v-layout"
                            row
                            wrap
                            :no-data-text="loading ? '' : 'No data available'"
                            :items="orders"
                            :rows-per-page-items="rowsPerPageItems"
                            :pagination.sync="pagination">
                        <v-flex xs3 slot="item"
                                slot-scope="props">
                            <v-card>
                                <v-card-media
                                        :src="$utils.imageUrl(props.item.shopProduct.image)"
                                        height="150px">
                                    <v-container fill-height fluid>
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox>
                                                <span class="subheading white--text">{{props.item.shopProduct.name}}</span>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-media>

                                <v-tooltip top lazy max-width="200px">
                                    <v-btn flat block slot="activator" class="mt-0 mb-0">
                                        Ksh. {{props.item.shopProduct.price}}
                                        <v-icon small right>info</v-icon>
                                    </v-btn>
                                    <span>{{props.item.shopProduct.description}}</span>
                                </v-tooltip>

                                <!--<v-alert class="ma-2" type="info" :value="currentTab === 'pendingApproval'">
                                    Pending <b>{{props.item.status === 'AT_DEPARTMENT_HEAD' ? 'Department' :
                                    'Purchasing'}}</b> Head approval
                                </v-alert>-->

                                <v-chip v-if="props.item.status === 'AT_DEPARTMENT_HEAD' || props.item.status === 'AT_PURCHASING_HEAD'"
                                        label outline color="red" small>
                                    <v-icon left>info</v-icon>
                                    Pending {{props.item.status === 'AT_DEPARTMENT_HEAD' ? ' Department ' :
                                    ' Purchasing '}} Head approval
                                </v-chip>

                                <v-alert type="error" :value="true" v-if="props.item.status === 'REJECTED'" outline>
                                    Rejected by {{props.item.rejectedBy.accountType}} <br/> {{props.item.rejectedBy.name}}
                                </v-alert>

                                <div class="mx-3">
                                    <span class="grey--text">Quantity: {{props.item.quantity}}</span><br>
                                    <span>Total: {{$utils.formatMoney(props.item.shopProduct.price * props.item.quantity)}}</span><br/>
                                    <span>Ordered At:
                                        <timeago class="accent--text"
                                                 :since="props.item.createdAt">
                                        </timeago>
                                    </span><br/>
                                    <span v-if="currentTab === 'delivered'">Delivered At:
                                        <timeago class="accent--text"
                                                 :since="props.item.deliveredAt">
                                        </timeago>
                                        <br/>
                                    </span>
                                    <span>Ordered By: {{props.item.user.name}}</span>
                                </div>

                                <v-card-actions v-if="showApprovalActions(props.item)">
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="red" small outline
                                           @click.native="reject(props.item)">
                                        <v-icon left small>close</v-icon>
                                        Reject
                                    </v-btn>
                                    <v-btn flat color="success" small outline
                                           @click.native="confirm(props.item)">
                                        <v-icon left small>check_circle</v-icon>
                                        Confirm
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-data-iterator>
                </v-container>
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
        purchasingHeadApproval: false,
        departmentHeadApproval: false,
        currentTab: null,
        loading: false,
        selectedProduct: null,
        orders: [],
        rowsPerPageItems: [8],
        pagination: {
          rowsPerPage: 8
        },
      }
    },
    methods: {
      showApprovalActions (order) {
        return this.currentTab === 'pendingApproval' && (
          (this.isPurchasingHead() && order.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && order.status === 'AT_DEPARTMENT_HEAD')
        )
      },
      refresh () {
        let that = this
        this.$refs.connectionManager.get('shopOrders', {
          onSuccess (response) {
            that.orders = []
            that.orders = that.orders.concat(response.data.data)
          }
        }, {
          filter: this.currentTab
        })
      },
      confirm (order) {
        this.orders = []
        let that = this
        this.$refs.connectionManager.patch('shopOrders/' + order.id, {
          onSuccess (response) {
            that.orders = []
            that.orders = that.orders.concat(response.data.data)
          }
        }, {
          action: 'approve'
        })
      },
      reject (order) {
        this.orders = []
        let that = this
        this.$refs.connectionManager.patch('shopOrders/' + order.id, {
          onSuccess (response) {
            that.orders = []
            that.orders = that.orders.concat(response.data.data)
          }
        }, {
          action: 'reject'
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
      this.currentTab = 'pendingApproval'
    }
  }
</script>

<style scoped>

</style>