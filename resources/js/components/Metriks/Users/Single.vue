<template>
	<div>
		<div class="flex mb-6">
            <a class="cursor-pointer" @click="$router.go(-1)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#38b2ac" class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
                </svg>
            </a>
			<p class="text-2xl ml-2 mr-2">/</p>
			<router-link :to="{ name: 'handle-mail' }" class="breadcrumb">
				<h3 class="text-90 font-normal mt-1 breadcrumb">
					{{ __("Mails") }}
				</h3>
			</router-link>
			<p class="text-2xl ml-2 mr-2">/</p>
			<router-link
				:to="{ name: 'handle-mail-metrika-index' }"
				class="breadcrumb"
			>
				<h3 class="text-90 font-normal mt-1 breadcrumb">
					{{ __("Metrika") }}
				</h3>
			</router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
			<router-link
				:to="{ name: 'handle-mail-metrika-users' }"
				class="breadcrumb"
			>
				<h3 class="text-90 font-normal mt-1 breadcrumb">
					{{ __("Users") }}
				</h3>
			</router-link>
			<p class="text-2xl ml-2 mr-2">/</p>
			<heading class="">
				{{ ip }}
			</heading>
		</div>
        <card class="m-2 p-6" v-for="(item, key) of user" :key="key">
            <div v-for="(value, k) in item" :key="k" v-if="value && k !== 'ip_info' && k !== 'updated_at'">
                <history v-if="k === 'history'" :data="value"></history>
                <div class="flex border-b border-40" v-if="k !== 'history'">
                    <div class="w-1/4 py-4">
                        <h4 class="font-normal text-80">
                            {{ __(k) }}
                        </h4>
                    </div>
                    <div class="w-3/4 py-4 break-words" v-if="typeof value != 'object'">
                        <p class="text-90" v-if="k == 'status'">
                            <svg v-if="value === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" class="fill-current text-success">
                                <path
                                    d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"></path>
                            </svg>
                            <svg v-if="value === 'process'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" class="fill-current text-warning">
                                <path class="heroicon-ui"
                                      d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/>
                            </svg>
                            <svg v-if="value === 'error'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" class="fill-current text-danger">
                                <path class="heroicon-ui"
                                      d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/>
                            </svg>
                        </p>
                        <p v-else-if="k == 'spam'">
                            <!-- <span class="dot">{{ value == '1' ? 'Spam' : 'Not spam' }}</span> -->
                            <svg v-if="value === '0'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" class="fill-current text-success">
                                <path
                                    d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"></path>
                            </svg>
                            <svg v-if="value === '1'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" class="fill-current text-danger">
                                <path class="heroicon-ui"
                                      d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/>
                            </svg>
                        </p>
                        <p v-else>
                            {{ value }}
                        </p>
                    </div>
                </div>
            </div>
        </card>
	</div>
</template>

<script>
import history from "../../templates/SingleMail/History"

export default {
    props: ["ip"],
    components: {
        history
    },
    data(){
        return {
            prevRoute: null
        }
    },
	async mounted() {
		await this.$store.dispatch("fetchUser", this.ip);
	},
	methods: {},
	computed: {
		user() {
            return this.$store.getters.getUser;
		},
	}
};
</script>

<style>

</style>
