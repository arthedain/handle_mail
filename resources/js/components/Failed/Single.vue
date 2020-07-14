<template>
    <div>
        <modal
            v-if="modalOpen"
            @confirm="confirmModal"
            @close="closeModal"
            :method="resendMail"
            :title="modalTitle"
        />
        <div class="flex mb-6">
            <router-link :to="{name: 'handle-mail-failed'}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#38b2ac" class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
                </svg>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <router-link :to="{name: 'handle-mail'}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Handle Mail')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <router-link :to="{name: 'handle-mail-failed'}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Failed mails')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                {{__('Failed mail')}}
            </heading>
            <div class="flex justify-center" style="margin-left: auto">
                <button @click="resendMail" class="btn btn-default btn-teal">{{__('Send mail')}}</button>
                <button @click="openModal" class="btn btn-default mr-2 btn-danger ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current mt-1"><path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                </button>
            </div>
        </div>
        <card class="w-full" v-if="loading">
            <preloader></preloader>
        </card>
        <card class="mb-6 py-3 px-6" v-if="!loading">
            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        {{ __('id') }}
                    </h4>
                </div>
                <div class="w-3/4 py-4 break-words">
                    <p class="text-90">
                        {{ mail.id }}
                    </p>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-fill py-4 break-words">
                    <div v-html="view"></div>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/4 py-4 ">
                    <h4 class="font-normal text-80">
                        {{ __('failed_at') }}
                    </h4>
                </div>
                <div class="w-3/4 py-4 break-words">
                    <p class="text-90">
                        {{ mail.failed_at }}
                    </p>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        {{ __('exception') }}
                    </h4>
                </div>
                <div class="w-3/4 py-4 break-words">
                    <div class="leading-normal whitespace-pre-wrap" v-if="showText">
                        {{ mail.exception }}
                    </div>
                    <a aria-role="button" @click="toggleText()" :class="['cursor-pointer dim inline-block teal font-bold', showText ? 'mt-6' : '']">
                        {{ showText ? __('Hide Content') : __('Show Content') }}
                    </a>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
    import Modal from "../templates/Modal"
    import Preloader from '../templates/Preloader'

    export default {
        name: "Single",
        components: {
          Modal,
          Preloader
        },
        props: ['id'],
        data(){
            return {
                mail: [],
                content: [],
                view: '',
                modalOpen: false,
                textOpen: false,
                showText: false,
                modalTitle: 'Delete email',
                loading: true,
            }
        },
        mounted() {
            axios.get('/nova-vendor/handle-mail/failed_single/'+this.id).then((response)=>{
                this.mail = response.data.mail;
                this.content = response.data.content;
                this.view = response.data.view;
                this.loading = false;
            })
        },
        methods: {
            openModal() {
                this.modalOpen = true;
            },
            confirmModal() {
                this.modalOpen = false;
            },
            closeModal() {
                this.modalOpen = false;
            },
            toggleText() {
                this.showText = !this.showText;
            },
            resendMail() {
                axios.post('/nova-vendor/handle-mail/resend_mail', {'id':this.id}).then((response) => {
                    this.$toasted.show(this.__("Mail sent successfully"), {
                        type: "success"
                    });
                    this.$router.push({name:'handle-mail-failed'});
                }).catch((error) => {
                    this.$toasted.show(this.__("Error"), { type: "error" });
                });
            },
            deleteJob(){
                axios.post('/nova-vendor/handle-mail/delete_failed', {'id':this.id}).then((response) => {
                    this.$toasted.show(this.__("Mail deleted successfully"), {
                        type: "success"
                    });
                    this.$router.push({name:'handle-mail-failed'});
                }).catch((error) => {
                    this.$toasted.show(this.__("Error"), { type: "error" });
                });
            },



        }
    }
</script>

<style scoped>

</style>
