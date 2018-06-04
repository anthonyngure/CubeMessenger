<template>
    <v-layout row
              wrap>
        <v-flex xs12>
            <crud resource="users"
                  :manager="manager"></crud>
        </v-flex>
    </v-layout>
</template>

<script>

  import Crud from './Crud.vue'
  import CrudBase from './CrudBase.vue'

  export default {
    name: 'AdminUsers',
    extends: CrudBase,
    components: {Crud},
    methods: {
      initialize () {
        let that = this
        this.manager.deletable = (item) => {
          return item.role.name !== 'ADMIN' && item.role.name !== 'OPERATIONS' && !item.email.startsWith('test')
        }
        this.manager.toValue = (header, item) => {
          if (header.value === 'roleId') {
            return item.role ? item.role.name : that.defaultValue
          } else if (header.value === 'clientId') {
            return item.client ? item.client.name : that.defaultValue
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