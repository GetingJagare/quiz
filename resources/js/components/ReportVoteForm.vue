<template>
    <div class="vote-form">
        <img src="/img/mog_0529_logo.png" class="vote-form__logo"/>

        <div v-if="report">
            <div v-if="report.status == 1">
                <h1>Выступление участника {{ report.reporter }}</h1>
                <h3>Доклад "{{ report.name }}"</h3>
            </div>

            <div v-else="report.status == 2">
                <form method="POST" class="vote-form__form">
                    <div class="alert alert-success" v-if="voteStatus === 1" v-html="voteMessage"></div>
                    <div v-else>
                        <h1>Пожалуйста, поставьте свою оценку докладу</h1>
                        <h3>"{{ report.name }}"</h3>

                        <div v-if="userType <= 1">
                            <div class="form-group vote-form__button-wrapper" v-for="(label, name) in voteQuestions">
                                <div class="vote-form__button-title mb-2">{{ label }}</div>
                                <div class="d-flex justify-content-center">
                                <span class="vote-form__button text-center"
                                      v-for="num in [1, 2, 3, 4, 5]" @click="saveVote(name, num)"
                                      :class="{'active': voteData[name] === num}">
                                    {{ num }}
                                </span>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success" v-bind:disabled="!hasAllVotes"
                                        @click.prevent="sendData">
                                    Cохранить
                                </button>
                            </div>
                        </div>
                        <div v-else-if="userType == 2">
                            <div class="d-flex justify-content-center mb-4 mt-3">
                                <span class="vote-form__button text-center"
                                      v-for="num in [1, 2, 3, 4, 5]" @click="saveViewVote(num)"
                                      :class="{'active': voteViewResult === num}">
                                    {{ num }}
                                </span>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success" v-bind:disabled="voteViewResult < 1"
                                        @click.prevent="sendData">
                                    Cохранить
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <vue-loading :is-full-page="loadingFullPage" :active.sync="loading"
                             background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>
            </div>

            <!--<div v-if="report.status === 3">
                <vue-loading :is-full-page="loadingFullPage" :active.sync="loading"
                             background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>

                <GChart type="ColumnChart" :options="chartData.options" :data="chartData.data"
                        v-if="chartData.data.length"></GChart>
            </div>-->
        </div>
    </div>
</template>

<script>
    import VueLoading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import axios from 'axios';

    import {GChart} from 'vue-google-charts';

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('[name="csrf-token"]').content;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    export default {
        name: "ReportVoteForm",

        data() {
            return {
                userType: -1,
                report: null,
                voteStatus: 0,
                voteMessage: '',
                loading: false,
                loadingFullPage: true,
                showDialog: false,
                voteData: {
                    novelty: 0,
                    study: 0,
                    worth: 0,
                    representation: 0,
                    efficiency: 0
                },
                voteViewResult: -1,
                voteQuestions: {
                    novelty: 'Новизна',
                    study: 'Степень проработки',
                    worth: 'Практическая ценность и актуальность',
                    representation: 'Представление доклада',
                    efficiency: 'Экономическая эффективность',
                },
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

        components: {VueLoading, GChart},

        mounted() {
            this.checkActiveReports();
        },

        methods: {
            sendData() {
                this.loading = true;

                axios.post(
                    this.userType <= 1 ? '/markExpert' : '/mark',
                    this.userType <= 1 ? this.voteData : {mark: this.voteViewResult}
                ).then(response => {
                    this.voteStatus = response.data.voteStatus;
                    this.voteMessage = response.data.voteMessage;
                    this.loading = false;

                    this.resetVoteData();
                });

            },

            checkActiveReports() {
                axios.get('/check-reports')
                    .then(response => {
                        if (this.report && response.data.report && this.report.id != response.data.report.id) {
                            this.resetVoteData();
                        }

                        this.report = response.data.report;
                        this.voteStatus = response.data.voteStatus;
                        this.voteMessage = response.data.voteMessage;
                        this.userType = response.data.userType;

                        setTimeout(this.checkActiveReports, 1000);
                    })
                    .catch(() => {
                        setTimeout(this.checkActiveReports, 1000);
                    });
            },

            getResults() {
                this.loading = true;

                axios.get('/get-vote-results?id=' + this.report.id)
                    .then(response => {
                        this.chartData.data = response.data.results;
                        this.chartData.options.gridLines.count = response.data.linesCount;

                        setTimeout(() => this.loading = false, 1500);
                    });
            },
            saveVote(name, num) {
                this.voteData[name] = num;
            },
            saveViewVote(num) {
                this.voteViewResult = num;
            },
            resetVoteData() {
                if (this.userType <= 1) {
                    for (let name in this.voteData) {
                        this.voteData[name] = 0;
                    }
                } else {
                    this.voteViewResult = 0;
                }
            }
        },

        computed: {
            hasAllVotes() {
                for (let name in this.voteData) {
                    if (this.voteData[name] === 0) {
                        return false;
                    }
                }

                return true;
            }
        },

        watch: {
            'report.status': function (newValue) {
                /*if (newValue === 3) {
                    this.getResults();
                }*/
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