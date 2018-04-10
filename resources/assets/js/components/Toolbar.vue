<template>
    <v-toolbar fixed dense :color="darkTheme ? 'black' : 'white'" app clipped-left>
        <v-toolbar-side-icon @click.stop="onToolbarSideIconClick"></v-toolbar-side-icon>
        <img :src="'/img/logo.png'" height="32px" width="200px"/>
        <v-btn :color="(balance > 200 || balance === 0) ? 'primary' : 'error'"
               v-if="$auth.check()" class="ml-5 text--white"
               @click.native="refreshBalance" :loading="balance === 0">
            <v-icon left>account_balance_wallet</v-icon>
            Balance {{$utils.formatMoney(balance)}}
        </v-btn>
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$auth.check()">
            <v-btn small flat>
                <v-icon color="primary" left>check_circle</v-icon>
                Home / {{$route.name}}
            </v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
        <v-switch v-model="darkTheme" hide-details></v-switch>
        <v-menu offset-y bottom>
            <v-btn icon v-if="$auth.check()" slot="activator">
                <v-badge overlap left small color="accent">
                    <span slot="badge">0</span>
                    <v-icon color="primary">notifications</v-icon>
                </v-badge>
            </v-btn>
            <v-card>
                <v-card-text>
                    <span>No notifications</span>
                </v-card-text>
            </v-card>
        </v-menu>
        <v-toolbar-items v-if="!$auth.check()">
            <v-btn to="signIn" flat>
                <v-icon left>person</v-icon>
                Sign In
            </v-btn>
        </v-toolbar-items>
        <v-menu offset-y bottom>
            <v-btn icon slot="activator">
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list dense v-if="$auth.check()">
                <v-list-tile @click="signOut">
                    Sign Out
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import EventBus from '../event-bus'

  export default {
    name: 'toolbar',
    data () {
      return {
        darkTheme: false,
        balance: 0,
      }
    },
    watch: {
      darkTheme (val) {
        EventBus.$emit('onThemeSwitch', val)
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
      onToolbarSideIconClick () {
        EventBus.$emit('onToolbarSideIconClick')
      },
      refreshBalance () {
        this.balance = 0
        this.axios.get('balance').then(response => {
          this.balance = response.data.data.balance
        })
      }
    },
    mounted () {
      let that = this
      this.darkTheme = false
      EventBus.$on(this.$actions.addedDelivery, function () {
        that.refreshBalance()
      })
      EventBus.$on(this.$actions.placedOrder, function () {
        that.refreshBalance()
      })
      this.refreshBalance()
    }
  }
</script>

<style scoped>

</style>