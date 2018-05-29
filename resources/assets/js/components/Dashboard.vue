<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <admin-dashboard v-if="isAdmin()" ></admin-dashboard >
      <client-dashboard v-else ></client-dashboard >
    </v-flex >
  </v-layout >
</template >

<script >
import Base from './Base.vue'
import ClientDashboard from './ClientDashboard'
import AdminDashboard from './AdminDashboard'

export default {
  name: 'dashboard',
  components: {AdminDashboard, ClientDashboard},
  extends: Base
  
}
</script >

<style scoped >

</style >