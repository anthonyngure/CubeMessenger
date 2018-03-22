<template>
    <div>
        <div v-if="$auth.ready()">
            <v-app>
                <drawer v-if="$auth.check() && $auth.user().client"></drawer>
                <toolbar></toolbar>
                <v-content>
                    <v-container grid-list-xs fluid fill-height>
                        <v-layout v-if="$route.name !== 'signIn' && $auth.check() && !$auth.user().client"
                                  align-center justify-center>
                            <v-flex xs12 sm8 md4>
                                <v-card class="elevation-12">
                                    <v-toolbar dark flat color="primary">
                                        <v-toolbar-title>Client Authorization Required</v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-btn icon>
                                            <v-icon>more_vert</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                    <v-card-text>
                                        <v-alert outline color="error" icon="warning" :value="true" class="headline">
                                            Sorry! Your are not yet authorized to access any client account on <b>{{$appName}}</b>
                                        </v-alert>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn color="primary" @click.native="contact" flat>Contact {{$appName}}</v-btn>
                                        <v-btn color="error" flat @click.native="signOut">Sign Out</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                        <router-view v-else></router-view>
                    </v-container>
                </v-content>
                <v-footer app color="primary" dark :fixed="false">
                    <v-layout row wrap>
                        <v-flex xs12 py-3 text-xs-center white--text>
                            &copy;2018 — <strong>www.cube-messenger.com</strong>
                        </v-flex>
                    </v-layout>
                </v-footer>
                <v-snackbar :timeout="0" top left multi-line v-model="snackbarNotification">
                    {{snackbarNotificationMessage}}
                    <v-btn flat color="pink" @click.native="snackbarNotification = false">Close</v-btn>
                </v-snackbar>
            </v-app>
        </div>
        <div v-else>
            <loader></loader>
        </div>
    </div>
</template>

<script>
  import Loader from './components/Loader'
  import Toolbar from './components/Toolbar'
  import EventBus from './event-bus'
  import Drawer from './components/Drawer'

  export default {
    name: 'app',
    components: {
      Drawer,
      Toolbar,
      Loader
    },
    data: () => ({
      snackbarNotification: false,
      snackbarNotificationMessage: 'No message specified!',
    }),
    methods: {
      signOut () {
        this.$auth.logout({
          success () {
            this.$utils.log('SignOut success')
            this.$vuetify.theme.primary = this.$utils.primaryColor
            this.$vuetify.theme.accent = this.$utils.accentColor
          },
          error () {
            this.$utils.log('SignOut failed')
          }
        })
      },
      contact () {
        this.$utils.log(this.$route.name)
        this.$utils.log((this.$route.name !== 'signIn'))
        this.$utils.log((this.$auth.check()))
        this.$utils.log((this.$auth.user().client))
        this.$utils.log((this.$route.name !== 'signIn' && this.$auth.check() && !this.$auth.user().client))
        this.$utils.log((this.$auth.user()))
      }
    },
    mounted () {
      let that = this
      EventBus.$on('showSnackbarNotification', function (message, key) {
        that.snackbarNotificationKey = key
        that.snackbarNotification = true
        that.snackbarNotificationMessage = message
      })
      EventBus.$on('closeSnackbarNotification', function (key) {
        if (that.snackbarNotificationKey === key) {
          that.snackbarNotificationKey = null
          that.snackbarNotification = false
          that.snackbarNotificationMessage = null
        }
      })
    }
  }
</script>

<style>

</style>