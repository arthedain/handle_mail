<template>
    <div>
        <heading class="mb-6">{{__('Handle Mail')}}</heading>
        <div class="flex">
            <card class="w-1/3 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <p>{{__('New today')}}</p>
                <p>{{ getTodayMails }}</p>
            </card>
            <card class="w-1/3 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <p>{{__('Per month')}}</p>
                <p>{{ getMailForMonth }}</p>
            </card>
            <card class="w-1/3 flex flex-col items-center justify-center m-2" v-if="failedMails === 0" style="min-height: 100px">
                <h4>{{__('Failed')}}</h4>
                <p>{{ failedMails }}</p>
            </card>
            <router-link :to="{name: 'handle-mail-failed'}" class="w-1/3 card flex flex-col items-center justify-center m-2  failed-card link" v-if="failedMails > 0" style="min-height: 100px">
                    <h4>{{__('Failed')}}</h4>
                    <p>{{ failedMails }}</p>
            </router-link>
        </div>
        <card class="flex flex-col m-2">
            <ve-line :data="chartData" :colors="colors"></ve-line>
        </card>
        <div class="flex mb-6 mt-4">
            <heading class="">{{__('Mails')}}</heading>
            <button @click="deleteOption" :class="['btn btn-default mr-2', isDelete? 'btn-danger' : 'btn-teal']" style="margin-left: auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current mt-1"><path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
            </button>
        </div>
        <div class="chat-card-block m-2">
<!--            <div class="relative z-50 w-full max-w-xs mb-4">-->
<!--                <div class="relative">-->
<!--                    <div class="relative h-9 flex-no-shrink mb-6">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="search" role="presentation" class="fill-current absolute search-icon-center ml-3 text-80"><path fill-rule="nonzero" d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg>-->
<!--                        <input type="search" placeholder="Нажмите / для поиска" class="appearance-none form-search w-search pl-search shadow mail-search">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="preloader_main" v-if="loading">-->
<!--                <preloader></preloader>-->
<!--            </div>-->
            <card class="w-full" v-if="loading">
                <preloader></preloader>
            </card>
            <div v-if="!loading">
                <card class="w-full" v-if="mails.length > 0">

                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th class="w-8">
                                &nbsp;
                            </th>
                            <th class="text-left">ID</th>
                            <th class="text-left">{{ __('Name') }}</th>
                            <th class="text-left">{{ __('Email') }}</th>
                            <th class="text-left">{{ __('Status') }}</th>
                            <th class="text-left"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="mail in mails" :key="mail.id" style="min-height: 100px">
                            <td></td>
                            <td class="w-20 align-middle">
                                {{ mail.id }}
                            </td>
                            <td>{{ mail.name || '-'}}</td>
                            <td>{{ mail.email  || '-'}}</td>
                            <td>
                                <svg v-if="mail.status === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-success"><path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"></path></svg>
                                <svg v-if="mail.status === 'process'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  class="fill-current text-warning"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/></svg>
                                <svg v-if="mail.status === 'error'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  class="fill-current text-danger"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                            </td>
                            <td class="td-fit text-right pr-6 align-middle">

                                <router-link :to="{name: 'handle-mail-single', params: {id:mail.id}}" class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current"><path d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                                </router-link>
                                <button @click="deleteMail(mail.id)" v-if="isDelete" class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current"><path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="bg-20 rounded-b" per-page="25" resource-count-label="1-25 из 59" current-resource-count="25" all-matching-resource-count="59">
                        <nav class="flex justify-between items-center">
                            <button :disabled="!pagination.prev_page_url" @click="fetchStories(pagination.prev_page_url)" rel="prev" dusk="previous" class="btn btn-link py-3 px-4 teal dim">
                                {{__('Previous')}}
                            </button>
                            <span class="text-sm text-80 px-4">
                                    {{ pagination.from }} - {{pagination.to}} {{ __('of') }} {{ pagination.total }}
                                </span>
                            <button rel="next" dusk="next" @click="fetchStories(pagination.next_page_url)" :disabled="!pagination.next_page_url" class="btn btn-link py-3 px-4 teal dim">
                                {{__('Next')}}
                            </button>
                        </nav>
                    </div>
                </card>
                <card class="w-full flex flex-col items-center justify-center" style="min-height: 400px" v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="80" height="80"><path fill="#A8B9C5" class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/></svg>
                    <heading class="mt-2">{{__("The list is empty")}}</heading>
                </card>
            </div>
        </div>
    </div>
</template>

<script>
import VeLine from 'v-charts/lib/line.common'
import Preloader from './templates/Preloader'

export default {
    components: {
        VeLine,
        Preloader,
    },
    data() {
        return {
            test: [],
            chartData: {
                columns: ['date', 'mails', 'failed'],
                rows: [
                ]
            },
            colors: ['#1be9bf', '#c23531'],
            failedMails: 0,
            mails: [],
            pagination: {},
            modalOpen: false,
            isDelete: false,
            loading: true,
        }
    },
    mounted() {
        axios.get('/nova-vendor/handle-mail/chart').then((response)=>{
            this.chartData.rows = response.data;
        });
        axios.get('/nova-vendor/handle-mail/failed_count').then((response) => {
            this.failedMails = response.data;
        });
        this.getMails();
    },
    methods: {
        getMails() {
            axios.get('/nova-vendor/handle-mail/mails').then((response)=>{
                this.makePagination(response.data);
                this.mails = response.data.data;
                this.loading = false;
            });
        },
        fetchStories: function (page_url) {
            this.loading = true;
            let vm = this;
            page_url = page_url || '/nova-vendor/handle-mail/mails'
            axios.get(page_url).then((response)=>{
                vm.makePagination(response.data);
                vm.mails = response.data.data;
                this.loading = false;
            });
        },
        makePagination: function(data){
            let p = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url,
                total: data.total,
                from: data.from,
                to: data.to,
            }
            this.pagination = p;
        },
        openModal() {
            this.modalOpen = true;
        },
        confirmModal() {
            this.modalOpen = false;
        },
        closeModal() {
            this.modalOpen = false;
        },
        deleteOption(){
            this.isDelete = !this.isDelete;
        },
        deleteMail(id) {
            this.loading = true;
            axios.post('/nova-vendor/handle-mail/delete/'+id).then((response) => {
                this.$toasted.show(this.__("Email deleted successfully"), {
                    type: "success"
                });
                this.getMails();
            }).catch((error) => {
                this.$toasted.show(this.__("Error"), { type: "error" });
                this.loading = false;
            });
        },
    },
    computed: {
        getMailForMonth(){
            // let data = this.mails.filter(function(item){
            //     let date = moment(item.created_at).format('ll');
            //     return moment(date).isSameOrAfter(moment().subtract(30, 'days').format('D MMMM'));
            // });
            let count = 0;
            for(var item in this.chartData.rows){
                count += this.chartData.rows[item].mails;
            }

            return count;
        },
        getTodayMails(){
            let data = this.mails.filter(function(item){
                let date = moment(item.created_at).format('ll');
                return moment(date).isSame(moment().format('ll'));
            });
            return data.length;
        },
        getAllTimeMails(){
            return this.mails.length;
        },

    }
}
</script>

<style>
/* Scoped Styles */
</style>
