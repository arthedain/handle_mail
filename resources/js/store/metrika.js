export default {
    actions: {
        async fetchMetrikaMails({commit}, params = []) {
            commit('updateLoading', true);
            const {data} = await axios.get('/nova-vendor/handle-mail/get_map_data', {params: params});
            commit('updateMetrikaMails', data);
            commit('updateLoading', false);
        },
    },
    mutations: {
        updateMetrikaMails(state, data) {
            state.metrikaMails = data;
        },
    },
    state: {
        metrikaMails: [],
    },
    getters: {
        getMetrikaMails: state => state.metrikaMails,
    },
}
