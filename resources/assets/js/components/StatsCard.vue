<template>
    <v-flex xs12 sm6>
        <v-card>
            <v-toolbar dark flat dense color="primary">
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="">
                    <v-icon>refresh</v-icon>
                </v-btn>
                <v-menu bottom left offset-y>
                    <v-btn icon slot="activator">
                        <v-icon>more_vert</v-icon>
                    </v-btn>
                    <v-list dense>
                        <v-list-tile @click="">Refresh</v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar>
            <v-card-text>
                <stats-pie-chart :options="chartOptions" :chartData="chartData"></stats-pie-chart>
            </v-card-text>
        </v-card>
    </v-flex>
</template>

<script>
    import StatsPieChart from './StatsPieChart'

    export default {
        components: {StatsPieChart},
        name: 'stats-card',
        props: {
            title: {
                type: String,
                required: true
            },
            url: {
                type: String,
                required: false
            }
        },
        data () {
            return {
                chartData: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                        'October', 'November', 'December'],
                    datasets: [
                        {
                            label: 'GitHub Commits',
                            backgroundColor: '#f87979',
                            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
                        }
                    ]
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    //rotation: -Math.PI,
                    //cutoutPercentage: 30,
                    //circumference: Math.PI,
                    legend: {
                        position: 'top'
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    },
                    title: {
                        display: false,
                        text: 'Title here',
                        fontSize: 24
                    }
                },
            }
        }
    }
</script>

<style scoped>

</style>