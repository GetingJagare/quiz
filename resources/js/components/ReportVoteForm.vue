<template>
    <div style="margin: 0 auto;" class="vote-form">
        <h1>{{ report.name }}</h1>
        <h3>{{ report.reporter }}<br/>
            {{ report.position }}, {{ report.filial }}</h3>

        <form method="POST" class="vote-form__form">
            <div class="alert alert-danger" v-if="status === -1">
                Время голосования по этому докладу истекло!
            </div>

            <div class="alert alert-info" v-if="status === -2">
                Вы уже проголосовали
            </div>

            <div class="form-group vote-form__button-wrapper" v-for="(btn, mark) in voteButtons">
                <button class="btn vote-form__button" :class="[btn.color]" @click.prevent="vote(mark);">
                    {{ btn.text }}
                </button>
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
</template>

<script>
    import VueLoading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import axios from 'axios';

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('[name="csrf-token"]').content;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    export default {
        name: "ReportVoteForm",

        data () {
            return {
                status: 0,
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
                }
            }
        },

        props: ['report'],

        components: {VueLoading},

        beforeMount () {
            this.voteData.reportId = this.report.id;
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
                        this.status = response.data.status;

                        this.loading = false;

                        if (this.status === 1) {
                            window.location.reload();
                        }
                    })

            }
        }
    }
</script>

<style scoped>
    .vld-overlay.is-full-page {
        z-index: 2000;
    }
</style>