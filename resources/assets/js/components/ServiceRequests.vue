<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-tabs fixed-tabs
                    v-model="currentTab"
                    slider-color="accent"
                    lazy
                    grow>
                <v-tab href="#pendingApproval">Pending Approval</v-tab>
                <v-tab href="#pending">Pending/On Progress</v-tab>
                <v-tab href="#attended">Attended</v-tab>
                <v-tab href="#rejected">Rejected</v-tab>
            </v-tabs>
            <v-card>
                <connection-manager ref="connectionManager"
                                    @onConnectionChange="(status)=> {loading = status}">
                </connection-manager>
                <v-data-table
                        :headers="headers"
                        :items="serviceRequests"
                        :loading="loading"
                        :no-data-text="loading ? '' : 'No data available'"
                        hide-actions>
                    <template slot="items" slot-scope="props">
                        <!--<td>{{ props.item.id }}</td>-->
                        <td>
                            <p class="ma-2">{{ props.item.details }}</p>
                            <div>
                                <v-chip v-if="props.item.status === 'AT_DEPARTMENT_HEAD' || props.item.status === 'AT_PURCHASING_HEAD'"
                                        label outline color="info" small>
                                    <v-icon left>info</v-icon>
                                    Pending {{props.item.status === 'AT_DEPARTMENT_HEAD' ? ' Department ' :
                                    ' Purchasing '}} Head approval
                                </v-chip>
                                <v-chip v-if="props.item.status === 'REJECTED'"
                                        label outline color="red" small>
                                    <v-icon left>info</v-icon>
                                    Rejected by {{props.item.rejectedBy.accountType}} - {{props.item.rejectedBy.name}}
                                </v-chip>
                                <v-btn flat color="red" small outline
                                       v-if="showApprovalActions(props.item)"
                                       @click.native="reject(props.item)">
                                    <v-icon left small>close</v-icon>
                                    Reject
                                </v-btn>
                                <v-btn flat color="success" small outline
                                       v-if="showApprovalActions(props.item)"
                                       @click.native="confirm(props.item)">
                                    <v-icon left small>check_circle</v-icon>
                                    Approve
                                </v-btn>
                            </div>
                        </td>
                        <td>{{ props.item.assignedTo ? props.item.assignedTo.name : 'N/A' }}</td>
                        <td>{{ currentTab === 'complete' ? props.item.cost : 'N/A' }}</td>
                        <td>{{ props.item.scheduleDate }}</td>
                        <td>{{ props.item.scheduleTime }}</td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>

        <v-fab-transition v-if="isDepartmentUser()">
            <v-btn class="ma-3"
                   color="accent"
                   fab
                   dark
                   fixed
                   bottom
                   :value="false"
                   @click.native="addingServiceRequest = true"
                   right>
                <v-icon>add</v-icon>
            </v-btn>
        </v-fab-transition>

        <service-request-dialog :show="addingServiceRequest"
                                :type="type"
                                @onClose="onCloseAddingServiceRequest">
        </service-request-dialog>

    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import ServiceRequestDialog from './ServiceRequestDialog'
  import Base from './Base.vue'

  export default {
    extends: Base,
    components: {
      Base,
      ServiceRequestDialog,
      ConnectionManager
    },
    name: 'service-requests',
    props: {
      type: {
        type: String,
        required: true,
        validator: function (value) {
          return value === 'it' || value === 'repair'
        }
      }
    },
    data () {
      return {
        currentTab: null,
        loading: false,
        addingServiceRequest: false,
        headers: [
          /*{text: 'ID', value: 'id'},*/
          {text: 'Details', value: 'details'},
          {text: 'Assigned To', value: 'assignedTo'},
          {text: 'Cost', value: 'cost'},
          {text: 'Scheduled Date', value: 'scheduleDate'},
          {text: 'Scheduled Time', value: 'scheduleTime'},
        ],
        serviceRequests: []
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
      showApprovalActions (order) {
        return this.currentTab === 'pendingApproval' && (
          (this.isPurchasingHead() && order.status === 'AT_PURCHASING_HEAD')
          || (this.isDepartmentHead() && order.status === 'AT_DEPARTMENT_HEAD')
        )
      },
      confirm (order) {
        this.serviceRequests = []
        let that = this
        this.$refs.connectionManager.patch('serviceRequests/' + order.id, {
          onSuccess (response) {
            that.serviceRequests = []
            that.serviceRequests = that.serviceRequests.concat(response.data.data)
          }
        }, {
          action: 'approve',
          type: this.type
        })
      },
      reject (order) {
        this.serviceRequests = []
        let that = this
        this.$refs.connectionManager.patch('serviceRequests/' + order.id, {
          onSuccess (response) {
            that.serviceRequests = []
            that.serviceRequests = that.serviceRequests.concat(response.data.data)
          }
        }, {
          action: 'reject',
          type: this.type
        })
      },
      refresh () {
        let that = this
        this.serviceRequests = []
        this.$refs.connectionManager.get('serviceRequests', {
          onSuccess (response) {
            that.serviceRequests = []
            that.serviceRequests = that.serviceRequests.concat(response.data.data)
          }
        }, {
          filter: this.currentTab,
          type: this.type
        })
      },
      onCloseAddingServiceRequest (successful) {
        this.addingServiceRequest = false
        this.currentTab = 'pendingApproval'
        this.$utils.log(successful)
        if (successful) {
          this.refresh()
        }
      },
    },
    mounted () {
      this.currentTab = 'pendingApproval'
    }
  }
</script>

<style scoped>

</style>