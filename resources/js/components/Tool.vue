<template>
    <div>
        <heading class="mb-6">Handle Mail</heading>
        <div class="flex">
            <card class="w-1/3 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <p>new today</p>
                <p>{{ getTodayMails }}</p>
            </card>
            <card class="w-1/3 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <p>per month</p>
                <p>{{ getMailForMonth }}</p>
            </card>
            <card class="w-1/3 flex flex-col items-center justify-center m-2" v-if="failedMails === 0" style="min-height: 100px">
                <h4>Failed</h4>
                <p>{{ failedMails }}</p>
            </card>
            <router-link :to="{name: 'handle-mail-failed'}" class="w-1/3 card flex flex-col items-center justify-center m-2  failed-card link" v-if="failedMails > 0" style="min-height: 100px">
                    <h4>Failed</h4>
                    <p>{{ failedMails }}</p>
            </router-link>
        </div>
        <card class="flex flex-col m-2">
            <ve-line :data="chartData" :colors="colors"></ve-line>
        </card>
        <heading class="mb-6 mt-4">Mails</heading>
        <div class="chat-card-block m-2">
            <div class="relative z-50 w-full max-w-xs mb-4">
                <div class="relative">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="search" role="presentation" class="fill-current absolute search-icon-center ml-3 text-80"><path fill-rule="nonzero" d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg> <input dusk="global-search" type="search" placeholder="Нажмите / для поиска" class="pl-search w-full form-global-search mail-search">
                    </div>
                </div>
            </div>

            <card class="w-full" v-if="mails.length > 0">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th class="w-8">
                            &nbsp;
                        </th>
                        <th class="text-left">ID</th>
                        <th class="text-left">Имя</th>
                        <th class="text-left">Email</th>
                        <th class="text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="mail in mails" :key="mail.id" style="min-height: 100px">
                        <td></td>
                        <td class="w-20 align-middle">
                            {{ mail.id}}
                        </td>
                        <td>{{ mail.name }}</td>
                        <td>{{ mail.email }}</td>
                        <td class="td-fit text-right pr-6 align-middle">

                            <router-link :to="{name: 'handle-mail-single', params: {id:mail.id}}" class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip" data-testid="mails-items-0-view-button" dusk="164-view-button" data-original-title="null">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current"><path d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="bg-20 rounded-b" per-page="25" resource-count-label="1-25 из 59" current-resource-count="25" all-matching-resource-count="59">
                    <nav class="flex justify-between items-center">
                        <button :disabled="!pagination.prev_page_url" @click="fetchStories(pagination.prev_page_url)" rel="prev" dusk="previous" class="btn btn-link py-3 px-4 teal dim">
                            Предыдущий
                        </button>
                        <span class="text-sm text-80 px-4">
                                {{ pagination.from+'-'+pagination.to+' from '+pagination.total }}
                            </span>
                        <button rel="next" dusk="next" @click="fetchStories(pagination.next_page_url)" :disabled="!pagination.next_page_url" class="btn btn-link py-3 px-4 teal dim">
                            Следующий
                        </button>
                    </nav>
                </div>
            </card>
            <card class="w-full flex flex-col items-center justify-center" style="min-height: 400px" v-else>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="80" height="80"><path fill="#A8B9C5" class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/></svg>
                <heading class="mt-2">The list is empty</heading>
            </card>
        </div>
    </div>
</template>

<script>
import VeLine from 'v-charts/lib/line.common'
import Table from './Table'

export default {
    components: {
        VeLine,
        'table-mail': Table,
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
        }
    },
    mounted() {
        axios.get('/nova-vendor/handle-mail/chart').then((response)=>{
            this.chartData.rows = response.data;
        });
        axios.get('/nova-vendor/handle-mail/failed_count').then((response) => {
            this.failedMails = response.data;
        });
        axios.get('/nova-vendor/handle-mail/mails').then((response)=>{
            this.makePagination(response.data);
            this.mails = response.data.data;
        });
    },
    methods: {
        fetchStories: function (page_url) {
            let vm = this;
            page_url = page_url || '/nova-vendor/handle-mail/mails'
            axios.get(page_url).then((response)=>{
                vm.makePagination(response.data);
                vm.mails = response.data.data;
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
        }
    },
    computed: {
        getMailForMonth(){
            // let data = this.mails.filter(function(item){
            //     let date = moment(item.created_at).format('ll');
            //     return moment(date).isSameOrAfter(moment().subtract(30, 'days').format('D MMMM'));
            // });
            return this.chartData.rows.length;
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
    .teal{
        color: #38b2ac;
    }
    .teal-hover:hover{
        color: #38b2ac;
    }
    canvas{
        max-width: 1550px;
    }
    .ve-line{
        max-width: 1550px;
    }
    .failed-card{
        background-color: #F56565;
    }
    .failed-card:hover{
        background-color: #FC8181;
    }
    .link{
        position: relative;
        cursor: pointer;
        text-decoration: none;
        color: black;
    }
    .link:after{
        position: absolute;
        top: 5px;
        right: 5px;
        content: url('data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M19 6.41L8.7 16.71a1 1 0 1 1-1.4-1.42L17.58 5H14a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V6.41zM17 14a1 1 0 0 1 2 0v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2h5a1 1 0 0 1 0 2H5v12h12v-5z"/></svg>');
    }
    .mail-search{
        border: 1px solid var(--80);
    }
    .mail-search:focus{
        border: 2px solid #38b2ac;
    }
</style>
