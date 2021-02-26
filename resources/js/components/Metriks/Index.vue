<template>
    <div>
        <div class="flex mb-6">
            <a class="cursor-pointer" @click="$router.go(-1)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#38b2ac" class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/>
                </svg>
            </a>
            <p class="text-2xl ml-2 mr-2">/</p>
            <router-link :to="{name: 'handle-mail'}" class="breadcrumb">
                <h3 class="text-90 font-normal mt-1 breadcrumb ">
                    {{__('Mails')}}
                </h3>
            </router-link>
            <p class="text-2xl ml-2 mr-2">/</p>
            <heading class="">
                {{__('Metrika')}}
            </heading>
        </div>
        <div class="flex">
            <div class="flex w-full mb-2" style="height: 500px">
                <div class="flex flex-wrap w-1/4 ml-0">
                    <card class="w-full m-2 ml-0 mt-0 flex flex-col items-center justify-center">
                        <h1>{{ todayMails }}</h1>
                        <h4>{{__('Today mails')}}</h4>
                    </card>
                    <card class="w-full m-2 ml-0 flex flex-col items-center justify-center">
                        <h1>{{ mailsPerMonth }}</h1>
                        <h4>{{__('Per month')}}</h4>
                    </card>
                </div>
                <div class="flex flex-wrap w-1/4 mr-2">
                    <card class="w-full m-2 p-4 mt-0 mr-0 flex flex-col items-center justify-center">
                        <h1>{{ allTimeMails }}</h1>
                        <h4>{{__('All time')}}</h4>
                    </card>
                    <card class="w-full p-2 m-2 mr-0 flex flex-col items-center justify-center">
                        <h1>{{ mediumPageView }}</h1>
                        <h4 class="w-3/4 text-center">{{__('Average number of pages before sending a letter')}}</h4>
                    </card>
                </div>
                <card class="w-1/2 ml-2 mb-2">
                    <pie-chart :pieMails="pieMails"></pie-chart>
                </card>
            </div>
            <!--            <router-link :to="{name: 'handle-mail-metrika-pages'}" class="card w-1/2 ml-2 mb-4">-->
            <!--                <bar-chart :barData="barMails"></bar-chart>-->
            <!--            </router-link>-->
        </div>
