<script>
  import EventBus from '../event-bus'

  export default {
    name: 'base',
    methods: {
      isClientAdmin () {
        return this.$auth.user().accountType === 'CLIENT_ADMIN'
      },
      isPurchasingHead () {
        return this.$auth.user().accountType === 'PURCHASING_HEAD'
      },
      isDepartmentHead () {
        return this.$auth.user().accountType === 'DEPARTMENT_HEAD'
      },
      isDepartmentUser () {
        return this.$auth.user().accountType === 'DEPARTMENT_USER'
      }
    },
    mounted () {
      setTimeout(function () {
        EventBus.$emit('collapseDrawer')
      }, 1000)
    }
  }
</script>

<style scoped>

</style>