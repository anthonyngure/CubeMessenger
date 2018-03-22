<template>
    <v-navigation-drawer
            clipped
            stateless
            hide-overlay
            fixed
            permanent
            :mini-variant.sync="mini"
            v-model="drawerOpen"
            app>
        <v-list>
            <v-list-tile avatar class="py-1">
                <v-list-tile-avatar>
                    <img :src="'/storage/'+$auth.user().avatar">
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>
                        <b>{{$auth.user().name}}</b>
                    </v-list-tile-title>
                    <v-list-tile-sub-title>
                        <b>{{$auth.user().email}}</b>
                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                    <v-btn icon @click.native.stop="mini = !mini">
                        <v-icon>chevron_left</v-icon>
                    </v-btn>
                </v-list-tile-action>
            </v-list-tile>
        </v-list>
        <v-divider></v-divider>
        <v-list dense>
            <template v-for="(item,index) in items">
                <v-list-tile :to="item.route" :key="index">
                    <v-list-tile-action>
                        <v-icon>{{item.icon}}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{item.title}}</v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action v-if="item.badge">
                        <v-chip small color="accent" text-color="white">
                            0
                        </v-chip>
                    </v-list-tile-action>
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
        mini: false,
        items: [
          {icon: 'dashboard', title: 'Dashboard', route: 'dashboard'},
          {icon: 'view_list', title: 'Subscriptions', route: 'subscriptions'},
          {icon: 'date_range', title: 'Appointments', route: 'appointments'},
          //{icon: 'folder', title: 'Documents', route: 'documents'},
          {icon: 'shopping_cart', title: 'Shopping', route: 'shopping'},
          {icon: 'shopping_basket', title: 'Orders', route: 'orders', badge: true},
          {icon: 'computer', title: 'IT Services', route: 'it'},
          {icon: 'build', title: 'Repair Services', route: 'repairs'},
          {icon: 'local_shipping', title: 'Courier', route: 'courier'},
        ]
      }
    },
    mounted () {
      let that = this
      EventBus.$on('onToolbarSideIconClick', function () {
        that.mini = !that.mini
      })
    }
  }
</script>

<style scoped>

</style>