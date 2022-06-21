import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from "./store";
import VueApexCharts from "vue3-apexcharts";
import i18n from '@/mixins/i18n.js';
import uuid from '@/mixins/uuid.js';
const app = createApp(App);

app.use(router);
app.use(store);
app.use(VueApexCharts);
app.mixin(i18n);
app.mixin(uuid);

app.mount('#WABVAP-PAGE');
