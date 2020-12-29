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
                    {{__('Visited Pages')}}
                </heading>

            </div>
        <card class="w-full" >
            <div class="flex">
                <div class="m-3">
                    <h2 class="mb-1">Pages Chart</h2>
                    <h5 class="">Shows from which pages the letters are sent</h5>
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
        async mounted(){
            await this.$store.dispatch('fetchMetrikaAllMails');
        },
        computed: {
            pagesData(){
                let data = this.$store.getters.getMetrikaAllMails;

                data = _.map(data, item => item.history);
                data = _.filter(data, item => item);

                let arr = [];
                
                _.forEach(data, item => {
                    _.forEach(item, i => {
                        arr.push(i);
                    })
                });

               arr = _.groupBy(arr, item => item);

               arr = _.map(arr, (item, key) => {
                   return {name:key, value: item.length};
                   })
               return  arr;
            },
            chartHeight(){
                return '500px';
            }
        },
        watch: {
            pagesData(){
                let chart = am4core.create("pagesChart", am4charts.XYChart);
                chart.data = this.pagesData;
                let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 30;

                categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
                if (target.dataItem && target.dataItem.index & 2 == 2) {
                    return dy + 25;
                }
                return dy;
                });

                let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                // Create series
                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "value";
                series.dataFields.categoryX = "name";
                series.name = "Visits";
                series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                series.columns.template.fillOpacity = .8;

                let columnTemplate = series.columns.template;
                columnTemplate.strokeWidth = 2;
                columnTemplate.strokeOpacity = 1;
            }
        }
    }
</script>

<style scoped>

</style>
