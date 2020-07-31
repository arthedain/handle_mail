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
                {{__('Metrika')}}
            </heading>
        </div>
        <card class="w-full map">
            <preloader v-if="loading" class="map"></preloader>
            <div id="chartdiv" class="map">
            </div>
        </card>
        <div class="relative z-50 w-full max-w-xs mt-4 mb-2">
            <div class="relative">
                <div class="relative h-9 flex-no-shrink mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="search" role="presentation" class="fill-current absolute search-icon-center ml-3 text-80"><path fill-rule="nonzero" d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg>
                    <input type="search" v-model="search" placeholder="Нажмите / для поиска" class="appearance-none form-search w-search pl-search shadow mail-search">
                </div>
            </div>
        </div>
        <card class="mt-3" >
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="w-8">&nbsp;</th>
                        <th class="text-left px-4 py-2">IP</th>
                        <th class="text-left px-4 py-2">Country</th>
                        <th class="text-left px-4 py-2">Region</th>
                        <th class="text-left px-4 py-2">City</th>
                        <th class="text-left px-4 py-2">created_at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in paginatedData">
                        <td></td>
                        <td class="px-4 py-2">{{ item.ip }}</td>
                        <td class="px-4 py-2">{{ item.countryName }}</td>
                        <td class="px-4 py-2">{{ item.regionName }}</td>
                        <td class="px-4 py-2">{{ item.cityName }}</td>
                        <td class="px-4 py-2">{{ item.created_at }}</td>
                        <td class="td-fit text-right pr-6 align-middle">
                            <router-link :to="{name: 'handle-mail-single', params: {id:item.id}}" class="cursor-pointer text-70 teal-hover mr-3 inline-flex items-center has-tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current"><path d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="bg-20 rounded-b" per-page="25" resource-count-label="1-25 из 59" current-resource-count="25" all-matching-resource-count="59">
                <nav class="flex justify-between items-center">
                    <button :disabled="pageNumber==0" @click="previousPage" rel="prev" dusk="previous" class="btn btn-link py-3 px-4 teal dim">
                        {{__('Previous')}}
                    </button>
                    <span class="text-sm text-80 px-4">
<!--                        {{ pageNumber === 0 ? 1 : paginationFrom() }} - {{ paginationTo() <= paginatedData.length ? paginationTo() : data.length }} {{ __('of') }} {{ data.length }}-->
                    </span>
                    <button rel="next" dusk="next" @click="nextPage" :disabled="pageNumber >= pageCount() -1" class="btn btn-link py-3 px-4 teal dim">
                        {{__('Next')}}
                    </button>
                </nav>
            </div>
        </card>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4maps from "@amcharts/amcharts4/maps";
    import am4geodata_worldLow from "@amcharts/amcharts4-geodata/worldLow";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    import Preloader from "../templates/Preloader";

    am4core.useTheme(am4themes_animated);

    export default {
        components: {
            Preloader
        },
        data(){
            return {
                data: [],
                loading: true,
                pageNumber: 0,
                size: 20,
                search: '',
            }
        },
        mounted() {
            axios.get('/nova-vendor/handle-mail/get_map_data').then((response) => {
                this.loading = false;
                this.data = response.data;

                this.initMap();
            });

        },

        methods: {
            initMap(){
                let chart = am4core.create("chartdiv", am4maps.MapChart);

                // Set map definition
                chart.geodata = am4geodata_worldLow;

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
                circle2.radius = 2.5;
                circle2.propertyFields.fill = "color";

                let colorSet = new am4core.ColorSet();

                let array = [];

                this.data.map((e)=>{
                    let dot = {};
                    dot.title = e.cityName;
                    dot.latitude = parseFloat(e.latitude);
                    dot.longitude = parseFloat(e.longitude);
                    dot.color = colorSet.next()
                    array.push(dot);
                });
                imageSeries.data = array;

            },
            nextPage(){
                this.pageNumber++;
            },
            previousPage(){
                this.pageNumber--;
            },
            pageCount(){
                let l = this.data.length,
                    s = this.size;

                return Math.ceil(l/s);
            },
            paginationFrom(){
                return this.pageNumber * this.size;
            },
            paginationTo(){
                return (this.pageNumber * this.size) + this.size;
            }
        },

        computed: {
            paginatedData(){
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                return this.data.filter(item => {
                    return item.cityName.toLowerCase().includes(this.search.toLowerCase())
                        || item.countryName.toLowerCase().includes(this.search.toLowerCase());
                }).slice(start, end);
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
        height: 800px;
    }
</style>
