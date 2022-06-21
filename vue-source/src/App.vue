<template>
  <div>
    <header>
      <nav>
        <RouterLink to="/">{{i18n('page_title_graph')}}</RouterLink>
        <RouterLink to="/table">{{i18n('page_title_table')}}</RouterLink>
        <RouterLink to="/settings">{{i18n('page_title_settings')}}</RouterLink>
      </nav>
    </header>
    <main>
      <RouterView />
    </main>
  </div>
</template>

<script>
import { RouterLink, RouterView } from "vue-router";
export default {
  created() {
    this.get_data();
    this.get_settings();
  },

  methods: {

    get_data() {
      const headers = { "X-WP-Nonce": window.wabvap_vue.nonce };
      fetch(window.wabvap_vue.endpoints.data_url, { headers })
        .then((response) => response.json())
        .then((data) => this.$store.commit("UpdateData", JSON.parse(data)));
    },

    get_settings() {
      const headers = { "X-WP-Nonce": window.wabvap_vue.nonce };
      fetch(window.wabvap_vue.endpoints.setting_url, { headers })
        .then((response) => response.json())
        .then((data) => this.$store.commit("UpdateSettings", data));
    },
  },
};
</script>
