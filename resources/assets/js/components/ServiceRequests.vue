<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <v-card-text>
                    <connection-manager ref="connectionManager"
                                        @onSuccess="onConnectionManagerSuccess">
                    </connection-manager>
                    <v-tabs fixed-tabs
                            v-model="currentItem"
                            color="white"
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
                            <td>{{ currentItem === 'complete' ? props.item.cost : 'N/A' }}</td>
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
        currentItem: null,
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
      currentItem (val) {
        if (val) {
          this.serviceRequests = []
          this.loading = true
          this.$refs.connectionManager.index('serviceRequests', {
            filter: this.currentItem,
            type: this.type
          })
        }
      }
    },
    methods: {
      onCloseAddingServiceRequest (successful) {
        this.addingServiceRequest = false
        this.currentItem = 'new'
        this.$utils.log(successful)
        if (successful) {
          this.serviceRequests = []
          this.loading = true
          this.$refs.connectionManager.index('serviceRequests', {
            filter: this.currentItem,
            type: this.type
          })
        }
      },
      onConnectionManagerSuccess (response) {
        this.serviceRequests = this.serviceRequests.concat(response.data.data)
        this.loading = false
      },
    },
    mounted () {
      this.currentItem = 'new'
    }
  }
</script>

<style scoped>

</style>