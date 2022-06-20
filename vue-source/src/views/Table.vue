<template>
  <div class="table-content">
    <h2 class="sec-title">{{ $store.state.Data?.table?.title }}</h2>

    <div class="responsive-table">
      <table
        class="wp-list-table widefat fixed striped table-view-list events"
        v-if="table"
      >
        <thead v-if="table.headers">
          <tr>
            <th v-for="item in table.headers" :key="item" v-html="item"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in table.rows" :key="item">
            <td v-for="head in table.headers" :key="head">
              {{ item[head.toLowerCase()] }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    table() {
      return this.$store.state.Data?.table?.data;
    },
  },
};
</script>
