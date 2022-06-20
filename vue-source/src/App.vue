<template>
  <div>
    <header>
      <nav>
        <RouterLink to="/">Graph</RouterLink>
        <RouterLink to="/table">Table</RouterLink>
        <RouterLink to="/settings">Settings</RouterLink>
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
    this.get_wp_info();
    this.get_data();
    this.get_settings();
  },

  methods: {
    get_wp_info() {
      this.$store.commit("UpdateWabvapVue", window.wabvap_vue);
    },

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

<style>
@import "@/assets/base.css";

/* #app {
  max-width: 1280px;
  margin: 0 auto;
  padding: 2rem;
  font-weight: normal;
} */
</style>
