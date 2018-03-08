<template>
    <div>
        <v-progress-circular
                indeterminate
                v-bind:size="50"
                color="primary">
        </v-progress-circular>
    </div>
</template>
<style scoped>
    div {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<script>
    export default {
        name: 'Loader'
    }
</script>