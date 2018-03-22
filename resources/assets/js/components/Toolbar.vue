<template>
    <v-toolbar color="primary" fixed dense dark app clipped-left>
        <v-toolbar-side-icon @click.stop="onToolbarSideIconClick"></v-toolbar-side-icon>
        <img :src="'/img/logo.png'" height="36px" width="200px" class="mr-3"/>
        <v-avatar size="36px" v-if="$auth.check() && $auth.user().client">
            <img :src="$utils.imageUrl($auth.user().client.logo)" alt="Logo">
        </v-avatar>
        <v-toolbar-title>
            <span>{{$auth.check() && $auth.user().client ? $auth.user().client.name : $appName}}</span>
        </v-toolbar-title>

        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$auth.check()">
            <v-btn small flat>
                <v-icon left>check_circle</v-icon>
                Home / {{$route.name}}
            </v-btn>
        </v-toolbar-items>

        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$auth.check()">

            <v-btn small flat to="cart" v-if="$route.name === 'shopping'">
                <v-icon color="accent">shopping_cart</v-icon>
                {{cartItems.length}} items
            </v-btn>

            <v-menu origin="center center"
                    transition="scale-transition"
                    bottom
                    left
                    min-width="200px"
                    open-on-hover
                    offset-y>
                <v-btn flat slot="activator">
                    <span>Account</span>
                    <v-icon>arrow_drop_down</v-icon>
                </v-btn>
                <v-list dense>
                    <!--<v-list-tile v-if="$auth.user().client" to="invoices">Invoices</v-list-tile>
                    <v-list-tile v-if="$auth.user().client" to="settings">Settings</v-list-tile>
                    <v-list-tile v-if="$auth.user().client" to="/">Add User</v-list-tile>-->
                    <v-list-tile @click="signOut">Sign Out</v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar-items>
        <v-toolbar-items v-else>
            <v-btn to="signIn" flat>Sign In</v-btn>
        </v-toolbar-items>
        <v-btn icon>
            <v-icon>more_vert</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
  import EventBus from '../event-bus'

  export default {
    name: 'toolbar',
    data () {
      return {
        cartItems: []
      }
    },
    methods: {
      signOut () {
        this.$auth.logout({
          success () {
            console.log('SignOut success')
            this.$vuetify.theme.primary = this.$utils.primaryColor
            this.$vuetify.theme.accent = this.$utils.accentColor
          },
          error () {
            console.log('SignOut failed')
          }
        })
      },
      onToolbarSideIconClick(){
        EventBus.$emit('onToolbarSideIconClick')
      }
    },
    mounted () {
      let that = this
      EventBus.$on('onAddRemoveFromCart', function (item) {
        that.cartItems = that.cartItems.concat(item)
      })
    }
  }
</script>

<style scoped>

</style>