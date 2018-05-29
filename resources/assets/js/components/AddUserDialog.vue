<template >
</template >

<script >
import ConnectionManager from './ConnectionManager'

export default {
  name: 'AddUserDialog',
  components: {ConnectionManager},
  props: {
    userToEdit: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      roles: [
        'ADMIN',
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
    userToEdit (val) {
      this.dialog = !!val
      if (!val) {
        this.onClose(null)
      }
    }
  },
  computed: {
    formIsValid: function () {
      const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return this.name && this.email && pattern.test(this.email)
        && (this.departmentId || (this.role === 'ADMIN' || this.role === 'PURCHASING_HEAD'))
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
          that.$emit('onClose', response)
        }
      }, {
        name: this.name,
        role: this.role === 'ADMIN' ? 'CLIENT_ADMIN' : this.role,
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