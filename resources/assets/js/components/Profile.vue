<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <v-card >
        <v-card-media :src="$utils.imageUrl($auth.user().client.logo)"
                      height="250px" >
        </v-card-media >
        <v-card-text >
          
          <v-layout row
                    wrap >
            <v-flex xs8
                    offset-xs2 >
              <v-list two-line
                      subheader >
                <v-subheader >Name and email</v-subheader >
                <v-list-tile avatar >
                  <v-list-tile-avatar >
                    <img :src="$utils.imageUrl($auth.user().avatar)" />
                  </v-list-tile-avatar >
                  <v-list-tile-content >
                    <v-list-tile-title >{{ $auth.user().name }}</v-list-tile-title >
                    <v-list-tile-sub-title >{{ $auth.user().email }}</v-list-tile-sub-title >
                  </v-list-tile-content >
                  <v-list-tile-action >
                    <v-btn color="primary"
                           @click.native="changingPassword = true" >Change Password
                    </v-btn >
                  </v-list-tile-action >
                </v-list-tile >
                <v-divider ></v-divider >
                <v-subheader >Department and role</v-subheader >
                <v-list-tile avatar >
                  <v-list-tile-avatar >
                    <v-icon x-large >group_work</v-icon >
                  </v-list-tile-avatar >
                  <v-list-tile-content >
                    <v-list-tile-title >{{ $auth.user().department.name }}</v-list-tile-title >
                    <v-list-tile-sub-title >{{ $auth.user().role.name }}</v-list-tile-sub-title >
                  </v-list-tile-content >
                </v-list-tile >
                <v-divider ></v-divider >
                <v-subheader >Upcoming Appointments</v-subheader >
                <connection-manager ref="connectionManager" ></connection-manager >
                <template v-for="(appointment, index) in appointments" >
                  <v-list-tile :key="appointment.id" >
                    <v-list-tile-content >
                      <v-list-tile-title >{{ appointment.title }}</v-list-tile-title >
                      <v-list-tile-sub-title >
                        <v-chip label
                                small
                                color="accent"
                                text-color="white" >
                          <v-icon left >access_time</v-icon >
                          {{appointment.allDay ? 'All day'
                          : appointment.startingAt+' -'+appointment.endingAt}}
                        </v-chip >
                      </v-list-tile-sub-title >
                      <v-list-tile-sub-title >{{ appointment.venue }}</v-list-tile-sub-title >
                    </v-list-tile-content >
                  </v-list-tile >
                  <v-divider v-if="(index+1) < appointments.length"
                             :key="appointment.id+index+1" ></v-divider >
                </template >
              
              </v-list >
            </v-flex >
          </v-layout >
        </v-card-text >
      </v-card >
    </v-flex >
    
    <change-password-dialog :show="changingPassword"
                            @onClose="changingPassword=false" ></change-password-dialog >
  
  </v-layout >
</template >

<script >
import ConnectionManager from './ConnectionManager'
import ChangePasswordDialog from './ChangePasswordDialog'

export default {
  name: 'Profile',
  components: {ChangePasswordDialog, ConnectionManager},
  data () {
    return {
      appointments: [],
      changingPassword: false
    }
  },
  mounted () {
    let that = this
    this.$refs.connectionManager.get('user/appointments', {
      onSuccess (response) {
        that.appointments = response.data.data
      }
    })
  }
}
</script >

<style scoped >
</style >