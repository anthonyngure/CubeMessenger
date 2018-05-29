<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <crud resource="topUps"
            :manager="manager" ></crud >
    </v-flex >
  </v-layout >
</template >

<script >

import Crud from './Crud.vue'
import CrudBase from './CrudBase.vue'

export default {
  name: 'TopUps',
  extends: CrudBase,
  components: {Crud},
  methods: {
    initialize () {
      let that = this
      this.manager.deletable = (item) => {
        return false
      }
      this.manager.editable = (item) => {
        return false
      }
      this.manager.toValue = (header, item) => {
        if (header.value === 'clientId') {
          return item.client ? item.client.name : that.defaultValue
        } else if (header.value === 'amount') {
          return item.amount ? that.$utils.formatMoney(item.amount) : that.defaultValue
        } else {
          return item[header.value] ? item[header.value] : that.defaultValue
        }
      }
    }
  }
}
</script >

<style scoped >

</style >