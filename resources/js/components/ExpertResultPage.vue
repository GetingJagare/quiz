<template>
    <div>
        <table class="table table-bordered text-center tablesorter">
            <thead>
            <tr>
                <th class="align-middle" rowspan="3">
                    ФИО участника, наименование работы
                </th>
                <th class="align-middle" v-bind:colspan="comCount * 5">
                    Оценки конкурсной комиссии
                </th>
                <th class="align-middle" rowspan="3">
                    Средняя оценка конкурсной комиссии
                </th>
                <th class="align-middle" v-bind:colspan="expCount * 5">
                    Оценки экспертной комиссии
                </th>
                <th class="align-middle" rowspan="3">
                    Средняя оценка экспертов
                </th>
                <th class="align-middle" rowspan="3">
                    Средняя оценка конкурсной комиссии и экспертов
                </th>
            </tr>
            <tr>
                <th class="align-middle" v-for="expert in com" colspan="5">
                    {{ expert.name }}
                </th>
                <th class="align-middle" v-for="expert in exp" colspan="5">
                    {{ expert.name }}
                </th>
            </tr>
            <tr v-html="markTypeHtml"></tr>
            </thead>
            <tbody>
            <tr v-for="report in reports" v-html="getReportRowHtml(report)"></tr>
            </tbody>
        </table>

        <vue-loading :is-full-page="loadingFullPage" :active.sync="loading"
                     background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>
    </div>
</template>

<script>
    import VueLoading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import axios from 'axios';

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('[name="csrf-token"]').content;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    export default {
        name: "ExpertResultPage",

        data() {
            return {
                loading: true,
                loadingFullPage: true,
                exp: [],
                com: [],
                expCount: 0,
                comCount: 0,
                reports: [],
                markTypeHtml: ''
            }
        },

        mounted() {
            this.getExperts();
        },

        methods: {
            getExperts() {
                axios.get('/admin/results/get-expert-results')
                    .then(response => {
                        const experts = response.data.experts;

                        this.exp = experts.exp.experts ? experts.exp.experts : [];
                        this.com = experts.com.experts ? experts.com.experts : [];
                        this.expCount = experts.exp.count;
                        this.comCount = experts.com.count;

                        for (let i = 1; i <= this.comCount; i++) {
                            this.markTypeHtml += '<th class="align-middle">Новизна</th>' +
                                '<th class="align-middle">Степень проработки</th>' +
                                '<th class="align-middle">Практическая ценность и актуальность</th>' +
                                '<th class="align-middle">Представление доклада</th>' +
                                '<th class="align-middle">Экономическая эффективность</th>';
                        }

                        for (let j = 1; j <= this.expCount; j++) {
                            this.markTypeHtml += '<th class="align-middle">Новизна</th>' +
                                '<th class="align-middle">Степень проработки</th>' +
                                '<th class="align-middle">Практическая ценность и актуальность</th>' +
                                '<th class="align-middle">Представление доклада</th>' +
                                '<th class="align-middle">Экономическая эффективность</th>';
                        }

                        this.getReports();
                    });
            },

            getReports() {
                axios.get('/admin/results/get-expert-reports')
                    .then(response => {
                        this.reports = response.data.reports;

                        this.loading = false;
                    });
            },
            getMarksHtml(exp, reportId) {
                let markHtml = '';

                for (let id in exp) {
                    markHtml += '<td class="align-middle">' +
                        (exp[id]['marks'] && exp[id]['marks'][reportId] && exp[id]['marks'][reportId]['novelty']
                            ? exp[id]['marks'][reportId]['novelty'] : '-') +
                        '</td>' +
                        '<td class="align-middle">' +
                        (exp[id]['marks'] && exp[id]['marks'][reportId] && exp[id]['marks'][reportId]['novelty']
                            ? exp[id]['marks'][reportId]['study'] : '-') +
                        '</td>' +
                        '<td class="align-middle">' +
                        (exp[id]['marks'] && exp[id]['marks'][reportId] && exp[id]['marks'][reportId]['novelty']
                            ? exp[id]['marks'][reportId]['worth'] : '-') +
                        '</td>' +
                        '<td class="align-middle">' +
                        (exp[id]['marks'] && exp[id]['marks'][reportId] && exp[id]['marks'][reportId]['novelty']
                            ? exp[id]['marks'][reportId]['representation'] : '-') +
                        '</td>' +
                        '<td class="align-middle">' +
                        (exp[id]['marks'] && exp[id]['marks'][reportId] && exp[id]['marks'][reportId]['novelty']
                            ? exp[id]['marks'][reportId]['efficiency'] : '-') +
                        '</td>';
                }

                return markHtml;
            },

            getReportRowHtml(report) {
                return '<td class="align-middle">' + report.reporter + '<br><b>' + report.name + '</b>' +
                    this.getMarksHtml(this.com, report.id) +
                    '<td class="align-middle">' + (report.comAvgMark ? report.comAvgMark : '-') + '</td>' +
                    this.getMarksHtml(this.exp, report.id) +
                    '<td class="align-middle">' + (report.expAvgMark ? report.expAvgMark : '-') + '</td>' +
                    '<td class="align-middle">' + (report.avgMarkSum ? report.avgMarkSum : '-') + '</td>';
            }
        },

        components: {VueLoading}
    }
</script>

<style scoped>

</style>