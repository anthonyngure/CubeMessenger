<template>
    <v-toolbar fixed
               dense
               :color="darkTheme ? 'black' : 'white'"
               app
               clipped-left>
        <v-toolbar-side-icon @click.stop="onToolbarSideIconClick"/>
        <img :src="'/img/logo.png'"
             height="32px"
             width="200px"/>
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$route.name === 'shopping'">
            <v-btn icon
                   @click.stop="onToolbarCartIconClicked">
                <v-badge overlap
                         small
                         color="accent">
                    <span slot="badge">{{cartProductsCount}}</span>
                    <v-icon color="primary">shopping_cart</v-icon>
                </v-badge>
            </v-btn>
        </v-toolbar-items>
        <v-spacer/>
        <v-toolbar-items>

            <v-btn to="signIn"
                   flat
                   v-if="!$auth.check()">
                <v-icon left>person</v-icon>
                Sign In
            </v-btn>
            <v-btn small
                   flat
                   v-if="$auth.check()">
                <v-icon color="primary"
                        left>check_circle
                </v-icon>
                Home / {{$route.name}}
            </v-btn>
            <v-menu offset-y
                    bottom
                    v-if="$auth.check() && $auth.user().client">
                <v-btn flat
                       :color="accountButtonColor"
                       slot="activator">
                    <v-icon left>account_balance_wallet</v-icon>
                    Account
                    <v-icon right>keyboard_arrow_down</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile>
                        <v-list-tile-avatar>
                            <img :src="$utils.imageUrl($auth.user().client.logo)"
                                 alt=""/>
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-sub-title>{{$auth.user().client.name}}</v-list-tile-sub-title>
                            <v-list-tile-sub-title>{{$auth.user().client.email}}</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-divider class="my-2"></v-divider>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">Balance {{$utils.formatMoney(balance.actual)}}
                            </v-list-tile-title>
                            <v-list-tile-sub-title class="caption text--accent">
                                Actual amount in your account incl. blocked
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">Limit {{$utils.formatMoney(balance.limit)}}
                            </v-list-tile-title>
                            <v-list-tile-sub-title class="caption text--accent">
                                Maximum amount you can spend with a zero balance
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-divider class="my-2"></v-divider>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">Spent {{$utils.formatMoney(balance.spent)}}
                            </v-list-tile-title>
                            <v-list-tile-sub-title class="caption text--accent-1">
                                Actual amount spent
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">Blocked {{$utils.formatMoney(balance.blocked)}}
                            </v-list-tile-title>
                            <v-list-tile-sub-title class="caption text--accent">
                                Amount charged pending service completion
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-content>
                            <v-chip label
                                    small
                                    color="accent"
                                    text-color="white">
                                You are on {{$auth.user().client.accountType}} account
                            </v-chip>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-btn small
                                   color="primary"
                                   @click.native="refreshBalance">
                                <v-icon left>refresh</v-icon>
                                Refresh
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-menu>

        </v-toolbar-items>
        <v-menu offset-y
                bottom>
            <v-btn icon
                   slot="activator">
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list dense
                    v-if="$auth.check()">
                <v-list-tile @click="signOut">
                    Sign Out
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import EventBus from '../event-bus'
  import Base from './Base.vue'
  import {mapGetters} from 'vuex'

  export default {
    name: 'toolbar',
    extends: Base,
    data () {
      return {
        darkTheme: false,
        balance: 0
      }
    },
    watch: {
      darkTheme (val) {
        EventBus.$emit('onThemeSwitch', val)
      }
    },
    computed: {
      accountButtonColor () {
        if (this.$auth.user().client.accountType === 'PRE_PAID') {
          return (this.balance.actual > 200 || this.balance.actual === 0) ? 'primary' : 'error'
        } else {
          return ((this.balance.actual + this.$auth.user().client.limit) > 200 || this.balance.actual === 0) ? 'primary' : 'error'
        }
      },
      ...mapGetters({
        cartProductsCount: 'cartProductsTotal'
      })
    },
    methods: {
      signOut () {
        this.$auth.logout({
          success () {
            this.$notify({
              group: 'all',
              title: 'Signed out',
              text: 'You have signed out successfully!'
            })
          },
          error () {
            console.log('SignOut failed')
          }
        })
      },
      onToolbarSideIconClick () {
        EventBus.$emit(his.$actions.clickedToolbarCartIcon)
      },
      refreshBalance () {
        this.$utils.log('refreshBalance')
        this.balance = 0
        if (this.$auth.check() && !this.isAdmin()) {
          this.axios.get('balance').then(response => {
            this.balance = response.data.data
          })
        }
      },
      onToolbarCartIconClicked () {
        EventBus.$emit(this.$actions.clickedToolbarCartIcon)
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
      EventBus.$on(this.$actions.addedSubscription, function () {
        that.refreshBalance()
      })
      EventBus.$on(this.$actions.signedIn, function () {
        that.refreshBalance()
      })
      EventBus.$on(this.$actions.approved, function () {
        that.refreshBalance()
      })
      EventBus.$on(this.$actions.rejected, function () {
        that.refreshBalance()
      })
      EventBus.$on(this.$actions.addedSubscription, function () {
        that.refreshBalance()
      })
      this.refreshBalance()
    }
  }
</script>

<style scoped>

</style>