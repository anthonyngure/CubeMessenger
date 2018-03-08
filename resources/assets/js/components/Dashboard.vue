<template>
    <v-layout row wrap>
        <v-flex xs12 d-inline-flex wrap align-center>
            <v-btn color="primary">
                <v-icon class="mr-1">account_balance_wallet</v-icon>
                Balance KES 0.00
            </v-btn>
            <h3 class="title text-xs-center" style="text-transform: uppercase">{{$auth.user().client.name}} -
                <small class="accent--text" style="text-transform: lowercase">{{$auth.user().client.email}}</small>
            </h3>
        </v-flex>
        <v-flex xs12>
            <v-divider></v-divider>
        </v-flex>
        <stats-card title="Deliveries"></stats-card>
        <stats-card title="Documents"></stats-card>
    </v-layout>
</template>

<script>
    import Base from './Base.vue'
    import StatsCard from './StatsCard'

    export default {
        name: 'dashboard',
        extends: Base,
        components: {
            StatsCard,
        },

    }
</script>

<style scoped>

</style>