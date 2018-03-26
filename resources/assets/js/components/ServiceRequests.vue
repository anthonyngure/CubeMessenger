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
                        <v-tab href="#pending">Pending</v-tab>
                        <v-tab href="#complete">Complete</v-tab>
                    </v-tabs>

                    <v-data-table
                            :headers="headers"
                            :items="serviceRequests"
                            :loading="loading"
                            hide-actions>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.id }}</td>
                            <td>{{ props.item.details }}</td>
                            <td>{{ props.item.assignedTo ? props.item.assignedTo.name : 'N/A' }}</td>
                            <td>{{ currentTab === 'complete' ? props.item.cost : 'N/A' }}</td>
                            <td>{{ props.item.scheduleDate }}</td>
                            <td>{{ props.item.scheduleTime }}</td>
                        </template>
                    </v-data-table>

                </v-card-text>
            </v-card>
        </v-flex>

        <v-fab-transition>
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

  export default {
    components: {
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
          {text: 'ID', value: 'id'},
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
      refresh () {
        let that = this
        this.serviceRequests = []
        this.loading = true
        this.$refs.connectionManager.get('serviceRequests', {
          onSuccess (response) {
            that.serviceRequests = []
            that.serviceRequests = that.serviceRequests.concat(response.data.data)
            that.loading = false
          }
        }, {
          filter: this.currentTab,
          type: this.type
        })
      },
      onCloseAddingServiceRequest (successful) {
        this.addingServiceRequest = false
        this.currentTab = 'new'
        this.$utils.log(successful)
        if (successful) {
          this.refresh()
        }
      },
    },
    mounted () {
      this.currentTab = 'new'
    }
  }
</script>

<style scoped>

</style>