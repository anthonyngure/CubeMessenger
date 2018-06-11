<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="deliveries"
                  :manager="manager"/>
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
      }
    }

  }
</script>

<style scoped>

</style>