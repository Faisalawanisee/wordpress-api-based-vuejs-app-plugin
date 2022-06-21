<template>
  <div class="table-content">
    <h2 class="sec-title">{{i18n('page_title_table')}}</h2>
    <div class="responsive-table">
      <table
        class="wp-list-table widefat fixed striped table-view-list events"
        v-if="table"
      >
        <thead v-if="table.headers">
          <tr>
            <th width="20px">ID</th>
            <th>Title</th>
            <th>Page Views</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(i, j) in numrows" :key="i">
            <td>{{table.rows[j].id}}</td>
            <td>
              <a :href="table.rows[j].url" target="_blank">{{table.rows[j].title}}</a>
            </td>
            <td>{{table.rows[j].pageviews}}</td>
            <td>{{itemDate(table.rows[j].date)}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="emails.length">
      <h3>{{i18n('emails_list')}}</h3>
      <ul>
        <li v-for="email in emails" :key="email">
          <a :href="'mailto:'+email">{{email}}</a>
        </li>
      </ul>
    </div>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      trigger: 0
    }
  },
  computed: {
    numrows(){
      return this.$store.state.Settings.numrows
    },
    humandate(){
      return this.$store.state.Settings.humandate
    },
    emails(){
      return this.$store.state.Settings.emails
    },
    table() {
      return this.$store.state.Data?.table?.data;
    }
  },
  methods: {
    itemDate(date){
      if(this.humandate){
        return new Date( date * 1000);
      } else {
        return date;
      }
    }
  },
};
</script>
