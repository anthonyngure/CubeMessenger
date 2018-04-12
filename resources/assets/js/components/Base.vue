<script>
  import EventBus from '../event-bus'

  export default {
    name: 'base',
    methods: {
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
      },
    },
    mounted () {
      let that = this
      setTimeout(function () {
        EventBus.$emit(that.$actions.collapsedDrawer)
      }, 1000)
    }
  }
</script>

<style scoped>

</style>