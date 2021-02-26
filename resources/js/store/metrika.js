export default {
    actions: {
        async fetchMetrikaMails({commit}, params = []) {
            commit('updateLoading', true);
            const {data} = await axios.get('/nova-vendor/handle-mail/get_map_data', {params: params});
            commit('updateMetrikaMails', data.mails);
            commit('updateLoading', false);
        },
        async fetchMetrikaAllMails({commit}) {
            const {data} = await axios.get('/nova-vendor/handle-mail/metrika/get_all');
            commit('updateMetrikaAllMails', data.mails);
        },
        async fetchMetrikaSpam({commit}, params = []) {
            const {data} = await axios.get('/nova-vendor/handle-mail/metrika/get_spam', {params: params});
            commit('updateMetrikaSpamMails', data.mails);
        }
    },
    mutations: {
        updateMetrikaMails(state, data) {
            data = _.map(data, item => {
                let arr = [];
                if(item.ip_info !== null) {
                    arr = item.ip_info;
                    _.assign(arr, {
                        "id": item.id,
                        "created_at": moment(item.created_at).format("DD-MM-YYYY HH:mm:ss"),
                    });
                    return arr;
                }
                return false;
            });

            state.metrikaMails = _.filter(data);
        },
        updateMetrikaSpamMails(state, mails) {
            mails = _.map(mails, item => {
                item.created_at = moment(item.created_at).format("DD-MM-YYYY HH:mm:ss");
                return item;
            });
            state.metrikaSpamMails = mails;
        },
        updateMetrikaAllMails(state, mails) {
            state.metrikaAllMails = mails;
        },
    },
    state: {
        metrikaAllMails: [],
        metrikaMails: [],
        metrikaSpamMails: [],
    },
    getters: {
        getMetrikaAllMails: state => state.metrikaAllMails,
        getMetrikaMails: state => state.metrikaMails,
        getMetrikaSpamMails: state => state.metrikaSpamMails,
    },
}
