<script >
import EventBus from '../event-bus'

export default {
  name: 'base',
  data () {
    return {
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
  methods: {
    isAdmin () {
      return this.$auth.user().role.name === 'ADMIN'
    },
    isClientAdmin () {
      return this.$auth.user().role.name === 'CLIENT_ADMIN'
    },
    isPurchasingHead () {
      return this.$auth.user().role.name === 'PURCHASING_HEAD'
    },
    isDepartmentHead () {
      return this.$auth.user().role.name === 'DEPARTMENT_HEAD'
    },
    isDepartmentUser () {
      return this.$auth.user().role.name === 'DEPARTMENT_USER'
    }
  },
  mounted () {
    let that = this
    setTimeout(function () {
      EventBus.$emit(that.$actions.collapsedDrawer)
    }, 1000)
  }
}
</script >

<style scoped >

</style >