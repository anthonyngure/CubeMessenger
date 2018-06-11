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
        this.manager.toValue = (header, item) => {
          if (header.value === 'from') {
            return item.originFormattedAddress ? item.originFormattedAddress : that.defaultValue
          }
          if (header.value === 'to') {
            return item.originFormattedAddress ? item.originFormattedAddress : that.defaultValue
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