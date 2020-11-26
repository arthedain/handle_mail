<template>
    <div>
        <heading class="mb-6">{{__('Handle Mail')}}</heading>
        <div class="flex">
            <card class="w-1/4 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <h4>{{__('New today')}}</h4>
                <p>{{ getTodayMails }}</p>
            </card>
            <card class="w-1/4 flex flex-col items-center justify-center m-2" style="min-height: 100px">
                <h4>{{__('Per month')}}</h4>
                <p>{{ getMailForMonth }}</p>
            </card>
            <card class="w-1/4 flex flex-col items-center justify-center m-2" v-if="failedMails === 0"
                  style="min-height: 100px">
                <h4>{{__('Failed')}}</h4>
                <p>{{ failedMails }}</p>
            </card>
            <router-link :to="{name: 'handle-mail-failed'}"
                         class="w-1/4 card flex flex-col items-center justify-center m-2  failed-card link"
                         v-if="failedMails > 0" style="min-height: 100px">
                <h4>{{__('Failed')}}</h4>
                <p>{{ failedMails }}</p>
            </router-link>
            <router-link :to="{name: 'handle-mail-metrika-index'}"
                         class="w-1/4 card flex flex-col items-center justify-center m-2 card-link link"
                         style="min-height: 100px">
                <h4>{{__('Location')}}</h4>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path class="heroicon-ui"
                              d="M5.64 16.36a9 9 0 1 1 12.72 0l-5.65 5.66a1 1 0 0 1-1.42 0l-5.65-5.66zm11.31-1.41a7 7 0 1 0-9.9 0L12 19.9l4.95-4.95zM12 14a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    </svg>
                </p>
            </router-link>
        </div>
        <card class="flex flex-col m-2">
            <div class="chart" ref="chartdiv">
            </div>
        </card>
        <div class="flex mb-6 mt-4">
            <heading class="">{{__('Mails')}}</heading>

        </div>
        <div class="chat-card-block m-2">
            <div class="flex">
                <div class="relative z-50 w-full max-w-xs mt-2 ml-2">
                    <div class="relative">
                        <div class="relative h-9 flex-no-shrink mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 aria-labelledby="search" role="presentation"
                                 class="fill-current absolute search-icon-center ml-3 text-80">
                                <path fill-rule="nonzero"
                                      d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                            <input type="search" @input="fetchMails" v-model="search" placeholder="Нажмите / для поиска"
                                   class="appearance-none form-search w-search pl-search shadow mail-search">
                        </div>
                    </div>
                </div>
                <div class="flex justify-center align-center" style="margin-left: auto">
                    <table-filter class="mb-2 mr-2" @change="fetchMails"/>
                    <button @click="deleteOption"
                            :class="['btn btn-default mr-2 mt-2 mb-2', isDelete? 'btn-danger' : 'bg-30']">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                             :class="['fill-current mt-1', isDelete? 'text-10' : 'text-80']">
                            <path
                                d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <card class="w-full" v-show="loading">
                <preloader></preloader>
            </card>
            <div v-show="!loading">
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
                            <td>{{ mail.email || '-'}}</td>
                            <td>
                                <svg v-if="mail.status === 'success'" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" class="fill-current text-success">
                                    <path
                                        d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"></path>
                                </svg>
                                <svg v-if="mail.status === 'process'" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" class="fill-current text-warning">
                                    <path class="heroicon-ui"
                                          d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/>
                                </svg>
                                <svg v-if="mail.status === 'error'" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" class="fill-current text-danger">
                                    <path class="heroicon-ui"
                                          d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/>
                                </svg>
                            </td>
                            <td class="td-fit text-right pr-6 align-middle">

                                <router-link :to="{name: 'handle-mail-single', params: {id:mail.id}}"
                                             class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                         class="fill-current">
                                        <path
                                            d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                    </svg>
                                </router-link>
                                <button @click="deleteMail(mail.id)" v-if="isDelete"
                                        class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                         class="fill-current">
                                        <path
                                            d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="bg-20 rounded-b" per-page="25" resource-count-label="1-25 из 59"
                         current-resource-count="25" all-matching-resource-count="59">
                        <nav class="flex justify-between items-center">
                            <button :disabled="!pagination.prev_page_url"
                                    @click="fetchStories(pagination.prev_page_url)" rel="prev" dusk="previous"
                                    class="btn btn-link py-3 px-4 teal dim">
                                {{__('Previous')}}
                            </button>
                            <span class="text-sm text-80 px-4">
                                    {{ pagination.from }} - {{pagination.to}} {{ __('of') }} {{ pagination.total }}
                                </span>
                            <button rel="next" dusk="next" @click="fetchStories(pagination.next_page_url)"
                                    :disabled="!pagination.next_page_url" class="btn btn-link py-3 px-4 teal dim">
                                {{__('Next')}}
                            </button>
                        </nav>
                    </div>
                </card>
                <card class="w-full flex flex-col items-center justify-center" style="min-height: 400px" v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="80" height="80">
                        <path fill="#A8B9C5" class="heroicon-ui"
                              d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/>
                    </svg>
                    <heading class="mt-2">{{__("The list is empty")}}</heading>
                </card>
            </div>
        </div>
    </div>
