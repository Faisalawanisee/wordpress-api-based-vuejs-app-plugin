import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "graph",
      component: () => import("../views/Graph.vue"),
    },
    {
      path: "/table",
      name: "table",
      component: () => import("../views/Table.vue"),
    },
    {
      path: "/settings",
      name: "settings",
      component: () => import("../views/Settings.vue"),
    },
  ],
});

export default router;
