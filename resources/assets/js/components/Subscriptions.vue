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
                            slider-color="accent"
                            lazy
                            grow>
                        <v-tab v-for="(subscriptionType, index) in subscriptionTypes"
                               :key="index"
                               :href="`#${subscriptionType.name}`">
                            {{subscriptionType.name}}
                        </v-tab>
                    </v-tabs>
                    <v-data-table
                            :headers="headers"
                            :items="subscriptionItems"
                            hide-actions>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.name }}</td>
                            <td class="text-xs-center">{{ props.item.clientSubscription ?
                                props.item.clientSubscription.quantity
                                : 0 }}
                            </td>
                            <td class="text-xs-center">
                                <div v-if="props.item.clientSubscription">
                                    <template
                                            v-for="(schedule, index) in props.item.clientSubscription.subscriptionSchedules">
                                        <span :key="index">{{schedule.name}}</span>
                                        <span v-if="index !== (props.item.clientSubscription.subscriptionSchedules.length - 1)"
                                              :key="index+props.item.clientSubscription.subscriptionSchedules.length">,</span>
                                    </template>
                                </div>
                                <div v-else>N/A</div>
                            </td>
                            <td class="text-xs-center">{{ props.item.clientSubscription ?
                                props.item.clientSubscription.createdAt
                                : 'N/A' }}
                            </td>
                            <td class="text-xs-center">{{ props.item.clientSubscription ? 0
                                : 0 }}
                            </td>
                            <td class="text-xs-center">KES. {{ props.item.clientSubscription ? 0
                                : 0 }}
                            </td>
                            <td class="text-xs-center">
                                <v-layout row wrap>
                                    <v-flex d-inline xs12 v-if="props.item.clientSubscription">
                                        <v-btn flat icon color="red"
                                               @click.native="unsubscribe(props.item)"
                                               :loading="unSubscribing === props.item.id"
                                               :disabled="unSubscribing > 0">
                                            <span slot="loader">Removing...</span>
                                            <v-icon>delete_forever</v-icon>
                                        </v-btn>
                                        <v-btn @click.native="editItem = props.item"
                                               :disabled="unSubscribing > 0"
                                               flat icon color="primary">
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                    </v-flex>
                                    <v-flex xs12 v-if="!props.item.clientSubscription">
                                        <v-btn @click.native="subscribeItem = props.item"
                                               :disabled="unSubscribing > 0"
                                               small outline color="primary">
                                            Subscribe
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </td>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex xs12>
            <subscription-dialog :subscribeItem="subscribeItem"
                                 @onClose="onCloseSubscriptionDialog"
                                 :subscriptionSchedules="subscriptionSchedules">
            </subscription-dialog>
            <edit-subscription-dialog :subscriptionItem="editItem"
                                      @onClose="onCloseEditSubscriptionDialog"
                                      :subscriptionSchedules="subscriptionSchedules">
            </edit-subscription-dialog>
        </v-flex>
    </v-layout>
</template>

<script>
  import SubscriptionDialog from './SubscriptionDialog'
  import EditSubscriptionDialog from './EditSubscriptionDialog'
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {
      ConnectionManager,
      EditSubscriptionDialog,
      SubscriptionDialog
    },
    name: 'subscriptions',
    data () {
      return {
        connecting: false,
        unSubscribing: 0,
        currentItem: null,
        subscribeItem: null,
        editItem: null,
        subscriptionTypes: [],
        subscriptionItems: [],
        subscriptionSchedules: [],
        headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          {text: 'Quantity Subscribed', sortable: false, value: ''},
          {text: 'Schedule', sortable: false, value: ''},
          {text: 'Subscription Date', sortable: false, value: ''},
          {text: 'Total Deliveries', sortable: false, value: ''},
          {text: 'Total Cost', sortable: false, value: ''},
          {text: 'Subscription', sortable: false, value: ''},
        ],

      }
    },
    watch: {
      currentItem (currentItem) {
        this.$utils.log(currentItem)
        if (currentItem && !this.connecting) {
          let subscriptionType = this.subscriptionTypes.find(function (element) {
            return element.name === currentItem
          })
          this.subscriptionItems = subscriptionType.subscriptionItems
        }
      },
      subscribeItem (subscribeItem) {
        this.dialog = !!subscribeItem
      },
      everydayCheckbox (everydayCheckbox) {
        if (everydayCheckbox) {
          for (let weekday of this.weekdays) {
            weekday.selected = false
          }
        }
      },
      weekdays (weekdays) {
        this.$utils.log(weekdays)
        let selected = 0
        for (let weekday of weekdays) {
          if (weekday.selected) {
            selected = selected + 1
          }
        }
        if (selected === 5) {
          this.everydayCheckbox = true
        }
      }
    },
    methods: {
      unsubscribe (subscriptionItem) {
        this.unSubscribing = subscriptionItem.id
        this.axios.delete('/subscriptions/' + subscriptionItem.id)
          .then(response => {
            let deletedSubscriptionItem = response.data.data
            this.updateSubscriptionItem(deletedSubscriptionItem)
            this.unSubscribing = 0
          })
          .catch(error => {
            this.unSubscribing = 0
          })
      },
      onConnectionManagerSuccess (response) {
        this.$utils.log(response)
        this.subscriptionTypes = []
        this.subscriptionTypes = this.subscriptionTypes.concat(response.data.data.subscriptionTypes)
        this.subscriptionSchedules = response.data.data.subscriptionSchedules
        this.currentItem = this.subscriptionTypes[0].name
      },
      updateSubscriptionItem (subscriptionItem) {
        if (subscriptionItem) {
          let updatedSubscriptionItem = this.subscriptionItems.find(function (element) {
            return element.id === subscriptionItem.id
          })
          this.$utils.log('Updated Item....')
          this.$utils.log(updatedSubscriptionItem)
          let updatedIndex = this.subscriptionItems.indexOf(updatedSubscriptionItem)
          this.$utils.log('Index ' + updatedIndex)
          let tempSubscriptionItems = this.subscriptionItems
          tempSubscriptionItems[updatedIndex] = subscriptionItem
          this.subscriptionItems = []
          for (let item of tempSubscriptionItems) {
            this.subscriptionItems.push(item)
          }
        }
      },
      onCloseSubscriptionDialog (subscriptionItem) {
        this.updateSubscriptionItem(subscriptionItem)
        this.subscribeItem = null
      },
      onCloseEditSubscriptionDialog (subscriptionItem) {
        this.updateSubscriptionItem(subscriptionItem)
        this.editItem = null
      }
    },
    mounted () {
      this.$refs.connectionManager.index('subscriptions')
    }
  }
</script>

<style scoped>

</style>