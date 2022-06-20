<template>
  <div class="graph-content">
    <h2 class="sec-title">Graph</h2>

    <div>
      <button @click="refresh_data" class="button button-primary">Refresh Data</button>
    </div>

    <div class="card-box">
      <apexchart
        v-if="options && options.series"
        width="700"
        type="bar"
        :options="options"
        :series="options.series"
      />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    options() {
      const graph = this.$store.state.Data?.graph;
      if (!graph) return;
      const output = {
        xaxis: {
          categories: [],
        },
        series: [
          {
            data: [],
          },
        ],
      };
      const graphdata = Object.keys(graph).map((k) => graph[k]);

      for (let i = 0; i < graphdata.length; i++) {
        const element = graphdata[i];

        output.xaxis.categories.push(element.date);
        output.series[0].data.push(element.value);
      }

      return output;
    },
  },

  methods: {
    refresh_data() {
      const headers = { "X-WP-Nonce": window.wabvap_vue.nonce };
      fetch(window.wabvap_vue.endpoints.data_url + "?refresh=true", { headers })
        .then((response) => response.json())
        .then((data) => this.$store.commit("UpdateData", JSON.parse(data)));
    },
  },
};
</script>
