<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <v-card-text>
                    <connection-manager ref="connectionManager" v-model="connecting"></connection-manager>
                    <v-tabs fixed-tabs
                            v-model="currentTab"
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
            <subscription-dialog :subscribeItem="subscribeItem" @onClose="onCloseSubscriptionDialog">
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
  import Base from './Base.vue'

  export default {
    extends: Base,
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
        currentTab: null,
        subscribeItem: null,
        editItem: null,
        subscriptionTypes: [],
        subscriptionItems: [],
        subscriptionSchedules: [],
        headers: [
          {text: 'Name', sortable: false, value: 'name'},
          {text: 'Quantity Subscribed', sortable: false, value: ''},
          {text: 'Schedule', sortable: false, value: ''},
          {text: 'Subscription Date', sortable: false, value: ''},
          {text: 'Total Deliveries', sortable: false, value: ''},
          {text: 'Total Cost', sortable: false, value: ''},
          {text: 'Action', sortable: false, value: ''},
        ],

      }
    },
    watch: {
      currentTab (val) {
        this.$utils.log(val)
        this.$utils.log(this.connecting)
        if (val) {
          let subscriptionType = this.subscriptionTypes.find(function (element) {
            return element.name === val
          })
          this.subscriptionItems = []
          this.subscriptionItems = this.subscriptionItems.concat(subscriptionType.subscriptionItems)
        }
      },
      subscribeItem (subscribeItem) {
        this.dialog = !!subscribeItem
      },
    },
    methods: {
      unsubscribe (subscriptionItem) {
        this.unSubscribing = subscriptionItem.id
        let that = this
        this.$refs.connectionManager.delete('/subscriptions/' + subscriptionItem.id, {
          onSuccess (response) {
            that.unSubscribing = 0
            that.loadSubscriptionTypes()
          }
        })
      },
      onCloseSubscriptionDialog (subscribedItem) {
        this.$utils.log('onCloseSubscriptionDialog')
        this.$utils.log(subscribedItem)
        this.subscribeItem = null
        if (subscribedItem) {
          this.loadSubscriptionTypes(true)
        }
      },
      onCloseEditSubscriptionDialog (subscribedItem) {
        if (subscribedItem) {
          this.loadSubscriptionTypes(true)
        }
        this.subscribeItem = null
      },

      loadSubscriptionTypes (refreshing) {
        let that = this
        this.subscriptionItems = []
        this.$refs.connectionManager.get('subscriptionTypes', {
          onSuccess (response) {
            that.subscriptionTypes = []
            that.subscriptionTypes = that.subscriptionTypes.concat(response.data.data)
            if (refreshing) {
              let subscriptionType = that.subscriptionTypes.find(function (element) {
                return element.name === that.currentTab
              })
              that.subscriptionItems = []
              that.subscriptionItems = that.subscriptionItems.concat(subscriptionType.subscriptionItems)
            } else {
              that.currentTab = null
              that.currentTab = that.subscriptionTypes[0].name
            }

          }
        })
      }
    },
    mounted () {
      this.loadSubscriptionTypes(false)
    }
  }
</script>

<style scoped>

</style>