<template >
  <v-dialog v-model="dialog"
            lazy
            max-width="600px"
            persistent >
    <v-card >
      <v-toolbar dark
                 card
                 color="primary" >
        <v-icon >person</v-icon >
        <v-toolbar-title >Add User</v-toolbar-title >
      </v-toolbar >
      
      <connection-manager ref="connectionManager"
                          v-model="connecting" >
      </connection-manager >
      
      <v-card-text >
        <v-text-field
          placeholder="Full name"
          label="Enter full name"
          required
          type="text"
          :rules="[rules.required]"
          :disabled="connecting"
          v-model="name" >
        </v-text-field >
        <v-text-field label="Enter phone number"
                      placeholder="Phone number"
                      v-model="phone"
                      required
                      :rules="[rules.required, rules.phone]"
                      type="phone"
                      :disabled="connecting"
                      class="mb-2"
                      mask="##########"
                      :counter="10"
                      hint="A password will be sent to this phone number"
                      persistent-hint >
        </v-text-field >
        
        <v-text-field
          placeholder="Password"
          label="Enter a password"
          required
          type="password"
          :rules="[rules.required]"
          :disabled="connecting"
          v-model="password" >
        </v-text-field >
        
        <v-text-field
          placeholder="Email address"
          label="Enter email address"
          required
          type="email"
          :rules="[rules.required, rules.email]"
          :disabled="connecting"
          v-model="email" >
        </v-text-field >
        <v-select
          :items="roles"
          v-model="role"
          required
          label="Select user role"
          :disabled="connecting"
          clearable >
        </v-select >
        <v-select
          :items="$auth.user().client.departments"
          v-model="departmentId"
          v-if="role !== 'CLIENT_ADMIN' && role !==   'PURCHASING_HEAD'"
          item-text="name"
          item-value="id"
          required
          label="Select department"
          :disabled="connecting"
          clearable >
        </v-select >
      </v-card-text >
      
      <v-card-actions >
        <v-spacer ></v-spacer >
        <v-btn color="red"
               flat
               @click="$emit('onClose', false)" >Cancel
        </v-btn >
        <v-btn color="primary"
               :disabled="connecting || !formIsValid"
               @click="submit" >Add User
        </v-btn >
      </v-card-actions >
    </v-card >
  </v-dialog >
</template >

<script >
import ConnectionManager from './ConnectionManager'

export default {
  name: 'AddUserDialog',
  components: {ConnectionManager},
  props: {
    addingUser: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      roles: [
        'CLIENT_ADMIN',
        'PURCHASING_HEAD',
        'DEPARTMENT_HEAD',
        'DEPARTMENT_USER'
      ],
      role: null,
      password: null,
      dialog: false,
      connecting: false,
      name: null,
      email: null,
      phone: null,
      departmentId: null,
      rules: {
        required: (value) => !!value || 'Required.',
        phone: (value) => {
          return !!value && ('' + value).length === 10 || 'Phone number must be 10 characters'
        },
        email: (value) => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        }
      }
    }
  },
  watch: {
    addingUser (val) {
      this.dialog = !!val
      if (!val) {
        this.onClose()
      }
    }
  },
  computed: {
    formIsValid: function () {
      const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return this.name && this.email && pattern.test(this.email)
        && (this.departmentId || (this.role === 'CLIENT_ADMIN' || this.role === 'PURCHASING_HEAD'))
        && ('' + this.phone).length === 10 && this.role
    }
  },
  methods: {
    onClose () {
      this.name = null
      this.email = null
      this.phone = null
      this.role = null
      this.password = null
      this.departmentId = null
    },
    submit () {
      let that = this
      this.$refs.connectionManager.post('users', {
        onSuccess (response) {
          that.$emit('onClose', true)
        }
      }, {
        name: this.name,
        role: this.role,
        password: this.password,
        email: this.email,
        phone: this.phone,
        departmentId: this.departmentId
      })
    }
  },
  mounted () {
    this.departments = this.$auth.user().client.departments
  }
}
</script >

<style scoped >

</style >