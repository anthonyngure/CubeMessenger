<template>
    <v-layout justify-center align-center>
        <v-progress-circular
                class="mt-4"
                indeterminate
                v-bind:size="50"
                color="primary">
        </v-progress-circular>
        <v-subheader class="mt-4">Coming soon...</v-subheader>
    </v-layout>
</template>

<script>
    import Base from './Base.vue';
    export default {
        extends: Base,
        name: 'coming-soon'
    }
</script>

<style scoped>

</style>