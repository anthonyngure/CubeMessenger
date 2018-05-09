<template >
  <v-dialog lazy
            max-width="600px"
            v-model="dialog"
            persistent >
    <v-card >
      <v-toolbar dark
                 card
                 color="primary" >
        <v-icon >vpn_key</v-icon >
        <v-toolbar-title >Change your password</v-toolbar-title >
      </v-toolbar >
      
      <v-card-text >
        <connection-manager ref="connectionManager"
                            v-model="connecting" >
        </connection-manager >
        
        <v-text-field
          placeholder="Current Password"
          label="Enter your current password"
          required
          type="password"
          :rules="[rules.required]"
          :disabled="connecting"
          v-model="currentPassword" >
        </v-text-field >
        
        <v-text-field
          placeholder="New Password"
          label="Enter your new password"
          required
          type="password"
          :rules="[rules.required]"
          :disabled="connecting"
          v-model="newPassword" >
        </v-text-field >
        
        <v-text-field
          placeholder="Confirm Password"
          label="Confirm your new password"
          required
          type="password"
          @keyup.enter="submit"
          :rules="[rules.required]"
          :disabled="connecting"
          v-model="confirmPassword" >
        </v-text-field >
        
        <guide text="You will be signed out so as to Sign In with the new password" ></guide >
      
      </v-card-text >
      
      <v-card-actions >
        <v-spacer ></v-spacer >
        <v-btn color="red"
               flat
               :disabled="connecting"
               @click.native="$emit('onClose')" >Cancel
        </v-btn >
        <v-btn color="primary"
               :disabled="connecting || !validates"
               @click.native="submit" >Submit
        </v-btn >
      </v-card-actions >
    
    </v-card >
  </v-dialog >
</template >

<script >
import ConnectionManager from './ConnectionManager'
import Guide from './Guide'

export default {
  name: 'ChangePasswordDialog',
  components: {Guide, ConnectionManager},
  props: {
    show: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      connecting: false,
      dialog: false,
      currentPassword: null,
      newPassword: null,
      confirmPassword: null,
      rules: {
        required: (value) => !!value || 'Required.'
      }
    }
  },
  computed: {
    validates () {
      return this.currentPassword && this.newPassword && this.confirmPassword && (this.newPassword === this.confirmPassword)
    }
  },
  watch: {
    show (val) {
      this.dialog = !!val
    }
  },
  methods: {
    submit () {
      let that = this
      this.$refs.connectionManager.post('user/changePassword', {
        onSuccess (response) {
          that.signOut()
        }
      }, {
        currentPassword: this.currentPassword,
        newPassword: this.newPassword,
        confirmPassword: this.confirmPassword
      })
      
    },
    signOut () {
      this.$auth.logout({
        success () {
          this.$notify({
            group: 'all',
            title: 'Sign out',
            text: 'You have signed out successfully!'
          })
        },
        error () {
          console.log('SignOut failed')
        }
      })
    }
  }
}
</script >

<style scoped >

</style >