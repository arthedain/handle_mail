<!-- in V3.0 -->
<template>
    <div>
        <div class="flex">
            <router-link :to="{name: 'handle-mail'}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#38b2ac" class="heroicon-ui"
                          d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
                </svg>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <router-link :to="{name: 'handle-mail'}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Mails')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <router-link :to="{name: 'handle-mail-single', prop: {id}}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Mail')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                {{ __('Resend Mail') + ' #' + id}}
            </heading>
        </div>
        <div>
            <card class="w-full m-2">
                <div class="flex flex-row">
                    <div @click="changeTab(0)"
                         :class="['w-1/3 py-5 px-8 border-b-2 focus:outline-none tab cursor-pointer', tab === 0 ? 'text-grey-black font-bold border-teal': 'text-grey font-semibold border-40']">
                        <h4 class="m-4 text-center">Tab 1</h4>
                    </div>
                    <div @click="changeTab(1); getView()"
                         :class="['w-1/3 py-5 px-8 border-b-2 focus:outline-none tab cursor-pointer', tab === 1 ? 'text-grey-black font-bold border-teal': 'text-grey font-semibold border-40']">
                        <h4 class="m-4 text-center">Tab 2</h4>
                    </div>
                    <div @click="changeTab(2)"
                         :class="['w-1/3 py-5 px-8 border-b-2 focus:outline-none tab cursor-pointer', tab === 2 ? 'text-grey-black font-bold border-teal': 'text-grey font-semibold border-40']">
                        <h4 class="m-4 text-center">Tab 3</h4>
                    </div>
                </div>
                <div>
                    <div v-show="tab === 0">
                        <inputs :mailContent="mailContent"/>
                    </div>
                    <div v-show="tab === 1">
                        <div v-html="view"></div>
                    </div>
                    <div v-show="tab === 2">
                        <emails/>
                    </div>
                </div>
            </card>
        </div>
    </div>
</template>

<script>
    import Inputs from '../templates/ResendSingle/Inputs'
    import Emails from '../templates/ResendSingle/Emails'

    export default {
        name: "ResendSingle",
        props: ['id'],
        components: {
            Inputs,
            Emails
        },
        data() {
            return {
                mail: [],
                view: '',
                tab: 0,
                mailContent: [],
            }
        },
        mounted() {
            this.getMail();
        },
        methods: {
            getMail() {
                axios.get('/nova-vendor/handle-mail/single/' + this.id,).then((response) => {
                    const mails = [];

                    _.map(response.data.mail, (item, key) => {
                        if (typeof item === 'object') {
                            _.map(item, (i, k) => {
                                mails.push({key: k, value: i});
                            });
                        } else {
                            mails.push({key: key, value: item});
                        }
                    })

                    this.mailContent = mails;
                    this.getView();
                });
            },
            getView() {
                const params = {};

                _.values(this.mailContent).map(item => {
                    _.set(params, item.key, item.value);
                });

                axios.get('/nova-vendor/handle-mail/view/single', {params: params}).then((response) => {
                    this.view = response.data.view;
                });
            },
            changeTab(tab) {
                this.tab = tab;
            },
        },
    }
</script>

<style scoped>

</style>
