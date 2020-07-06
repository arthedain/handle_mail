<template>
    <div>
        <div class="flex mb-6">
            <router-link :to="{name: 'handle-mail'}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#38b2ac" class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
                </svg>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                 Mail
            </heading>
        </div>
        <card class="mb-6 py-3 px-6">
            <div class="flex border-b border-40" v-for="(value, key)  in mail" :key="key" v-if="value">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        {{ __(key) }}
                    </h4>
                </div>
                <div class="w-3/4 py-4 break-words" v-if="typeof value != 'object'">
                    <p class="text-90">
                        {{ value }}
                    </p>
                </div>
                <div class="w-3/4 py-4 break-words" v-if="typeof value == 'object'">
                    <div class="flex w-3/4 py-4 break-words border-b border-40" v-for="(item, k) in value">
                        <div class="w-1/4 py-4">
                            <h4 class="font-normal text-80">
                                {{ __(k) }}
                            </h4>
                        </div>
                        <div class="w-3/4 py-4 break-words">
                            <p class="text-90">
                                {{ item }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
    export default {
        name: "SingleMail",
        props: ['id'],
        data(){
            return{
                mail: [],
            }
        },
        mounted() {
            axios.get('/nova-vendor/handle-mail/single/'+this.id, ).then((response)=>{
                this.mail = response.data;
            });
        }
    }
</script>

<style>

</style>
