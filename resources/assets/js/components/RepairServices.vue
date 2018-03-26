<template>
    <service-requests type="repair"></service-requests>
</template>

<script>
  import ServiceRequests from './ServiceRequests'
  import Base from './Base.vue'

  export default {
    extends: Base,
    components: {ServiceRequests},
    name: 'repair-services'
  }
</script>

<style scoped>

</style>