<template>
    <v-dialog v-model="dialog"
              persistent
              max-width="600px">
        <v-card>
            <v-toolbar dark dense card flat color="primary">
                <v-toolbar-title>Subscribe</v-toolbar-title>
            </v-toolbar>

            <connection-manager ref="connectionManager" v-model="connecting"></connection-manager>

            <v-card-text>
                <v-text-field
                        v-model="quantity"
                        required
                        mask="###"
                        label="Enter quantity"
                        :disabled="connecting"
                        placeholder="Quantity to be delivered to you">
                </v-text-field>
                <v-list subheader dense>
                    <v-subheader>Deliver everyday</v-subheader>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-list-tile-title>Everyday</v-list-tile-title>
                            <v-list-tile-sub-title>Deliver everyday</v-list-tile-sub-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-checkbox v-model="everydayCheckbox" :disabled="connecting"></v-checkbox>
                        </v-list-tile-action>
                    </v-list-tile>
                    <v-divider class="mt-2"></v-divider>
                    <v-subheader v-if="!everydayCheckbox">Deliver on specific day(s)</v-subheader>
                    <v-list-tile v-for="item in subscriptionSchedules" :key="item.name" v-if="!everydayCheckbox">
                        <v-list-tile-content>
                            <v-list-tile-title>{{ item.name }}</v-list-tile-title>
                            <v-list-tile-sub-title>{{ item.description }}</v-list-tile-sub-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-checkbox v-model="item.selected" :disabled="connecting"></v-checkbox>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat @click.stop="close(false)" :disabled="connecting">Cancel</v-btn>
                <v-btn color="primary" @click.stop="subscribe" :disabled="connecting || !quantity">
                    Continue
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'

  export default {
    name: 'subscription-dialog',
    components: {ConnectionManager},
    props: {
      subscribeItem: {
        required: true
      }
    },
    data () {
      return {
        connecting: false,
        error: null,
        errorText: '',
        dialog: false,
        everydayCheckbox: true,
        quantity: null,
        subscriptionSchedules: [],
      }
    },
    watch: {
      subscribeItem (val) {
        this.everydayCheckbox = true
        this.dialog = !!val
        if (this.dialog && this.subscriptionSchedules.length === 0 && val) {
          this.loadSubscriptionSchedules()
        }
      },
      everydayCheckbox (val) {
        this.$utils.log(`everydayCheckbox ${val}`)
        if (val) {
          for (let i = 0; i < this.subscriptionSchedules.length; i++) {
            this.subscriptionSchedules[i].selected = false
          }
        }
      },
      subscriptionSchedules (val) {
        this.$utils.log(val)
        let selected = 0
        for (let schedule of this.subscriptionSchedules) {
          if (schedule.selected) {
            selected++
          }
        }
        this.$utils.log(selected)

        if (selected === this.subscriptionSchedules.length) {
          this.everydayCheckbox = true
        }
      }
    },
    methods: {
      reset () {
        this.quantity = null
        this.everydayCheckbox = true
      },
      close (val) {
        this.reset()
        this.$emit('onClose', val)
      },
      subscribe () {
        this.connecting = true
        let subscription = {
          subscriptionItemId: this.subscribeItem.id,
          quantity: this.quantity,
          weekdays: []
        }
        for (let schedule of this.subscriptionSchedules) {
          if (schedule.selected || this.everydayCheckbox) {
            subscription.weekdays.push(schedule.id)
          }
        }
        this.$utils.log(subscription)
        let that = this
        this.$refs.connectionManager.post('/subscriptions', {
          onSuccess (response) {
            //let subscriptionItem = response.data.data
            that.close(true)
          }
        }, {
          subscriptionItemId: subscription.subscriptionItemId,
          weekdays: subscription.weekdays,
          quantity: subscription.quantity,
        })
      },
      loadSubscriptionSchedules () {
        let that = this
        this.$refs.connectionManager.get('subscriptionSchedules', {
          onSuccess (response) {
            that.subscriptionSchedules = that.subscriptionSchedules.concat(response.data.data)
          }
        })
      }
    },
  }
</script>

<style scoped>

</style>