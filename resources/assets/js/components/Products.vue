<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="products"
                  :manager="manager"/>
        </v-flex>
    </v-layout>
</template>

<script>
  import Crud from './Crud'
  import CrudBase from './CrudBase.vue'

  export default {
    name: 'Products',
    extends: CrudBase,
    components: {Crud},
    methods: {
      initialize () {
        let that = this
        this.manager.toValue = (header, item) => {
          if (header.value === 'price') {
            return item.price ? that.$utils.formatMoney(item.price) : that.defaultValue
          } else if (header.value === 'supplierId') {
            return item.supplier ? item.supplier.name : that.defaultValue
          } else {
            return item[header.value] ? item[header.value] : that.defaultValue
          }
        }
      }
    }

  }
</script>

<style scoped>

</style>