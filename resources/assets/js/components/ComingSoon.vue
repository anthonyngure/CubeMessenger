<template>
    <v-layout row wrap justify-center align-center>
        <v-flex xs12 sm3 class="text-xs-center">
            <h1 style="text-transform: uppercase">{{$route.name}}</h1>
            <v-progress-circular
                    class="ma-5"
                    indeterminate
                    v-bind:size="50"
                    color="primary">
            </v-progress-circular>
            <h4>Work In Progress...</h4>
        </v-flex>
    </v-layout>
</template>

<script>
  import Base from './Base.vue'

  export default {
    extends: Base,
    name: 'coming-soon'
  }
</script>

<style scoped>

</style>