require('./bootstrap');
require('tablesorter');

window.Vue = require('vue');

import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import axios from 'axios';

import ReportPage from './components/ReportPage';
import ViewerResultPage from './components/ViewerResultPage';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('[name="csrf-token"]').content;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = new Vue({
    el: '#app',

    data () {
        return {
            loading: false,
            loadingFullPage: true
        }
    },

    beforeMount() {
        $(".tablesorter").tablesorter();
    },

    methods: {
        setStatus (event, reportId, status) {
            let dropdownItem = event.target.closest('.dropdown-item');
            let dropdown = dropdownItem.closest('.dropdown');

            this.loading = true;

            axios.post('/admin/report/change-status/' + reportId, {id: reportId, status: status})
                .then(response => {
                    this.loading = false;

                    let activeItem = dropdown.querySelector('.dropdown-item.active');
                    if (activeItem) {
                        activeItem.classList.remove('active');
                    }
                    dropdownItem.classList.add('active');
                });
        }
    },

    components: {VueLoading, ReportPage, ViewerResultPage}
});