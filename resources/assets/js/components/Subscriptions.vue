<template>
    <v-layout row wrap>
        <v-flex xs12>
            <connection-manager ref="connectionManager" v-model="connecting"></connection-manager>
            <v-tabs fixed-tabs
                    v-model="currentTab"
                    slider-color="accent"
                    lazy
                    grow>
                <v-tab href="#pendingApproval">Pending Approval</v-tab>
                <v-tab href="#active">Active</v-tab>
                <v-tab href="#rejected">Rejected</v-tab>
            </v-tabs>
            <v-card>
                <v-data-table
                        :headers="headers"
                        :items="items"
                        hide-actions>
                    <template slot="items" slot-scope="props">
                        <td>{{ props.item.optionItem.name }}</td>
                        <td class="text-xs-center">{{ transformWeekdays(props.item.weekdays) }}</td>
                        <td class="text-xs-center">{{props.item.quantity}}</td>
                        <td class="text-xs-center">{{ $utils.formatMoney(props.item.itemCost) }}</td>
                        <td class="text-xs-center">{{ $utils.formatMoney(props.item.deliveryCost) }}</td>
                        <td class="text-xs-center">
                            {{ $utils.formatMoney(props.item.itemCost+props.item.deliveryCost)}}
                        </td>
                        <td class="text-xs-center">
                            <span v-if="props.item.renewEveryMonth">Renew monthly</span>
                            <span v-else>Up to {{ props.item.terminationDate}}</span>
                        </td>
                        <td class="text-xs-center">
                            <v-chip v-if="props.item.status === 'AT_DEPARTMENT_HEAD' || props.item.status === 'AT_PURCHASING_HEAD'"
                                    label outline color="red" small>
                                <v-icon left>info</v-icon>
                                Pending {{props.item.status === 'AT_DEPARTMENT_HEAD' ? ' Department ' :
                                ' Purchasing '}} Head approval
                            </v-chip>
                            <v-alert type="error" :value="true" v-if="props.item.status === 'REJECTED'" outline>
                                Rejected by {{props.item.rejectedBy.role.name}} <br/>
                                {{props.item.rejectedBy.name}}
                            </v-alert>
                            <div v-if="showApprovalActions(props.item)">
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
                            </div>

                        </td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>

        <add-subscription-dialog :show="showAddSubscriptionDialog"
                                 @onClose="onCloseAddSubscriptionDialog">
        </add-subscription-dialog>

        <v-fab-transition v-if="isDepartmentUser()">
            <v-btn class="ma-5"
                   color="accent"
                   fab
                   dark
                   fixed
                   bottom
                   @click.native="showAddSubscriptionDialog = true"
                   right>
                <v-icon>add</v-icon>
            </v-btn>
        </v-fab-transition>

    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import Base from './Base.vue'
  import AddSubscriptionDialog from './AddSubscriptionDialog'
  import moment from 'moment'

  export default {
    extends: Base,
    components: {
      AddSubscriptionDialog,
      ConnectionManager
    },
    name: 'subscriptions',
    data () {
      return {
        showAddSubscriptionDialog: false,
        connecting: false,
        currentTab: null,
        items: [],
        headers: [
          {text: 'Item', sortable: false, value: 'optionItem.name'},
          {text: 'Weekdays', sortable: false, value: 'weekdays'},
          {text: 'Quantity', sortable: false, value: 'quantity'},
          {text: 'Item Cost', sortable: false, value: 'item_cost'},
          {text: 'Delivery Cost', sortable: false, value: 'deliveryCost'},
          {text: 'Total Cost', sortable: false, value: 'amount'},
          {text: 'Duration', sortable: false, value: ''},
          {text: 'Action', sortable: false, value: ''},
        ],

      }
    },
    watch: {
      currentTab (val) {
        if (val) {
          this.refresh()
        }
      }
    },
    methods: {
      showApprovalActions (item) {
        return this.currentTab === 'pendingApproval' && (
          (this.isPurchasingHead() && item.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && item.status === 'AT_DEPARTMENT_HEAD')
        )
      },
      confirm (item) {
        this.items = []
        let that = this
        this.$refs.connectionManager.patch('subscriptions/' + item.id, {
          onSuccess (response) {
            that.items = []
            that.items = that.items.concat(response.data.data)
          }
        }, {
          action: 'approve'
        })
      },
      reject (item) {
        this.items = []
        let that = this
        this.$refs.connectionManager.patch('subscriptions/' + item.id, {
          onSuccess (response) {
            that.items = []
            that.items = that.items.concat(response.data.data)
          }
        }, {
          action: 'reject'
        })
      },
      transformWeekdays (weekdays) {
        let weekdayNumbers = weekdays.split('#')
        let weekdayNames = []
        for (let weekdayNumber of weekdayNumbers) {
          weekdayNames.push(moment().weekday(weekdayNumber).format('dddd'))
        }
        return weekdayNames.join(',')
      },
      onCloseAddSubscriptionDialog (val) {
        this.showAddSubscriptionDialog = false
        if (val) {
          if (this.currentTab !== 'pendingApproval') {
            this.currentTab = 'pendingApproval'
          } else {
            this.refresh()
          }
        }
      },
      refresh () {
        let that = this
        that.items = []
        this.$refs.connectionManager.get('subscriptions', {
          onSuccess (response) {
            that.items = []
            that.items = that.items.concat(response.data.data)
          }
        }, {filter: this.currentTab})
      }
    },
    mounted () {
      this.currentTab = 'active'
    }
  }
</script>

<style scoped>

</style>