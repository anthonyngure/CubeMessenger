<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-toolbar color="primary" extended></v-toolbar>
            <v-layout row wrap>
                <v-flex xs12 sm8 offset-sm2>
                    <v-card style="margin-top: -64px">
                        <v-toolbar color="white">
                            <v-icon>group</v-icon>
                            <v-toolbar-title>Users</v-toolbar-title>
                        </v-toolbar>
                        <connection-manager ref="connectionManager"></connection-manager>
                        <v-list three-line>
                            <template v-for="(user, index) in users">
                                <v-list-tile :key="user.id">
                                    <v-list-tile-avatar>
                                        <img :src="$utils.imageUrl(user.avatar)">
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="user.accountType"></v-list-tile-title>
                                        <v-list-tile-sub-title v-html="user.name"></v-list-tile-sub-title>
                                        <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-divider v-if="index !== (users.length - 1)" inset
                                           :key="user.id+users.length">
                                </v-divider>
                            </template>
                        </v-list>

                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>

        <v-fab-transition>
            <v-btn class="ma-3"
                   color="accent"
                   fab
                   dark
                   fixed
                   bottom
                   @click.native="addingUser = true"
                   right>
                <v-icon>add</v-icon>
            </v-btn>
        </v-fab-transition>

        <add-user-dialog :adding-user="addingUser"
                         @onClose="onCloseAddUserDialog">
        </add-user-dialog>

    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import Base from './Base'
  import AddUserDialog from './AddUserDialog'

  export default {
    extends: Base,
    components: {AddUserDialog, ConnectionManager, Base},
    name: 'users',
    data () {
      return {
        addingUser: false,
        users: [],
      }
    },
    methods: {
      onCloseAddUserDialog(added){
        this.addingUser = false;
        if (added) {
          this.loadUsers()
        }
      },
      loadUsers () {
        let that = this
        this.$refs.connectionManager.get('users', {
          onSuccess (response) {
            that.users = []
            that.users = that.users.concat(response.data.data)
          }
        })
      }
    },
    mounted () {
      //this.loadUsers()
      this.users = this.$auth.user().client.users
    }
  }
</script>

<style scoped>

</style>