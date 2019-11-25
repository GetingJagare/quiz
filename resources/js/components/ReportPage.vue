<template>
    <div>
        <vue-loading :is-full-page="loadingFullPage" :active.sync="loading" background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>

        <GChart type="ColumnChart" :options="chartData.options" :data="chartData.data" v-if="chartData.data.length"></GChart>
    </div>
</template>

<script>
    import VueLoading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import { GChart } from 'vue-google-charts';

    import axios from 'axios';

    export default {
        data () {
            return {
                loading: false,
                loadingFullPage: true,
                chartData: {
                    data: [],
                    options: {
                        height: 300,
                        legend: 'none',
                        chart: {
                            title: 'Результаты голосования'
                        },
                        gridLines: {}
                    }
                }
            }
        },

        props: ['id'],

        name: "ReportPage",

        mounted () {
            this.getResults();
        },

        methods: {
            getResults () {
                this.loading = true;

                axios.get('/get-vote-results?id=' + this.id)
                    .then(response => {
                        this.chartData.data = response.data.results;
                        this.chartData.options.gridLines.count = response.data.linesCount;

                        setTimeout(() => {this.loading = false; setTimeout(this.getResults, 5000)}, 1500);
                    });
            }
        },

        components: {VueLoading, GChart}
    }
</script>

<style scoped>

</style>