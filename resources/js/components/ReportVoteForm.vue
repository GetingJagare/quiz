<template>
    <div style="margin: 0 auto;" class="vote-form">
        <img src="/img/mog_0529_logo.png" class="vote-form__logo" />

        <div v-if="report">
            <div v-if="report.status === 1">
                <h1>Выступление участника {{ report.reporter }}</h1>
                <h3>Доклад "{{ report.name }}"</h3>
            </div>

            <div v-if="report.status === 2">
                <h1>Пожалуйста, поставьте свою оценку докладу</h1>
                <h3>"{{ report.name }}"</h3>
                <vue-countdown :time="voteTime" class="vote-form__countdown" :auto-start="countDownAutostart">
                    <template slot-scope="props" class="vote-form__countdown-time">
                        Осталось {{ props.seconds }} секунд до окончания голосования
                    </template>
                </vue-countdown>
                <form method="POST" class="vote-form__form">
                    <div class="alert alert-danger" v-if="voteStatus === -1">
                        Вы проголосовали!
                    </div>
                    <div class="alert alert-success" v-if="voteStatus === 1">
                        Спасибо за вашу оценку!
                    </div>
                    <div v-if="voteStatus === 0">
                        <div class="form-group vote-form__button-wrapper" v-for="(btn, mark) in voteButtons" v-if="voteStatus === 0">
                            <button class="btn vote-form__button" :class="[btn.color]" @click.prevent="vote(mark);">
                                {{ btn.text }}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" :class="{'show': showDialog}"
                     :style="{display: showDialog ? 'block' : 'none'}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noveltyModalTitle">
                                    Подтвердите, пожалуйста, своё действие
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showDialog = false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                Вы выбрали оценку "{{ voteData.mark >= 0 ? voteButtons[voteData.mark].text : '' }}"
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" @click="sendData">Подтвердить</button>
                                <button type="button" class="btn btn-danger" @click="showDialog = false;">Отклонить</button>
                            </div>
                        </div>
                    </div>
                </div>

                <vue-loading :is-full-page="loadingFullPage" :active.sync="loading" background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>
            </div>

            <div v-if="report.status === 3">
                <vue-loading :is-full-page="loadingFullPage" :active.sync="loading" background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>

                <GChart type="ColumnChart" :options="chartData.options" :data="chartData.data" v-if="chartData.data.length"></GChart>
            </div>
        </div>
    </div>
</template>

<script>
    import VueLoading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import axios from 'axios';

    import VueCountdown from '@chenfengyuan/vue-countdown';

    import { GChart } from 'vue-google-charts';

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('[name="csrf-token"]').content;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    export default {
        name: "ReportVoteForm",

        data () {
            return {
                countDownAutostart: false,
                report: null,
                voteStatus: 0,
                voteTime: 0,
                loading: false,
                loadingFullPage: true,
                showDialog: false,
                voteData: {
                    reportId: -1,
                    mark: -1
                },
                voteButtons: {
                    '1': {text: 'Принять идею', color: 'btn-success'},
                    '0.5': {text: 'Принять идею с условиями доработки', color: 'btn-warning'},
                    '0': {text: 'Отклонить идею', color: 'btn-danger'},
                },
                chartData: {
                    data: [],
                    options: {
                        chart: {
                            title: 'Результаты голосования'
                        }
                    }
                }
            }
        },

        components: {VueLoading, VueCountdown, GChart},

        mounted () {
            this.checkActiveReports();
        },

        methods: {
            vote (mark) {
                this.voteData.mark = +mark;

                this.showDialog = true;
            },

            sendData () {
                this.loading = true;

                axios.post('/mark', this.voteData)
                    .then(response => {
                        this.voteStatus = response.data.voteStatus;

                        this.showDialog = false;

                        this.loading = false;
                    });

            },

            checkActiveReports () {
                axios.get('/check-reports')
                    .then(response => {
                       this.report = response.data.report;
                       this.voteStatus = response.data.voteStatus;
                       this.voteTime = response.data.time;

                       setTimeout(this.checkActiveReports, 1000);
                    });
            },

            getResults () {
                this.loading = true;

                axios.get('/get-vote-results?id=' + this.report.id)
                    .then(response => {
                        this.chartData.data = response.data.results;

                        setTimeout(() => this.loading = false, 1500);
                    });
            }
        },
        watch: {
            'report.status': function (newValue) {
                if (newValue === 3) {
                    this.getResults();
                }
            },

            'report.name': function (reportName) {
                this.chartData.options.title = 'Результаты голосования по докладу "' + reportName + '"';
            },

            'report.id': function (newValue) {
                this.voteData.reportId = newValue;
            }
        }
    }
</script>

<style scoped>
    .vld-overlay.is-full-page {
        z-index: 2000;
    }
</style>