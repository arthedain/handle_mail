<template>
<div>
    <div class="flex mb-6">
        <router-link :to="{name: 'handle-mail'}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="#38b2ac" class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
            </svg>
        </router-link>
        <p class="text-2xl ml-2 mr-2">/</p>
        <router-link :to="{name: 'handle-mail'}" class="breadcrumb">
            <h3 class="text-90 font-normal mt-1 breadcrumb ">
                Handle mails
            </h3>
        </router-link>
        <p class="text-2xl ml-2 mr-2">/</p>
        <heading>
            Failed mails
        </heading>
        <button @click="openModal" class="btn btn-default btn-teal" style="margin-left: auto">Send all mail</button>
        <modal
            v-if="modalOpen"
            @confirm="confirmModal"
            @close="closeModal"
            :method="resendMail"
        />
    </div>
    <card class="w-full" v-if="mails.length > 0">
        <table class="table w-full">
            <thead>
            <tr>
                <th class="w-8">
                    &nbsp;
                </th>
                <th class="text-left">ID</th>
                <th class="text-left">Date</th>
                <th class="text-left"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="mail in mails" :key="mail.id" style="min-height: 100px">
                <td></td>
                <td class="w-20 align-middle">
                    {{ mail.id}}
                </td>
                <td>{{ mail.failed_at }}</td>
                <td class="td-fit text-right pr-6 align-middle">

                    <router-link :to="{name: 'handle-mail-failed-single', params: {id:mail.id}}" class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip" data-testid="mails-items-0-view-button" dusk="164-view-button" data-original-title="null">
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
    <card class="w-full flex flex-col items-center justify-center empty-list" style="min-height: 400px" v-else>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="80" height="80"><path fill="#A8B9C5" class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/></svg>
        <heading class="mt-2">The list is empty</heading>
    </card>
</div>
</template>

<script>
    import Modal from "../templates/Modal";
    export default {
        name: "List",
        components: {
            Modal,
        },
        data(){
            return {
                mails: [],
                pagination: {},
                modalOpen: false,
            }
        },
        mounted() {
            this.$forceUpdate();
            this.getMails();
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
            resendMail() {
                let vm = this;
                axios.post('/nova-vendor/handle-mail/resend_mail').then((response) => {
                    this.$toasted.show(this.__("Success"), {
                        type: "success"
                    });
                    this.getMails();
                }).catch(()=>{
                    this.$toasted.show(this.__("Error"), { type: "error" });
                });
            },
            getMails() {
                axios.get('/nova-vendor/handle-mail/failed_list').then((response) => {
                    this.mails = response.data.data;
                    this.pagination = response.data;
                });
            }
        },
    }
</script>

<style scoped>
    .teal{
        color: #38b2ac;
    }
    .teal-hover:hover{
        color: #38b2ac;
    }
    .breadcrumb{
        text-decoration: none;
    }
    .breadcrumb:hover{
        color: #38b2ac;
    }
    .btn-teal{
        background-color: #38b2ac;
        color: #ffffff;
    }
</style>
