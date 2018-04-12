<template>
    <v-navigation-drawer
            clipped
            fixed
            permanent
            :disable-route-watcher="true"
            stateless
            :width="250"
            :mini-variant.sync="mini"
            v-model="drawerOpen"
            app>
        <v-list>
            <v-list-tile avatar tag="div">
                <v-list-tile-avatar>
                    <img :src="$utils.imageUrl($auth.user().avatar)">
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-sub-title><b>{{$auth.user().name}}</b></v-list-tile-sub-title>
                    <v-list-tile-sub-title>{{$auth.user().email}}</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
        <v-divider></v-divider>
        <v-list dense>
            <template v-for="(item,index) in items">
                <v-list-tile :to="item.route" :key="index"
                             v-if="showItem(item)">
                    <v-list-tile-action>
                        <v-badge overlap small color="accent" v-if="item.pendingApprovals > 0">
                            <span slot="badge">{{item.pendingApprovals}}</span>
                            <v-icon>{{item.icon}}</v-icon>
                        </v-badge>
                        <v-icon v-else>{{item.icon}}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{item.title}}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
  import EventBus from '../event-bus'
  import Base from './Base.vue'

  export default {
    extends: Base,
    name: 'drawer',
    data () {
      return {
        drawerOpen: true,
        mini: false,
        items: [
          {icon: 'dashboard', title: 'Dashboard', route: 'dashboard', pendingApprovals: 0},
          {icon: 'schedule', title: 'Subscriptions', route: 'subscriptions', pendingApprovals: 0},
          {icon: 'date_range', title: 'Appointments', route: 'appointments', pendingApprovals: 0},
          //{icon: 'folder', title: 'Documents', route: 'documents'},
          {icon: 'shopping_cart', title: 'Shopping', route: 'shopping', pendingApprovals: 0},
          {icon: 'shopping_basket', title: 'Orders', route: 'orders', pendingApprovals: 0},
          {icon: 'computer', title: 'IT Services', route: 'it', pendingApprovals: 0},
          {icon: 'build', title: 'Repair Services', route: 'repairs', pendingApprovals: 0},
          {icon: 'local_shipping', title: 'Courier', route: 'courier', pendingApprovals: 0},
          {icon: 'group', title: 'Users', route: 'users', pendingApprovals: 0},
          {icon: 'group_work', title: 'Departments', route: 'departments', pendingApprovals: 0},
          {icon: 'settings', title: 'Settings', route: 'settings', pendingApprovals: 0}
        ]
      }
    },
    methods: {
      showItem (item) {
        //this.$utils.log(this.isClientAdmin())
        if (item.route === 'dashboard' || item.route === 'subscriptions') {
          return true
        } else if (item.route === 'users' || item.route === 'departments') {
          return this.isClientAdmin()
        } else {
          return !this.isClientAdmin()
        }
        /*if (item.route === 'dashboard'){
          return true
        } else if (!this.isClientAdmin() && (item.route === 'users' || item.route === 'departments')) {
          return false
        } else {
          return !(this.isClientAdmin() && item.route !== 'users' && item.route !== 'departments')
        }*/
      },
      refresh () {
        this.axios.get('drawerItems')
          .then(response => {
            this.$utils.log(response)
            this.items = []
            this.items = this.items.concat(response.data.data)
          })
          .catch(error => {
            this.$utils.log(error)
          })
      }
    },
    mounted () {
      let that = this
      EventBus.$on(this.$actions.clickedToolbarSideIcon, function () {
        that.mini = !that.mini
      })
      EventBus.$on(this.$actions.placedOrder, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.addedDelivery, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.addedAppointment, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.requestedService, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.approved, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.rejected, function () {
        that.refresh()
      })
      EventBus.$on(this.$actions.addedSubscription, function () {
        that.refresh()
      })
      this.refresh()
    }
  }
</script>

<style scoped>

</style>