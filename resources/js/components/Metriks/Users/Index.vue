<template>
  <div>
      <div class="flex mb-6">
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
            <router-link :to="{name: 'handle-mail-metrika-index'}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Metrika')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                {{__('Users')}}
            </heading>
        </div>
        <card class="mt-3">
            <div class="flex justify-between">
                <div class="relative z-50 w-full max-w-xs mt-2 ml-2">
                    <div class="relative">
                        <div class="relative h-9 flex-no-shrink mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 aria-labelledby="search" role="presentation"
                                 class="fill-current absolute search-icon-center ml-3 text-80">
                                <path fill-rule="nonzero"
                                      d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                            <input type="search" v-model="search" placeholder="Нажмите / для поиска"
                                   class="appearance-none form-search w-search pl-search shadow mail-search">
                        </div>
                    </div>
                </div>
                <table-filter
                    class="mr-2"
                    @change="getMails"
                />
            </div>
            <table class="table w-full">
                <thead>
                <tr>
                    <th class="w-8">&nbsp;</th>
                    <th class="text-left px-4 py-2">IP</th>
                    <th class="text-left px-4 py-2">{{__("Messages sent")}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, key) in paginatedData" :key="key">
                    <td></td>
                    <td class="px-4 py-2">{{ item.ip }}</td>
                    <td class="px-4 py-2">{{ item.value.length }}</td>
                    <td class="td-fit text-right pr-6 align-middle">
                        <router-link :to="{name: 'handle-mail-metrika-users-single', params: {ip:item.ip}}"
                                     class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                 class="fill-current">
                                <path
                                    d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                            </svg>
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="bg-20 rounded-b" per-page="25" resource-count-label="1-25 из 59" current-resource-count="25"
                 all-matching-resource-count="59">
                <nav class="flex justify-between items-center">
                    <button :disabled="pageNumber==0" @click="previousPage" rel="prev" dusk="previous"
                            class="btn btn-link py-3 px-4 teal dim">
                        {{__('Previous')}}
                    </button>
                    <span class="text-sm text-80 px-4">
                            {{ __('total') }} {{ data.length }}
                        <!--                        {{ pageNumber === 0 ? 1 : paginationFrom() }} - {{ paginationTo() <= paginatedData.length ? paginationTo() : data.length }} {{ __('of') }} {{ data.length }}-->
                    </span>
                    <button rel="next" dusk="next" @click="nextPage" :disabled="pageNumber >= pageCount() -1"
                            class="btn btn-link py-3 px-4 teal dim">
                        {{__('Next')}}
                    </button>
                </nav>
            </div>
        </card>
  </div>
</template>

<script>
import TableFilter from "../../templates/TableFilter"

export default {
    name: "Users",
    components: {
        TableFilter,
    },
    async mounted() {
        await this.getMails();
    },
    data() {
        return {
            pageNumber: 0,
            size: 20,
            search: '',
            chart: null,
        }
    },
    methods: {
        getMails(params = []) {
            this.$store.dispatch('fetchUsersMails', params);
        },
        nextPage() {
            this.pageNumber++;
        },
        previousPage() {
            this.pageNumber--;
        },
        pageCount() {
            let l = this.data.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginationFrom() {
            return this.pageNumber * this.size;
        },
        paginationTo() {
            return (this.pageNumber * this.size) + this.size;
        }
    },
    computed: {
        data() {
            let arr = [];
            let data = this.$store.getters.getUserMails;

            data = _.filter(data, item => item.ip.includes(this.search));

            data = _.groupBy(data, item => item.ip);

            _.map(data, (item, key) => {
                arr.push({
                    ip: key,
                    value:item
                });
            })

            return arr;
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;

            return _.slice(this.data, start, end);
        },
    }
}
</script>

<style>

</style>