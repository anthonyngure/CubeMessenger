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
                        <v-tab href="#complete">Completed</v-tab>
                    </v-tabs>

                    <v-data-table
                            :headers="headers"
                            :items="serviceRequests"
                            loading
                            hide-actions>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.name }}</td>
                            <td class="text-xs-right">{{ props.item.calories }}</td>
                            <td class="text-xs-right">{{ props.item.fat }}</td>
                            <td class="text-xs-right">{{ props.item.carbs }}</td>
                            <td class="text-xs-right">{{ props.item.protein }}</td>
                            <td class="text-xs-right">{{ props.item.iron }}</td>
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
                                @onClose="addingServiceRequest = false">
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
          return value === 'it' || value === 'repairs'
        }
      }
    },
    data () {
      return {
        currentItem: null,
        addingServiceRequest: false,
        headers: [
          {text: 'ID', value: 'id'},
          {text: 'Description', value: 'description'},
          {text: 'Assigned To', value: 'assignedTo'},
          {text: 'Cost', value: 'cost'},
          {text: 'Date Added', value: 'createdAt'},
          {text: 'Scheduled Date', value: 'scheduledDate'},
          {text: 'Scheduled Time', value: 'scheduledTime'},
        ],
        serviceRequests: []
      }
    },
    watch: {
      currentItem (currentItem) {
        if (currentItem) {
          this.$refs.connectionManager.index('serviceRequests', {filter: currentItem})
        }
      }
    },
    methods: {
      onConnectionManagerSuccess (response) {

      },
    },
    mounted () {
      this.currentItem = 'new'
    }
  }
</script>

<style scoped>

</style>