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
                        <v-tab href="#confirmed">Confirmed</v-tab>
                        <v-tab href="#delivered">Delivered</v-tab>
                    </v-tabs>

                    <v-data-table
                            :headers="headers"
                            :items="orders"
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
    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {ConnectionManager},
    name: 'orders',
    data () {
      return {
        currentItem: null,
        loading: false,
        headers: [
          {text: 'ID', value: 'id'},
          {text: 'Item', value: 'details'},
          {text: 'Quantity', value: 'assignedTo'},
          {text: 'Total Cost', value: 'cost'},
          {text: 'Date Ordered', value: 'scheduleDate'},
          {text: 'Date Confirmed', value: 'scheduleTime'},
          {text: 'Date Delivered', value: 'scheduleTime'},
        ],
        orders: [],
      }
    },
    methods: {
      onConnectionManagerSuccess (response) {
        this.orders = this.orders.concat(response.data.data)
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