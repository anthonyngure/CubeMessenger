<template>
    <v-toolbar fixed dense :color="darkTheme ? 'black' : 'white'" app clipped-left>
        <v-toolbar-side-icon @click.stop="onToolbarSideIconClick"></v-toolbar-side-icon>
        <img :src="'/img/logo.png'" height="32px" width="200px" class="mr-3"/>
        <!--<v-avatar size="36px" v-if="$auth.check() && $auth.user().client">
            <img :src="$utils.imageUrl($auth.user().client.logo)" alt="Logo">
        </v-avatar>
        <v-toolbar-title>
            <span>{{$auth.check() && $auth.user().client ? $auth.user().client.name : $appName}}</span>
        </v-toolbar-title>-->
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$auth.check()">
            <v-btn small flat>
                <v-icon left>check_circle</v-icon>
                Home / {{$route.name}}
            </v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
        <v-switch v-model="darkTheme" hide-details></v-switch>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn v-if="$auth.check()" @click="signOut" flat>
                <v-icon left>person</v-icon>
                Sign Out
            </v-btn>
            <v-btn to="signIn" flat v-else>
                <v-icon left>person</v-icon>
                Sign In
            </v-btn>
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
        darkTheme: false
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
      }
    },
    mounted () {
      this.darkTheme = false
    }
  }
</script>

<style scoped>

</style>