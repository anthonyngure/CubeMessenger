<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="orders"
                  ref="crud"
                  :manager="manager"
                  :filters="filters"
                  :creatable="false"
                  :custom-view-dialog="true"/>
        </v-flex>

        <v-dialog v-model="viewDialogHere"
                  max-width="800px">
            <v-card v-if="item">
                <v-card-text>

                    <connection-manager ref="connectionManager"
                                        v-model="connecting"/>

                    <v-data-table
                            hide-headers
                            hide-actions
                            :headers="viewItemHeaders"
                            :items="viewableHeaders">
                        <template slot="items"
                                  slot-scope="props">
                            <td>{{props.item.text}}</td>
                            <td>{{manager.toValue(props.item, item)}}</td>
                        </template>
                    </v-data-table>
                    <v-data-table
                            :items="item.items"
                            hide-actions
                            item-key="id"
                            :style="'max-height: '+($vuetify.breakpoint.height * 0.30)+'px;'"
                            class="scroll-y"
                            :headers="productHeaders">
                        <template slot="items" slot-scope="props">
                            <td>{{props.item.product.name}}</td>
                            <td>{{props.item.product.price}}</td>
                            <td>{{props.item.quantity}}</td>
                            <td>{{$utils.formatMoney(props.item.product.price*props.item.quantity)}}</td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="red darken-1"
                           flat
                           :disabled="connecting"
                           @click.native="close">Close
                    </v-btn>
                    <v-spacer/>
                    <v-btn flat
                           color="red"
                           small
                           outline
                           :disabled="connecting"
                           v-if="showRejectButton(item)"
                           @click.native="approveOrReject('reject')">
                        <v-icon left
                                small>close
                        </v-icon>
                        Reject
                    </v-btn>
                    <v-btn flat
                           color="success"
                           small
                           outline
                           :disabled="connecting"
                           v-if="showApproveButton(item)"
                           @click.native="approveOrReject('approve')">
                        <v-icon left
                                small>check_circle
                        </v-icon>
                        Approve
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-layout>
</template>

<script>
  import Crud from './Crud'
  import CrudBase from './CrudBase'
  import Guide from './Guide'
  import ConnectionManager from './ConnectionManager'

  export default {
    extends: CrudBase,
    components: {ConnectionManager, Guide, Crud},
    name: 'Orders',
    data () {
      return {
        item: null,
        viewDialogHere: false,
        connecting: false,
        viewableHeaders: [],
        viewItemHeaders: [],
        filters: [
          {value: 'pendingApproval', name: 'Pending Approval'},
          {value: 'pendingDelivery', name: 'Pending Delivery'},
          {value: 'delivered', name: 'Delivered'},
          {value: 'rejected', name: 'Rejected'}
        ],
        productHeaders: [
          {text: 'Name', value: 'product.name'},
          {text: 'Price', value: 'product.price'},
          {text: 'Quantity', value: 'quantity'},
          {text: 'Total', value: 'total'},
        ]
      }
    },
    methods: {
      close () {
        this.item = null
        this.viewDialogHere = false
      },
      initialize () {
        let that = this
        this.manager.editable = (item) => {
          return false
        }
        this.manager.deletable = (item) => {
          return false
        }
        this.manager.creatable = () => {
          return false
        }
        this.manager.toValue = (header, item) => {
          if (header.value === 'rejectedBy') {
            return item.rejectedBy ? item.rejectedBy.name + ' - (' + item.rejectedBy.role.name + ')' : that.defaultValue
          } else {
            return item[header.value] ? item[header.value] : that.defaultValue
          }
        }
        this.manager.nameOnDelete = (item) => {
          return 'this order.'
        }
        this.manager.hasCustomView = (item, viewableHeaders, viewItemHeaders) => {
          that.item = item
          that.viewDialogHere = true
          that.viewableHeaders = viewableHeaders
          that.viewItemHeaders = viewItemHeaders
          return true
        }
      },
      approveOrReject (action) {
        let that = this
        this.$refs.connectionManager.patch('orders/' + this.item.id, {
          onSuccess (response) {
            that.item = null
            that.connecting = false
            that.selected = []
            that.viewDialogHere = false
            const item = response.data.data
            if ((item.status === 'REJECTED') || (item.status === 'PENDING_DELIVERY')) {
              that.$refs.crud.removeItem(item)
            } else {
              that.$refs.crud.updateItem(item)
            }
          }
        }, {action: action})
      },
      showRejectButton (item) {
        return (this.isPurchasingHead() && item.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && item.status === 'AT_DEPARTMENT_HEAD')
      },
      showApproveButton (item) {
        //Item is rejected
        //The user who rejected is the authenticated user
        return (item.status === 'REJECTED' && item.rejectedBy && item.rejectedBy.id === this.$auth.user().id)
          || (this.isPurchasingHead() && item.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && item.status === 'AT_DEPARTMENT_HEAD')
      }
    }
  }
</script>

<style scoped>

</style>