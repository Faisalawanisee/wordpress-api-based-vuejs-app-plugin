<template>
  <vue-highcharts
    type="chart"
    :options="chartOptions"
    :redrawOnUpdate="true"
    :oneToOneUpdate="false"
    :animateOnUpdate="true"
    @rendered="onRender"
  />
</template>
<script>
import { ref, computed } from "vue";
import VueHighcharts from "vue3-highcharts";
import StockCharts from "highcharts/modules/drilldown";
import StockCharts2 from "highcharts/modules/exporting";
import HighCharts from "highcharts";
StockCharts(HighCharts);
StockCharts2(HighCharts);

export default {
  name: "SimpleChart",

  components: {
    VueHighcharts,
  },

  data() {
    return {
      fe2: [
        {
          name: "Anuncio Facebook",
          y: 14000,
          drilldown: "Chrome",
        },
        {
          name: "Anuncio Instagram",
          y: 8000,
          drilldown: "Firefox",
        },
        {
          name: "Influencer X",
          y: 7345,
          drilldown: "Internet Explorer",
        },
        {
          name: "Influencer Y",
          y: 5558,
          drilldown: "Safari",
        },
        {
          name: "Influencer Z",
          y: 4020,
          drilldown: "Edge",
        },
        {
          name: "Twitter",
          y: 1920,
          drilldown: "Opera",
        },
        {
          name: "Outros",
          y: 7620,
          drilldown: null,
        },
      ],
      chart: {
        type: "column",
      },
      title: {
        text: "Links mais acessados BeBrasil",
      },
      subtitle: {
        text: "Clique nas colunas para ver mais detalhes",
      },
      accessibility: {
        announceNewData: {
          enabled: true,
        },
      },
      /*
      xAxis: {
        type: "category",
      },
      */
      xAxis: [
        {
          id: 0,
          type: "category",
        },
        {
          id: 1,
          type: "datetime",
          //categories: data.categories
        },
      ],
      yAxis: {
        title: {
          text: "Total de acessos",
        },
      },
      legend: {
        enabled: false,
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            //format: '{point.y:.1f}%'
          },
        },
      },

      tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        formatter: function () {
          var pcnt =
            (this.y /
              this.series.data.map((p) => p.y).reduce((a, b) => a + b, 0)) *
            100;
          return pcnt.toFixed(2) + "%";
        },
      },
      credits: {
        enabled: false,
      },
      series: [
        {
          name: "Browsers",
          colorByPoint: true,
          data: this.fe2,
        },
      ],
      drilldown: {
        series: [
          {
            name: "Anuncio Facebook",
            id: "Chrome",

            xAxis: 1,
            data: [
              [1619337600000, 20],
              [1619424000000, 30],
              [1619510400000, 40],
              [1619596800000, 50],
              [1619683200000, 60],
            ],
          },
          {
            name: "Anuncio Instagram",
            id: "Firefox",
            data: [
              ["v58.0", 1.02],
              ["v57.0", 7.36],
              ["v56.0", 0.35],
              ["v55.0", 0.11],
              ["v54.0", 0.1],
              ["v52.0", 0.95],
              ["v51.0", 0.15],
              ["v50.0", 0.1],
              ["v48.0", 0.31],
              ["v47.0", 0.12],
            ],
          },
          {
            name: "Internet Explorer",
            id: "Internet Explorer",
            data: [
              ["v11.0", 6.2],
              ["v10.0", 0.29],
              ["v9.0", 0.27],
              ["v8.0", 0.47],
            ],
          },
          {
            name: "Safari",
            id: "Safari",
            data: [
              ["v11.0", 3.39],
              ["v10.1", 0.96],
              ["v10.0", 0.36],
              ["v9.1", 0.54],
              ["v9.0", 0.13],
              ["v5.1", 0.2],
            ],
          },
          {
            name: "Edge",
            id: "Edge",
            data: [
              ["v16", 2.6],
              ["v15", 0.92],
              ["v14", 0.4],
              ["v13", 0.1],
            ],
          },
          {
            name: "Opera",
            id: "Opera",
            data: [
              ["v50.0", 0.96],
              ["v49.0", 0.82],
              ["v12.1", 0.14],
            ],
          },
        ],
      }
    }
  },

  methods: {
    onRender() {
      console.log("Chart rendered");
    }
  },

  // setup() {
  //   const seriesData = ref([25, 39, 30, 15]);
  //   const categories = ref(["Jun", "Jul", "Aug", "Sept"]);

  

  //   var totalClicks = 0;
  //   for (var doc of fe2) {
  //     totalClicks += doc.y;
  //   }

  //   console.log(totalClicks);

  //   const chartOptions = computed(() => ({
  //     
  //     },
  //   }));

  //   const onRender = () => {
  //     console.log("Chart rendered");
  //   };

  //   return {
  //     chartOptions,
  //     onRender,
  //   };
  // },
};
</script>