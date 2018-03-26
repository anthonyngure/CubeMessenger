<script>
  import EventBus from '../event-bus'

  export default {
    name: 'base',
    mounted () {
      setTimeout(function () {
        EventBus.$emit('collapseDrawer')
      }, 1000)
    }
  }
</script>

<style scoped>

</style>