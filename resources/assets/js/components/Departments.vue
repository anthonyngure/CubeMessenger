<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-toolbar color="primary" extended></v-toolbar>
            <v-layout row wrap>
                <v-flex xs12 sm8 offset-sm2>
                    <v-card style="margin-top: -64px">
                        <v-toolbar color="white">
                            <v-icon>group_work</v-icon>
                            <v-toolbar-title>Departments</v-toolbar-title>
                        </v-toolbar>
                        <connection-manager ref="connectionManager"></connection-manager>
                        <v-list three-line>
                            <template v-for="(department, index) in departments">
                                <v-list-group
                                        :key="department.id"
                                        no-action>
                                    <v-list-tile slot="activator">
                                        <v-list-tile-avatar>
                                            <v-icon>group</v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{ department.name }}</v-list-tile-title>
                                            <div>
                                                <v-chip color="accent" text-color="white" small>
                                                    <v-avatar small>
                                                        <v-icon>group</v-icon>
                                                    </v-avatar>
                                                    <span>{{department.users.length}} Members</span>
                                                </v-chip>
                                                <v-chip color="primary" text-color="white" small>
                                                    <v-avatar small>
                                                        <v-icon>account_balance_wallet</v-icon>
                                                    </v-avatar>
                                                    <span>Balance KES 0.00</span>
                                                </v-chip>
                                            </div>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <template v-for="(user, index) in department.users">
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
                                        <v-divider v-if="index !== (department.users.length - 1)" inset
                                                   :key="user.id+department.users.length">
                                        </v-divider>
                                    </template>
                                </v-list-group>
                                <v-divider v-if="index !== (departments.length - 1)" inset
                                           :key="department.id+departments.length">
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

    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {ConnectionManager},
    name: 'departments',
    data () {
      return {
        addingUser: false,
        departments: [],
      }
    },
    methods: {
      loadDepartments () {
        let that = this
        this.$refs.connectionManager.get('departments', {
          onSuccess (response) {
            that.departments = []
            that.departments = that.departments.concat(response.data.data)
          }
        })
      }
    },
    mounted () {
      this.loadDepartments()
    }
  }
</script>

<style scoped>

</style>