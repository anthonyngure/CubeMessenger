<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="deliveries"
                  :manager="manager"
                  :custom-view-dialog="true"
                  :creatable="false"/>
        </v-flex>
    </v-layout>
</template>

<script>
  import Crud from './Crud'
  import CrudBase from './CrudBase.vue'

  export default {
    name: 'Deliveries',
    extends: CrudBase,
    components: {Crud},
    methods: {
      initialize () {
        let that = this
        this.manager.deletable = (item) => {
          return false
        }
        this.manager.toValue = (header, item) => {
          if (header.value === 'from') {
            return item.originFormattedAddress ? item.originFormattedAddress : that.defaultValue
          }
          if (header.value === 'client') {
            return item.user && item.user.client ? item.user.client.name : that.defaultValue
          }
          if (header.value === 'riderId') {
            return item.rider ? item.rider.name : that.defaultValue
          }
          if (header.value === 'date') {
            return item.scheduleDate ? item.scheduleDate : that.defaultValue
          }
          if (header.value === 'time') {
            return item.scheduleTime ? item.scheduleTime : that.defaultValue
          }
          else {
            return item[header.value] ? item[header.value] : that.defaultValue
          }
        }
      }
    }

  }
</script>

<style scoped>

</style>