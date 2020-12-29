export default {
    actions: {
        async fetchUser({commit}, ip) {
            const {data} = await axios.get('/nova-vendor/handle-mail/metrika/users/'+ip);
            commit('updateUser', data.user);
        },
        async fetchUsersMails({commit}, params = []) {
            const {data} = await axios.get('/nova-vendor/handle-mail/get_map_data', {params: params});
            commit('updateUserMails', data.mails);
        },
    },
    mutations: {
        updateUser(state, user) {
            _.forEach(user, item => {
                item.created_at = moment(item.created_at).format("DD-MM-YYYY HH:mm:ss")
            });

            state.user = user;
        },
        updateUserMails(state, data){
            state.userMails = data;
        }

    },
    state: {
        user: [],
        userMails: [],
    },
    getters: {
        getUser: state => state.user,
        getUserMails: state => state.userMails,
    },
}
