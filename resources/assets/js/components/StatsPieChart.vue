<script>
    import {Pie, mixins} from 'vue-chartjs'
    const {reactiveProp} = mixins;
    export default {
        extends: Pie,
        name: 'stats-pie-chart',
        mixins: [reactiveProp],
        props: {
            options: {
                type: Object,
                required: true,
            }
        },
        mounted () {
            // Overwriting base render method with actual data.
            this.renderChart(this.chartData, this.options)
        }
    }
</script>

<style scoped>

</style>