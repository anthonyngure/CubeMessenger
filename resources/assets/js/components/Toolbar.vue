<template>
    <v-toolbar color="primary" fixed dense dark app flat clipped-left>
        <v-toolbar-side-icon></v-toolbar-side-icon>
        <v-avatar size="36px" v-if="$auth.check() && $auth.user().client">
            <img :src="'/storage/'+$auth.user().client.logo" alt="Logo">
        </v-avatar>
        <v-toolbar-title>
            <span>{{$auth.check() && $auth.user().client ? $auth.user().client.name : $appName}}</span>
        </v-toolbar-title>
        <!--<v-toolbar-items v-if="$auth.check() && $auth.user().client">
            <v-btn flat to="dashboard">Dashboard</v-btn>
            <v-btn flat to="courier">Courier</v-btn>
            <v-btn flat to="shopping">Shopping</v-btn>
            <v-btn flat to="appointments">Appointments</v-btn>
            <v-btn flat to="documents">Documents</v-btn>
        </v-toolbar-items>-->
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$auth.check()">
            <v-menu origin="center center"
                    transition="scale-transition"
                    bottom
                    left
                    min-width="200px"
                    open-on-hover
                    offset-y>
                <v-btn flat slot="activator">
                    <span>Account</span>
                    <v-icon>arrow_drop_down</v-icon>
                </v-btn>
                <v-list dense>
                    <!--<v-list-tile v-if="$auth.user().client" to="invoices">Invoices</v-list-tile>
                    <v-list-tile v-if="$auth.user().client" to="settings">Settings</v-list-tile>
                    <v-list-tile v-if="$auth.user().client" to="/">Add User</v-list-tile>-->
                    <v-list-tile @click="signOut">Sign Out</v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar-items>
        <v-toolbar-items v-else>
            <v-btn to="signIn" flat>Sign In</v-btn>
        </v-toolbar-items>
        <v-btn icon>
            <v-icon>more_vert</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>

    export default {
        name: 'toolbar',
        methods: {
            signOut () {
                this.$auth.logout({
                    success () {
                        console.log('SignOut success')
                        this.$vuetify.theme.primary = this.$utils.primaryColor
                        this.$vuetify.theme.accent = this.$utils.accentColor
                    },
                    error () {
                        console.log('SignOut failed')
                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>