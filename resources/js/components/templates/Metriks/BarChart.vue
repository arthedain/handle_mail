<template>
    <div>
        <div id="barchart"></div>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    export default {
        name: "BarChart",
        props: ['barData'],
        watch: {
            barData(){
                let chart = am4core.create("barchart", am4charts.XYChart);
                chart.padding(40, 40, 40, 40);

                let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.dataFields.category = "page";
                categoryAxis.renderer.minGridDistance = 1;
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.disabled = true;

                let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;

                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.categoryY = "page";
                series.dataFields.valueX = "count";
                series.tooltipText = "{valueX.value}"
                series.columns.template.strokeOpacity = 0;
                series.columns.template.column.cornerRadiusBottomRight = 5;
                series.columns.template.column.cornerRadiusTopRight = 5;

                let labelBullet = series.bullets.push(new am4charts.LabelBullet())
                labelBullet.label.horizontalCenter = "left";
                labelBullet.label.dx = 10;
                labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}";
                labelBullet.locationX = 1;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
                series.columns.template.adapter.add("fill", function(fill, target){
                    return chart.colors.getIndex(target.dataItem.index);
                });

                categoryAxis.sortBySeries = series;
                chart.data = this.barData;
            },
        },
    }
</script>

<style scoped>
    #barchart{
        height: 400px;
    }
</style>
