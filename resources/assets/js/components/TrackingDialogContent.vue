<template>
    <v-card tile>
        <v-toolbar card dark color="primary">
            <v-btn icon @click.native="onClose">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Item Tracking</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn flat @click.native="onClose">Close</v-btn>
            </v-toolbar-items>
            <v-menu bottom right offset-y>
                <v-btn slot="activator" dark icon>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile @click="onClose">Close</v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
        <v-card-text :style="'max-height: '+($vuetify.breakpoint.height  - 100)+'px; ' +
                         'height: '+($vuetify.breakpoint.height  - 100)+'px'"
                     class="scroll-y pa-0 ma-0">
            <pick-pack-map style="width: 100%; height: 100%"></pick-pack-map>
        </v-card-text>
    </v-card>
</template>

<script>
    import PickPackMap from './PickPackMap'

    export default {
        components: {PickPackMap},
        name: 'tracking-dialog-content',
        props: {
            item: {
                required: true
            }
        },
        methods: {
            onClose () {
                this.$emit('onClose')
            }
        }
    }
</script>

<style scoped>

</style>