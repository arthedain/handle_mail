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
                    {{__('Mails')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                {{__('Mail')}}
            </heading>
            <button @click="openModal" class="btn btn-default mr-2 btn-danger" style="margin-left: auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current mt-1"><path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
            </button>
            <modal
                v-if="modalOpen"
                @confirm="confirmModal"
                @close="closeModal"
                :method="remove"
                :title="modalTitle"
            />
        </div>
        <card class="w-full" v-if="loading">
            <preloader></preloader>
        </card>
        <card class="mb-6 py-3 px-6" v-if="!loading">
            <div class="flex border-b border-40" v-for="(value, key)  in mail" :key="key" v-if="value">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        {{ __(key) }}
                    </h4>
                </div>
                <div class="w-3/4 py-4 break-words" v-if="typeof value != 'object'">
                    <p class="text-90" v-if="key !== 'status'">
                        {{ value }}
                    </p>
                    <p v-else>
                        <svg v-if="value === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-success"><path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"></path></svg>
                        <svg v-if="value === 'process'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  class="fill-current text-warning"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/></svg>
                        <svg v-if="value === 'error'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  class="fill-current text-danger"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                    </p>
                </div>
                <div class="w-3/4 py-4 break-words" v-if="typeof value === 'object'">
                    <div class="flex w-3/4 py-4 break-words border-b border-40" v-for="(v, k) in value">
                        <div class="w-1/4 py-4">
                            <h4 class="font-normal text-80">
                                {{ __(k) }}
                            </h4>
                        </div>
                        <div class="w-3/4 py-4 break-words">
                            <p class="text-90">
                                {{ v }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </card>

    </div>
</template>

<script>
    import Modal from "./templates/Modal"
    import Preloader from './templates/Preloader'

    export default {
        name: "SingleMail",
        props: ['id'],
        components: {
            Modal,
            Preloader
        },
        data(){
            return{
                mail: [],
                modalOpen: false,
                modalTitle: 'LongTitle',
                loading: true,
            }
        },
        mounted() {
            axios.get('/nova-vendor/handle-mail/single/'+this.id, ).then((response)=>{
                this.mail = response.data;
                this.loading = false;
            });
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
            remove(){
                axios.post('/nova-vendor/handle-mail/delete/'+this.id).then((response) => {
                    this.$toasted.show(this.__("Email deleted successfully"), {
                        type: "success"
                    });
                    this.$router.push({name: 'handle-mail'});
                }).catch((error) => {
                    this.$toasted.show(this.__("Error"), { type: "error" });
                });
            }
        },
    }
</script>

<style>

</style>
