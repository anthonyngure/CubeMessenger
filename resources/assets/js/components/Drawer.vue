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

  export default {
    name: 'drawer',
    data () {
      return {
        drawerOpen: true,
        mini: true,
        shopOrdersCount: 0,
        items: [
          {icon: 'dashboard', title: 'Dashboard', route: 'dashboard', visible: true},
          {icon: 'schedule', title: 'Subscriptions', route: 'subscriptions', visible: true},
          {icon: 'date_range', title: 'Appointments', route: 'appointments', visible: true},
          //{icon: 'folder', title: 'Documents', route: 'documents'},
          {icon: 'shopping_cart', title: 'Shopping', route: 'shopping', visible: true},
          {icon: 'shopping_basket', title: 'Orders', route: 'orders', visible: true, showShopOrdersCount: true},
          {icon: 'computer', title: 'IT Services', route: 'it', visible: true},
          {icon: 'build', title: 'Repair Services', route: 'repairs', visible: true},
          {icon: 'local_shipping', title: 'Courier', route: 'courier', visible: true},
          {icon: '', title: '', route: '', visible: true},
          {icon: '', title: '', route: '', visible: true},
          {icon: '', title: '', route: '', visible: true},
        ]
      }
    },
    methods: {
      onMouseOver () {
        let that = this
        setTimeout(function () {
          that.mini = false
        }, 100)
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