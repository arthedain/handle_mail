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
                <router-link :to="{name: 'handle-mail-metrika-index'}" class="breadcrumb">
                    <h3 class="text-90 font-normal mt-1 breadcrumb ">
                        {{__('Metrika')}}
                    </h3>
                </router-link>
                <p class="text-2xl ml-2 mr-2">/</p>
                <heading class="">
                    {{__('Metrika Pages')}}
                </heading>

            </div>
        <card class="w-full" >
            <div class="flex">
                <div class="m-3">
                    <h2 class="mb-1">{{__('Pages Chart')}}</h2>
                    <h5 class="">{{__('Shows from which pages the letters are sent')}}</h5>
                </div>
            </div>
            <div id="pagesChart" :style="{'min-height': chartHeight}"></div>
        </card>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";

    am4core.useTheme(am4themes_animated);

    export default {
        name: "PagesChart",
        async mounted(){
            await this.$store.dispatch('fetchMetrikaAllMails');
        },
        computed: {
            pagesData(){
                let data = this.$store.getters.getMetrikaAllMails;
                data = _.map(data, item => {
                item.page = item.page.replace(/\?.*/, ''); // replace get params
                // item.page = item.page.replace(/^.*\/\/[^\/]+/, '').replace(/\?.*/, ''); // replace domain and get params
                    return item;
                });
                data = _.groupBy(data, 'page');
                data = _.map(data, (item, key) => {
                    return {
                        "page": key,
                        "count": item.length,
                    };
                });
                data = _.sortBy(data, 'count');
                return data;
            },
            chartHeight(){
                return (this.pagesData.length * 100) + 'px';
            }
        },
        watch: {
            pagesData(){
                let chart = am4core.create("pagesChart", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                chart.data = this.pagesData;
                chart.legend = new am4charts.Legend();
                let series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "count";
                series.dataFields.category = "page";
            }
        }
    }
</script>

<style scoped>

</style>
