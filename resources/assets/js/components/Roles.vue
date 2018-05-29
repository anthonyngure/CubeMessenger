<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <crud resource="roles"
            :manager="manager" ></crud >
    </v-flex >
  </v-layout >
</template >

<script >
import Crud from './Crud'
import CrudBase from './CrudBase.vue'

export default {
  name: 'Clients',
  extends: CrudBase,
  components: {Crud},
  methods: {
    initialize () {
      let that = this
      this.manager.deletable = (item) => {
        return false
      }
    }
  }
  
}
</script >

<style scoped >

</style >