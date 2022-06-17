<template>
  <div class="table">
    <h1>{{$store.state.Data?.table?.title}}</h1>

    <table class="table wp-list-table widefat" v-if="table">
      <thead v-if="table.headers">
         <tr>
           <th v-for="item in table.headers" :key="item" v-html="item"></th>
         </tr>
      </thead>
      <tbody>
          <tr v-for="item in table.rows" :key="item">
            <td v-for="head in table.headers" :key="head">{{item[head.toLowerCase()]}}</td>
          </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    computed: {
      table(){
        return this.$store.state.Data?.table?.data;
      }
    },
  };
</script>