<!--        -->
<!--        -->
<!--        -->
        <div class="flex">
            <card class="w-1/2 flex flex-col mr-2">
                <div class="flex">
                    <div class="m-3">
                        <h2 class="mb-1">{{__('Map')}}</h2>
                        <h5 class="">{{__('Displays where emails were sent from')}}</h5>
                    </div>
                    <router-link :to="{name: 'handle-mail-metrika-map'}" class="m-3 ml-auto no-underline teal-link flex items-center">
                        <h3 class="text-black teal-link">{{__('View details')}}</h3>
                    </router-link>
                </div>
                <preloader v-show="loading" class="map"></preloader>
                <div id="chartdiv" v-show="!loading" class="map">
                </div>
            </card>
            <div class="flex flex-wrap w-1/4">
                <router-link :to="{name: 'handle-mail-failed'}" :class="['card w-full m-2 mt-0 flex flex-col items-center justify-center card-link link', failedMails > 0 ? 'failed-card' : '']">
                    <h3>{{__('Failed')}}</h3>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                            <path class="heroicon-ui" stroke="#22292f" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 9a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1zm0 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </p>
                </router-link>
               <router-link :to="{name: 'handle-mail-metrika-pages'}" class="card w-full m-2 mb-0 mt-0 flex flex-col items-center justify-center card-link link">

                   <h3>{{__('Pages')}}</h3>
                   <p>
                       <svg fill="none" viewBox="0 0 24 24" width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                           <path d="M11 3.05493C6.50005 3.55238 3 7.36745 3 12C3 16.9706 7.02944 21 12 21C16.6326 21 20.4476 17.5 20.9451 13H11V3.05493Z" stroke="#22292f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                           <path d="M20.4878 9H15V3.5123C17.5572 4.41613 19.5839 6.44285 20.4878 9Z" stroke="#22292f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                       </svg>
                   </p>
              </router-link>
            </div>
            <div class="flex flex-wrap w-1/4">
                <router-link :to="{name: 'handle-mail-metrika-spam'}" class="card w-full m-2 mt-0 mr-0 mb-0 flex flex-col items-center justify-center card-link link">
                    <h4>{{__('Spam')}}</h4>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                            <path fill="none" id="svg_1" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="#22292f" d="m18.364,18.364c3.5147,-3.5148 3.5147,-9.21324 0,-12.72796c-3.5148,-3.51472 -9.21324,-3.51472 -12.72796,0m12.72796,12.72796c-3.5148,3.5147 -9.21324,3.5147 -12.72796,0c-3.51472,-3.5148 -3.51472,-9.21324 0,-12.72796m12.72796,12.72796l-12.72796,-12.72796"/>
                        </svg>
                    </p>
                </router-link>
               <router-link :to="{name: 'handle-mail-metrika-users'}" class="card w-full m-2 mb-0 mr-0 flex flex-col items-center justify-center card-link link">
                   <h3>{{__('Users')}}</h3>
                   <p>
                       <svg fill="none" viewBox="0 0 24 24" width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                           <path d="M17 20H22V18C22 16.3431 20.6569 15 19 15C18.0444 15 17.1931 15.4468 16.6438 16.1429M17 20H7M17 20V18C17 17.3438 16.8736 16.717 16.6438 16.1429M7 20H2V18C2 16.3431 3.34315 15 5 15C5.95561 15 6.80686 15.4468 7.35625 16.1429M7 20V18C7 17.3438 7.12642 16.717 7.35625 16.1429M7.35625 16.1429C8.0935 14.301 9.89482 13 12 13C14.1052 13 15.9065 14.301 16.6438 16.1429M15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7ZM21 10C21 11.1046 20.1046 12 19 12C17.8954 12 17 11.1046 17 10C17 8.89543 17.8954 8 19 8C20.1046 8 21 8.89543 21 10ZM7 10C7 11.1046 6.10457 12 5 12C3.89543 12 3 11.1046 3 10C3 8.89543 3.89543 8 5 8C6.10457 8 7 8.89543 7 10Z" stroke="#22292f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                       </svg>
                   </p>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4maps from "@amcharts/amcharts4/maps";
    import am4geodata_worldHigh from "@amcharts/amcharts4-geodata/worldHigh";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    import Preloader from "../templates/Preloader";
    import TableFilter from "../templates/TableFilter";
    import PieChart from "../templates/Metriks/PieChart";
    import BarChart from "../templates/Metriks/BarChart";

    am4core.useTheme(am4themes_animated);

    export default {
        components: {
            TableFilter,
            Preloader,
            PieChart,
            BarChart,
        },
        data() {
            return {
                pageNumber: 0,
                size: 20,
                search: '',
                chart: null,
            }
        },
        async mounted() {
            await this.fetchData();
            await this.$store.dispatch('fetchMetrikaAllMails');
            await this.fetchMails();
            await this.$store.dispatch('fetchFailedMails');
        },

        methods: {
            fetchData() {
                this.$store.dispatch('fetchMetrikaMails');
            },
            fetchMails() {
                this.$store.dispatch('fetchMails', {page_url: false, parameters: []});
            }
        },

        computed: {
            failedMails() {
                return this.$store.getters.getFailedMails;
            },
            data() {
                return this.$store.getters.getMetrikaMails;
            },
            loading() {
                return this.$store.getters.loading;
            },
            pieMails() {
                let data = this.$store.getters.getMetrikaAllMails;
                data = _.groupBy(data, 'ip_info.countryName');
                data = _.map(data, (item, key) => {
                    return {
                        "country": key,
                        "count": item.length,
                    };
                })
                return data;
            },
            barMails() {
                let data = this.$store.getters.getMetrikaBarMails;
                if (data.length > 5) {
                    data = _.slice(data, 0, 5);
                }
                return data;
            },
            mails() {
                return this.$store.getters.getMails;
            },
            mailsPerMonth() {
                let data = _.filter(this.mails, item => {
                    let date = moment(item.created_at).format('ll');
                    return moment(date).isSameOrAfter(moment().subtract(30, 'days').format('ll'));
                });
                return data.length;
            },
            todayMails() {
                let data = this.mails.filter(function (item) {
                    let date = moment(item.created_at).format('ll');
                    return moment(date).isSame(moment().format('ll'));
                });
                return data.length;
            },
            allTimeMails() {
                return this.mails.length;
            },
            mediumPageView() {
                let data = [];
                let count = 0;
                _.forEach(this.mails, item => {
                    if(item.history) {
                        data.push(item.history.length);
                        count += item.history.length;
                    }
                });

                if(count > 0 && data.length > 0) {
                    return Math.round(count / data.length);
                }

                return 0;
            }
        },
        watch: {
            data() {
                let chart = am4core.create("chartdiv", am4maps.MapChart);

                // Set map definition
                chart.geodata = am4geodata_worldHigh;

                // Set projection
                chart.projection = new am4maps.projections.Miller();

                // Create map polygon series
                let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

                // Exclude Antartica
                polygonSeries.exclude = ["AQ"];

                // Make map load polygon (like country names) data from GeoJSON
                polygonSeries.useGeodata = true;

                // Configure series
                let polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}";
                polygonTemplate.polygon.fillOpacity = 0.6;


                // Create hover state and set alternative fill color
                let hs = polygonTemplate.states.create("hover");
                hs.properties.fill = chart.colors.getIndex(0);

                // Add image series
                let imageSeries = chart.series.push(new am4maps.MapImageSeries());
                imageSeries.mapImages.template.propertyFields.longitude = "longitude";
                imageSeries.mapImages.template.propertyFields.latitude = "latitude";
                imageSeries.mapImages.template.tooltipText = "{title}";
                imageSeries.mapImages.template.propertyFields.url = "url";


                let circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
                circle2.radius = .1;
                circle2.propertyFields.fill = "color";

                let colorSet = new am4core.ColorSet();

                let array = [];

                this.data.map((e) => {
                    let dot = {};
                    dot.title = e.cityName;
                    dot.latitude = parseFloat(e.latitude);
                    dot.longitude = parseFloat(e.longitude);
                    dot.color = colorSet.next()
                    array.push(dot);
                });
                imageSeries.data = array;
                this.chart = chart;
            }
        },

        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .map {
        width: 100%;
        height: 500px;
    }
</style>
