<template>
    <service-requests type="it"></service-requests>
</template>

<script>
  import ServiceRequests from './ServiceRequests'
  import Base from './Base.vue'

  export default {
    extends: Base,
    components: {ServiceRequests},
    name: 'it-services'
  }
</script>

<style scoped>

</style>