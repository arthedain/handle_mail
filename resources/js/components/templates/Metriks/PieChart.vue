<template>
    <div>
        <div>
            <div class="flex">
                <div class="m-3">
                    <h2 class="mb-1">{{__('Countries')}}</h2>
                    <h5>{{__('Countries from which messages were sent')}}</h5>
                </div>
            </div>
            <div id="piechart"></div>
        </div>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";

    export default {
        name: "PieChart",
        props: ['pieMails'],
        watch: {
            pieMails(){
                let chart = am4core.create("piechart", am4charts.PieChart);
                chart.data = this.pieMails;
                let pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "count";
                pieSeries.dataFields.category = "country";
                pieSeries.slices.template.stroke = am4core.color("#fff");
                pieSeries.slices.template.strokeWidth = 2;
                pieSeries.slices.template.strokeOpacity = 1;

                pieSeries.hiddenState.properties.opacity = 1;
                pieSeries.hiddenState.properties.endAngle = -90;
                pieSeries.hiddenState.properties.startAngle = -90;
            }
        }
    }
</script>

<style scoped>
    #piechart{
        min-height: 400px;
    }
</style>
