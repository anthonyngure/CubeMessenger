<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="orders"
                  ref="crud"
                  :manager="manager"
                  :filters="filters"
                  :custom-view-dialog="true"/>
        </v-flex>

        <v-dialog v-model="viewDialogHere"
                  max-width="800px"
                  persistent>
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

                    <guide text="Check the items you want to approve or reject in this order"
                           v-if="showApprovalActions(item.items[0])">
                    </guide>
                    <v-data-table
                            :items="item.items"
                            v-model="selected"
                            hide-actions
                            item-key="id"
                            :style="'max-height: '+($vuetify.breakpoint.height * 0.30)+'px;'"
                            class="scroll-y"
                            :select-all="showApprovalActions(item.items[0])"
                            :headers="productHeaders">
                        <template slot="items" slot-scope="props">
                            <td v-if="showApprovalActions(props.item)">
                                <v-checkbox
                                        v-model="props.selected"
                                        primary
                                        hide-details>
                                </v-checkbox>
                            </td>
                            <td>{{props.item.product.name}}</td>
                            <td>{{props.item.product.price}}</td>
                            <td>{{props.item.quantity}}</td>
                            <td>{{$utils.formatMoney(props.item.product.price*props.item.quantity)}}</td>
                            <td>{{props.item.status}}</td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-btn :color="selected.length ? 'primary' : 'accent'"
                           :disabled="connecting"
                           v-if="showApprovalActions(item.items[0])"
                           @click.native="approve">{{getActionText}}
                    </v-btn>

                    <v-spacer/>
                    <v-btn color="red darken-1"
                           flat
                           @click.native="close">Close
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
        selected: [],
        filters: [
          'pendingApproval', 'pendingDelivery', 'delivered', 'rejected'
        ],
        productHeaders: [
          {text: 'Name', value: 'product.name'},
          {text: 'Price', value: 'product.price'},
          {text: 'Quantity', value: 'quantity'},
          {text: 'Total', value: 'total'},
          {text: 'Status', value: 'status'}
        ]
      }
    },
    computed: {
      getActionText () {
        if (this.selected.length === 0) {
          return 'Reject all un selected items'
        } else if (this.selected.length !== this.item.items.length) {
          return 'Accept all selected items and reject items un selected'
        } else {
          return 'Accept all selected items'
        }
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
        this.manager.creatable = () => {
          return false
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
      approve () {
        let that = this
        this.item.items.forEach(product => {
          let selected = that.selected.find(selected => selected.id === product.id)
          product.approved = !!selected
        })
        this.$refs.connectionManager.patch('orders/' + this.item.id, {
          onSuccess (response) {
            that.item = null
            that.selected = []
            that.viewDialogHere = false
            that.$refs.crud.updateItem(response.data.data)
          }
        }, this.item.items)
      },
      showApprovalActions (item) {
        return (this.isPurchasingHead() && item.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && item.status === 'AT_DEPARTMENT_HEAD')
      },
    }
  }
</script>

<style scoped>

</style>