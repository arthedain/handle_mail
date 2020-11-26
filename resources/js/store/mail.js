export default {
    actions: {
        async fetchMails({commit, dispatch}, {page_url, parameters}) {
            commit('updateLoading', true);
            const page = page_url || '/nova-vendor/handle-mail/mails'

            const {data} = await axios.get(page, {params: parameters});

            commit('updatePagination', data.mails);
            commit('updateMails', data.mails.data);
            commit('updateLoading', false);
        },
        async fetchChart({commit}) {
            const {data} = await axios.get('/nova-vendor/handle-mail/chart');
            commit('updateChart', data.chart);
        },
        async fetchFailedMails({commit}) {
            const {data} = await axios.get('/nova-vendor/handle-mail/failed_count');
            commit('updateFailedMails', data.count);
        },
        // async deleteMail({commit, dispatch}, id) {
        //     commit('updateLoading', true);
        //     await axios.post('/nova-vendor/handle-mail/delete/' + id).then((response) => {
        //         this.$toasted.show(this.__("Email deleted successfully"), {
        //             type: "success"
        //         });
        //         dispatch('fetchMails');
        //     }).catch((error) => {
        //         this.$toasted.show(this.__("Error"), {type: "error"});
        //         commit('updateLoading', false);
        //     });
        // },
    },
    mutations: {
        updateMails(state, mails) {
            state.mails = mails;
        },
        updateLoading(state, status) {
            state.loading = status;
        },
        updateChart(state, chart) {
            state.chart = chart;
        },
        updateFailedMails(state, failedMails) {
            state.failedMails = failedMails;
        },
        updatePagination(state, data) {
            state.pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url,
                total: data.total,
                from: data.from,
                to: data.to,
            };
        },
    },
    state: {
        loading: true,
        mails: [],
        chart: [],
        failedMails: 0,
        pagination: {},
    },
    getters: {
        getMails: state => state.mails,
        loading: state => state.loading,
        getChart: state => state.chart,
        getFailedMails: state => state.failedMails,
        getPagination: state => state.pagination,
    },
}
