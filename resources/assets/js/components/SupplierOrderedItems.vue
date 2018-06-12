<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="orderItems"
                  ref="crud"
                  :manager="manager"
                  :creatable="false"
                  :extra-inline-actions="extraInlineActions"
                  :filters="filters"/>
        </v-flex>
    </v-layout>
</template>

<script>
  import Crud from './Crud'
  import CrudBase from './CrudBase.vue'
  import ConnectionManager from './ConnectionManager'

  export default {
    name: 'SupplierOrderedItems',
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
          {value: 'SENT_LPO', name: 'Sent LPO'},
          {value: 'ACCEPTED_LPO', name: 'Accepted LPO'},
          {value: 'REJECTED_LPO', name: 'Rejected LPO'}
        ],
        extraInlineActions: [
          {
            name: 'Accept',
            color: 'accent'
          }
        ]
      }
    },
    methods: {
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