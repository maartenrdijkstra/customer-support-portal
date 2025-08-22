import { createRouter, createWebHistory } from "vue-router";
import Login from "../js/pages/Login.vue";
import Tickets from "../js/pages/Tickets.vue";

const routes = [
    { path: "/", component: Login },
    { path: "/tickets", component: Tickets },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