</template>

<script>
    import Preloader from './templates/Preloader'
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    import TableFilter from "./templates/TableFilter";

    am4core.useTheme(am4themes_animated);

    export default {
        components: {
            Preloader,
            TableFilter,
        },
        data() {
            return {
                isDelete: false,
                search: '',
                filter: [],
                page_url: false,
            }
        },
        async mounted() {
            await this.fetchMails();
            await this.$store.dispatch('fetchChart');
            await this.$store.dispatch('fetchFailedMails');
        },
        methods: {
            fetchMails(data = []) {
                this.filter = data;
                this.filter['search'] = this.search;
                this.$store.dispatch('fetchMails', {
                    page_url: null,
                    parameters: this.filter
                });
            },
            fetchStories: function (page_url) {
                this.page_url = page_url;
                this.$store.dispatch('fetchMails', {page_url: this.page_url, parameters: this.filter});
            },
            deleteOption() {
                this.isDelete = !this.isDelete;
            },
            deleteMail(id) {
                axios.post('/nova-vendor/handle-mail/delete/' + id).then((response) => {
                    this.$toasted.show(this.__("Email deleted successfully"), {
                        type: "success"
                    });
                    this.$store.dispatch('fetchMails');
                }).catch((error) => {
                    this.$toasted.show(this.__("Error"), {type: "error"});
                    this.$store.commit('updateLoading', false);
                });
            },
        },
        computed: {
            failedMails() {
                return this.$store.getters.getFailedMails;
            },
            chartMails() {
                return this.$store.getters.getChart;
            },
            mails() {
                const mails = this.$store.getters.getMails;
                // return mails.filter(item => {
                //     return item.name.toLowerCase().includes(this.search.toLowerCase())
                //         || item.email.toLowerCase().includes(this.search.toLowerCase());
                // });
                return mails;
            },
            loading() {
                return this.$store.getters.loading;
            },
            pagination() {
                return this.$store.getters.getPagination;
            },
            getMailForMonth() {
                let data = this.chartMails.filter(function (item) {
                    if (item.value !== 0) {
                        let date = moment(item.date).format('ll');
                        return moment(date).isSameOrAfter(moment().subtract(30, 'days').format('ll'));
                    } else {
                        return false;
                    }
                });

                let count = 0;
                for (let item in data) {
                    count += data[item].value;
                }

                return count;
            },
            getTodayMails() {
                let data = this.mails.filter(function (item) {
                    let date = moment(item.created_at).format('ll');
                    return moment(date).isSame(moment().format('ll'));
                });
                return data.length;
            },
            getAllTimeMails() {
                return this.mails.length;
            },
        },
        watch: {
            chartMails() {
                  let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);
                  chart.paddingRight = 20;
                  let data = this.chartMails.map((e) => {
                      e.date = new Date(e.date);
                      return e;
                  });
                  chart.data = data;

                  let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                  dateAxis.baseInterval = {
                      "timeUnit": "minute",
                      "count": 1
                  };
                  dateAxis.tooltipDateFormat = "d MMMM";

                  let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                  valueAxis.tooltip.disabled = true;
                  valueAxis.title.text = "Mails";

                  let series = chart.series.push(new am4charts.LineSeries());
                  series.dataFields.dateX = "date";
                  series.dataFields.valueY = "value";
                  series.tooltipText = "Mails: [bold]{valueY}[/]";
                  series.fillOpacity = 0.3;


                  chart.cursor = new am4charts.XYCursor();
                  chart.cursor.lineY.opacity = 0;
                  chart.scrollbarX = new am4charts.XYChartScrollbar();
                  chart.scrollbarX.series.push(series);


                  dateAxis.start = 0.8;
                  dateAxis.keepSelection = true;
              }
        },
    }
</script>

<style>
    /* Scoped Styles */
    .chart {
        width: 100%;
        height: 500px;
    }
</style>
