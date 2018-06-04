<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="orderItems"
                  ref="crud"
                  :manager="manager"
                  :creatable="false"
                  :extra-top-actions="extraTopActions"
                  :filters="filters"/>
        </v-flex>
        <v-dialog v-model="sendingLPODialog" max-width="600px">
            <v-card>
                <v-card-text>
                    <connection-manager ref="connectionManager"
                                        v-model="connecting">
                    </connection-manager>
                    <p>Confirm you want to send LPOs for all the purchased products!</p>
                </v-card-text>

                <v-card-actions>
                    <v-spacer/>
                    <v-btn color="primary"
                           flat
                           :disabled="connecting"
                           @click.native="closeSendingLPODialog">Cancel
                    </v-btn>
                    <v-btn color="red"
                           flat
                           :disabled="connecting"
                           @click.native="sendLPO">Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
    </v-layout>
</template>

<script>
  import Crud from './Crud'
  import CrudBase from './CrudBase.vue'
  import ConnectionManager from './ConnectionManager'

  export default {
    name: 'OrderedItems',
    extends: CrudBase,
    components: {
      ConnectionManager,
      Crud
    },
    data () {
      return {
        connecting: false,
        sendingLPODialog: false,
        filters: [
          {value: 'PENDING_LPO', name: 'Pending LPO'},
          {value: 'SENT_LPO', name: 'Sent LPO'},
          {value: 'ACCEPTED_LPO', name: 'Accepted LPO'},
          {value: 'RECEIVED_LPO', name: 'Received LPO'},
          {value: 'REJECTED_LPO', name: 'Rejected LPO'}
        ],
        extraTopActions: [
          {
            name: 'Send LPO For All Ordered Items',
            key: 'sendLPO'
          }
        ]
      }
    },
    methods: {
      closeSendingLPODialog () {
        this.$refs.connectionManager.reset()
        this.sendingLPODialog = false
      },
      sendLPO () {
        let that = this
        this.$refs.connectionManager.post('orderItems/sendLPO', {
          onSuccess (response) {
            that.$refs.crud.setItems(response.data.data);
            that.closeSendingLPODialog()
          }
        })
      },
      initialize () {
        let that = this
        this.manager.deletable = (item) => {
          return false
        }
        this.manager.editable = (item) => {
          return false
        }
        this.manager.toValue = (header, item) => {
          if (header.value === 'priceAtPurchase') {
            return item.priceAtPurchase ? that.$utils.formatMoney(item.priceAtPurchase) : that.defaultValue
          } else if (header.value === 'product') {
            return item.product ? item.product.name : that.defaultValue
          }
          else if (header.value === 'amount') {
            return that.$utils.formatMoney(item.priceAtPurchase * item.quantity)
          }
          else if (header.value === 'supplier') {
            return (item.product && item.product.supplier) ? item.product.supplier.name : that.defaultValue
          } else {
            return item[header.value] ? item[header.value] : that.defaultValue
          }
        }
        this.manager.showTopAction = (action, items, filter) => {
          if (action.key === 'sendLPO' && filter) {
            return filter.value === 'PENDING_LPO' && items.length
          } else {
            return false
          }
        }
        this.manager.onTopAction = (action, items, filter) => {
          that.sendingLPODialog = action.key === 'sendLPO'
        }
      }
    }

  }
</script>

<style scoped>

</style>