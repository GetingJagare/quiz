<template>
    <div>
        <table class="table table-bordered text-center tablesorter">
            <thead>
            <tr>
                <th class="align-middle" rowspan="3">
                    ФИО участника, наименование работы
                </th>
                <th class="align-middle" v-bind:colspan="viewersCount">
                    Зрители
                </th>
                <th class="align-middle" rowspan="3">
                    Средняя оценка зрителей
                </th>
            </tr>
            <tr>
                <td class="align-middle" v-for="viewer in viewers">
                    {{ viewer.name }}
                </td>
            </tr>
            <tr>
                <td class="align-middle" v-for="viewer in viewers">
                    {{ viewer.filial }}
                </td>
            </tr>
            </thead>
            <tbody>
                <tr v-for="report in reports">
                    <td class="align-middle">
                        {{ report.reporter }}<br><b>{{ report.name }}</b>
                    </td>

                    <td class="align-middle" v-for="viewer in viewers">
                        {{ viewer.marks && viewer.marks[report.id] ? viewer.marks[report.id] : '-' }}
                    </td>

                    <td class="align-middle">
                        {{ report.avgMark }}
                    </td>
                </tr>
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
        name: "ViewerResultPage",

        data() {
            return {
                loading: true,
                loadingFullPage: true,
                viewers: [],
                viewersCount: 0,
                reports: []
            }
        },

        mounted() {
            this.getViewers();
        },

        methods: {
            getViewers() {
                axios.get('/admin/results/get-viewer-results')
                    .then(response => {
                        this.viewers = response.data.viewers;
                        this.viewersCount = response.data.count;

                        this.getReports();
                    });
            },

            getReports() {
                axios.get('/admin/results/get-viewer-reports')
                    .then(response => {
                        this.reports = response.data.reports;

                        this.loading = false;
                    });
            }
        },

        components: {VueLoading}

    }
</script>

<style scoped>

</style>