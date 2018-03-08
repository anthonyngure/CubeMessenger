<template>
    <v-dialog v-model="dialog"
              lazy
              persistent
              max-width="500px">
        <v-card v-if="subscribeItem">
            <v-toolbar dark dense card flat color="primary">
                <v-toolbar-title>Subscribe to get {{subscribeItem.name}}</v-toolbar-title>
            </v-toolbar>
            <v-card-text>

                <v-progress-linear v-show="connecting" :indeterminate="true"></v-progress-linear>
                <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                    {{errorText}}
                </v-alert>

                <v-text-field
                        v-model="quantity"
                        required
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
                    <v-subheader>Deliver on specific day(s)</v-subheader>
                    <v-list-tile v-for="item in subscriptionSchedules" :key="item.name" avatar
                                 v-if="item.name !== 'Everyday'">
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
                <v-btn color="primary" flat @click.stop="onClose" :disabled="connecting">Cancel</v-btn>
                <v-btn color="primary" @click.stop="subscribe" :disabled="connecting || !quantity">
                    Continue
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
	export default {
		name: 'subscription-dialog',
		props: {
			subscribeItem: {
				required: true
			},
			subscriptionSchedules: {
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
			}
		},
		watch: {
			subscribeItem (subscribeItem) {
				this.dialog = !!subscribeItem
			},
			everydayCheckbox (everydayCheckbox) {
				this.$utils.log(`everydayCheckbox ${everydayCheckbox}`)
				if (everydayCheckbox) {
					for (let weekday of this.subscriptionSchedules) {
						weekday.selected = false
					}
				}
			},
			subscriptionSchedules: {
				handler: function (after, before) {
					// Return the object that changed
					/*let changed = after.filter(function (p, idx) {
						return Object.keys(p).some(function (prop) {
							return p[prop] !== before[idx][prop]
						})
					})
					// Log it
					console.log(changed)
*/
					this.$utils.log(this.subscriptionSchedules)
					let selected = 0
					for (let weekday of this.subscriptionSchedules) {
						this.$utils.log(`weekday = ${weekday.name}, selected = ${weekday.selected}`)
						if (weekday.selected) {
							selected = selected + 1
						}
					}

					if (selected > 0 && this.everydayCheckbox) {
						this.everydayCheckbox = false
					}

					if (selected === 5 || selected === 0) {
						this.everydayCheckbox = true
					}
				},
				deep: true
			}
		},
		methods: {
			reset () {
				this.connecting = false
				this.quantity = null
				this.everydayCheckbox = true
				for (let schedule of this.subscriptionSchedules) {
					schedule.selected = false
				}
			},
			onClose () {
				this.reset()
				this.$emit('onClose')
			},
			subscribe () {
				this.connecting = true
				let subscription = {
					subscriptionItemId: this.subscribeItem.id,
					quantity: this.quantity,
					schedules: []
				}
				if (this.everydayCheckbox) {
					let everydaySchedule = this.subscriptionSchedules.find(function (element) {
						return element.name === 'Everyday'
					})
					subscription.schedules.push(everydaySchedule.id)
				} else {
					for (let schedule of this.subscriptionSchedules) {
						if (schedule.selected) {
							subscription.schedules.push(schedule.id)
						}
					}
				}
				this.$utils.log(subscription)
				this.axios.post('/subscriptions', {
					subscriptionItemId: subscription.subscriptionItemId,
					schedules: subscription.schedules,
					quantity: subscription.quantity,
				}).then(response => {
					let subscriptionItem = response.data.data
					this.$emit('onClose', subscriptionItem)
					this.reset()
				}).catch(error => {
				})
			}
		}
	}
</script>

<style scoped>

</style>