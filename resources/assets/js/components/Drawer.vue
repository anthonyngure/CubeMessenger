<template>
    <v-navigation-drawer
            clipped
            fixed
            permanent
            :disable-route-watcher="true"
            stateless
            :mini-variant.sync="mini"
            v-model="drawerOpen"
            app>
        <v-list>
            <v-list-tile v-if="mini"
                         @click.stop="mini = !mini">
                <v-list-tile-action>
                    <v-icon>chevron_right</v-icon>
                </v-list-tile-action>
            </v-list-tile>
            <v-list-tile avatar tag="div">
                <v-list-tile-avatar>
                    <img :src="$utils.imageUrl($auth.user().avatar)">
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>
                        <b>{{$auth.user().name}}</b>
                    </v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                    <v-btn icon @click.stop="mini = !mini">
                        <v-icon>chevron_left</v-icon>
                    </v-btn>
                </v-list-tile-action>
            </v-list-tile>
        </v-list>
        <v-divider></v-divider>
        <v-list dense>
            <template v-for="(item,index) in items">
                <v-list-tile :to="item.route" :key="index"
                             v-if="showItem(item)"
                             @mouseover="mini = false"
                             @mouseout="mini = true">
                    <v-list-tile-action>
                        <v-badge overlap small color="accent" v-if="item.showShopOrdersCount">
                            <span slot="badge">{{shopOrdersCount}}</span>
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
        mini: true,
        shopOrdersCount: 0,
        items: [
          {icon: 'dashboard', title: 'Dashboard', route: 'dashboard'},
          {icon: 'schedule', title: 'Subscriptions', route: 'subscriptions'},
          {icon: 'date_range', title: 'Appointments', route: 'appointments'},
          //{icon: 'folder', title: 'Documents', route: 'documents'},
          {icon: 'shopping_cart', title: 'Shopping', route: 'shopping'},
          {icon: 'shopping_basket', title: 'Orders', route: 'orders', showShopOrdersCount: true},
          {icon: 'computer', title: 'IT Services', route: 'it'},
          {icon: 'build', title: 'Repair Services', route: 'repairs'},
          {icon: 'local_shipping', title: 'Courier', route: 'courier'},
          {icon: 'group', title: 'Users', route: 'users'},
          {icon: 'view_list', title: 'Departments', route: 'departments'},
          {icon: 'settings', title: 'Settings', route: 'settings'}
        ]
      }
    },
    methods: {
      showItem (item) {
        //this.$utils.log(this.isClientAdmin())
        if (item.route === 'dashboard'){
          return true
        } else if (!this.isClientAdmin() && (item.route === 'users' || item.route === 'departments')) {
          return false
        } else {
          return !(this.isClientAdmin() && item.route !== 'users' && item.route !== 'departments')
        }
      },
      refreshShopOrdersCount () {
        this.axios.get('shopOrders', {
          params: {filter: 'count'}
        })
          .then(response => {
            this.$utils.log(response)
            this.shopOrdersCount = response.data.data.count
          })
          .catch(error => {
            this.$utils.log(error)
          })
      }
    },
    mounted () {
      let that = this
      EventBus.$on('onToolbarSideIconClick', function () {
        that.mini = !that.mini
      })
      EventBus.$on('collapseDrawer', function () {
        that.mini = true
      })
      EventBus.$on('onShopProductOrdered', function () {
        //Refresh the count
        that.refreshShopOrdersCount()
      })
      this.refreshShopOrdersCount()
    }
  }
</script>

<style scoped>

</style>