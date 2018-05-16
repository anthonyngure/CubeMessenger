<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <v-tabs fixed-tabs
              v-model="currentTab"
              slider-color="accent"
              lazy
              grow >
        <v-tab href="#pendingApproval" >Pending Approval</v-tab >
        <v-tab href="#pendingDelivery" >Pending Delivery</v-tab >
        <v-tab href="#delivered" >Delivered</v-tab >
        <v-tab href="#rejected" >Rejected</v-tab >
      </v-tabs >
      <connection-manager ref="connectionManager"
                          v-model="loading" ></connection-manager >
      <v-card >
        <v-data-iterator
          content-tag="v-expansion-panel"
          content-class="elevation-0"
          :no-data-text="loading ? '' : 'No data available'"
          :items="items"
          :rows-per-page-items="rowsPerPageItems"
          :pagination.sync="pagination" >
          <v-expansion-panel-content slot="item"
                                     slot-scope="props"
                                     lazy
                                     :value="items.length === 1" >
            <!--Header-->
            <div slot="header" >
              <v-list-tile-content >
                <v-list-tile-title class="subheading" >
                  <b >From: {{ props.item.originName }}</b >-
                  <timeago class="accent--text"
                           :since=" props.item.createdAt" ></timeago >
                </v-list-tile-title >
                <v-list-tile-sub-title class="caption primary--text" >
                  {{ props.item.originFormattedAddress }}
                </v-list-tile-sub-title >
              </v-list-tile-content >
              <v-chip color="accent"
                      label
                      small
                      text-color="white" >
                <b >{{$utils.formatMoney(props.item.estimatedCost)}} incl. 16% VAT</b >
              </v-chip >
              <v-chip v-for="(stat,i) in props.item.stats"
                      :key="i"
                      small
                      color="primary"
                      text-color="white" >
                <v-avatar :size="24" >
                  <img style="max-height: 24px; max-width: 24px"
                       :src="$utils.imageUrl(stat.courierOption.icon)"
                       :alt="stat.courierOption.name" >
                </v-avatar >
                <b >{{stat.count}} {{stat.count > 1 ? stat.courierOption.pluralName :
                    stat.courierOption.name}}</b >
              </v-chip >
              <v-chip v-if="props.item.status === 'REJECTED'"
                      label
                      outline
                      color="red"
                      small >
                <v-icon left >info</v-icon >
                Rejected by {{props.item.rejectedBy.accountType}} - {{props.item.rejectedBy.name}}
              </v-chip >
              <v-chip v-if="props.item.status === 'AT_DEPARTMENT_HEAD' || props.item.status === 'AT_PURCHASING_HEAD'"
                      label
                      outline
                      color="info"
                      small >
                <v-icon left >info</v-icon >
                Pending {{props.item.status === 'AT_DEPARTMENT_HEAD' ? ' Department ' :
                ' Purchasing '}} Head approval
              </v-chip >
              <v-btn flat
                     color="red"
                     small
                     outline
                     v-if="showApprovalActions(props.item)"
                     @click.native="reject(props.item)" >
                <v-icon left
                        small >close
                </v-icon >
                Reject
              </v-btn >
              <v-btn flat
                     color="success"
                     small
                     outline
                     v-if="showApprovalActions(props.item)"
                     @click.native="confirm(props.item)" >
                <v-icon left
                        small >check_circle
                </v-icon >
                Approve
              </v-btn >
            </div >
            <!--Content-->
            <v-list three-line >
              <v-divider :inset="false" ></v-divider >
              <template v-for="(item,index) in props.item.items" >
                <v-list-tile avatar
                             :key="index" >
                  <v-list-tile-avatar >
                    <img :src="$utils.imageUrl(item.courierOption.icon)" >
                  </v-list-tile-avatar >
                  <v-list-tile-content >
                    <v-list-tile-title class="body-2" >
                      <b >{{item.quantity > 1 ? item.courierOption.pluralName :
                          item.courierOption.name}}
                      </b >
                      <span v-if="item.status" >- {{item.status}}</span >
                    </v-list-tile-title >
                    <v-list-tile-sub-title class="caption primary--text" >
                      <b >To: </b >{{item.destinationName}}
                    </v-list-tile-sub-title >
                    <!--<v-list-tile-sub-title class="caption accent&#45;&#45;text">
                        {{item.destinationFormattedAddress}}
                    </v-list-tile-sub-title>-->
                  </v-list-tile-content >
                  <v-list-tile-action v-if="item.status === 'PENDING_DELIVERY'" >
                    <v-btn slot="activator"
                           @click="printingItem = item"
                           flat
                           outline
                           color="primary" >
                      Print QR
                    </v-btn >
                  </v-list-tile-action >
                  <v-list-tile-action v-if="item.status ==='EN_ROUTE_TO_DESTINATION'" >
                    <v-btn slot="activator"
                           @click="trackingItem = item"
                           flat
                           outline
                           color="primary" >
                      Track
                    </v-btn >
                  </v-list-tile-action >
                </v-list-tile >
                <v-divider inset
                           v-if="index !== props.item.items.length-1"
                           :key="index+props.item.items.length" ></v-divider >
              </template >
            </v-list >
          </v-expansion-panel-content >
        </v-data-iterator >
      </v-card >
    </v-flex >
    
    <add-delivery-dialog :show="addingDelivery"
                         @onClose="onCloseAddingDelivery" >
    </add-delivery-dialog >
    
    <delivery-item-q-r-dialog :item="printingItem"
                              @onClose="printingItem = null" ></delivery-item-q-r-dialog >
    
    <v-fab-transition v-if="isDepartmentUser()" >
      <v-btn class="ma-5"
             color="accent"
             fab
             dark
             fixed
             bottom
             @click.native="addingDelivery = true"
             right >
        <v-icon >add</v-icon >
      </v-btn >
    </v-fab-transition >
  
  </v-layout >
