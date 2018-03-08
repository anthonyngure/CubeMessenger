<template>
    <v-navigation-drawer
            fixed
            clipped
            :mobile-break-point="0"
            permernent
            v-model="drawerOpen"
            app>
        <v-list>
            <v-list-tile avatar @click="" class="py-3">
                <v-list-tile-avatar>
                    <img :src="'/storage/'+$auth.user().avatar">
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>
                        <b>{{$auth.user().name}}</b>
                    </v-list-tile-title>
                    <v-list-tile-sub-title>
                        <b>{{$auth.user().email}}</b>
                    </v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
        <v-divider></v-divider>
        <v-list dense>
            <template v-for="(item,index) in items">
                <v-list-group v-if="item.children" v-model="item.model" :key="index" :prepend-icon="item.icon"
                              :append-icon="item.model ? 'keyboard_arrow_up' : 'keyboard_arrow_down'">
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ item.title }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile v-for="(child, i) in item.children" :key="i" :to="child.route">
                        <v-list-tile-action>
                            <v-icon>{{child.icon}}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ child.title }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>

                <v-list-tile v-else :to="item.route" :key="index">
                    <v-list-tile-action>
                        <v-icon>{{item.icon}}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{item.title}}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: 'dashboard-drawer',
        data () {
            return {
                drawerOpen: true,
                items: [
                    {icon: 'dashboard', title: 'Dashboard', route: 'dashboard'},
                    {icon: 'date_range', title: 'Subscriptions', route: 'subscriptions'},
                    {icon: 'date_range', title: 'Appointments', route: 'appointments'},
                    {icon: 'folder', title: 'Documents', route: 'documents'},
                    {icon: 'shopping_basket', title: 'Shopping', route: 'shopping'},
                    {icon: 'computer', title: 'IT', route: 'it'},
                    {icon: 'build', title: 'Repairs', route: 'repairs'},
                    {
                        icon: 'local_shipping',
                        title: 'Courier',
                        route: 'courier',
                        /*model: false,
                        children: [
                            {icon: 'add', title: 'Add Delivery', route: 'courier'},
                            {icon: 'history', title: 'Delivery History', route: 'deliveryHistory'}
                        ]*/
                    },
                    {icon: 'settings', title: 'Settings', route: 'settings'},
                ]
            }
        }
    }
</script>

<style scoped>

</style>