</template >

<script >
import Base from './Base.vue'
import EventBus from '../event-bus'
import moment from 'moment'
import DeliveryItemQRDialog from './DeliveryItemQRDialog'
import ConnectionManager from './ConnectionManager'
import AddDeliveryDialog from './AddDeliveryDialog'

export default {
  extends: Base,
  components: {
    AddDeliveryDialog,
    ConnectionManager,
    DeliveryItemQRDialog
  },
  name: 'courier',
  data () {
    return {
      addingDelivery: false,
      items: [],
      loading: false,
      trackingItem: null,
      printingItem: null,
      month: null,
      minMonth: null,
      maxMonth: null,
      rowsPerPageItems: [2, 4, 8],
      pagination: {
        rowsPerPage: 4
      },
      currentTab: null
    }
  },
  watch: {
    month (month) {
      if (month && this.currentTab && !this.connecting) {
        this.refresh()
      }
    },
    currentTab (currentTab) {
      if (this.month && currentTab && !this.connecting) {
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
    confirm (delivery) {
      this.items = []
      let that = this
      this.$refs.connectionManager.patch('deliveries/' + delivery.id, {
        onSuccess (response) {
          that.items = []
          that.items = that.items.concat(response.data.data)
          EventBus.$emit(that.$actions.approved)
        }
      }, {
        action: 'approve'
      })
    },
    reject (delivery) {
      this.items = []
      let that = this
      this.$refs.connectionManager.patch('deliveries/' + delivery.id, {
        onSuccess (response) {
          that.items = []
          that.items = that.items.concat(response.data.data)
          EventBus.$emit(that.$actions.rejected)
        }
      }, {
        action: 'reject'
      })
    },
    onCloseAddingDelivery (refresh) {
      this.addingDelivery = false
      if (refresh) {
        this.refresh()
      }
    },
    refresh () {
      let that = this
      that.items = []
      this.$refs.connectionManager.get('/deliveries', {
        onSuccess (response) {
          that.items = []
          that.items = that.items.concat(response.data.data)
        }
      }, {
        filter: this.currentTab,
        month: this.month
      })
    }
  },
  mounted () {
    let dateClientJoined = moment(this.$auth.user().client.createdAt)
    this.minMonth = dateClientJoined.year() + '-' + (dateClientJoined.month())
    let today = moment()
    this.maxMonth = today.year() + '-' + (today.month() + 2)
    this.month = today.year() + '-' + today.month()
    this.currentTab = 'pendingApproval'
    let that = this
    EventBus.$on('refreshDeliveryHistoryList', function () {
      that.currentTab = 'pendingApproval'
    })
  }
}
</script >

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
</style >
