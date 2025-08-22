import { createRouter, createWebHistory } from "vue-router";
import Login from "../js/pages/Login.vue";
import Tickets from "../js/pages/Tickets.vue";
import App from "../App.vue";
import { fetchUser, user } from "../js/auth";

const routes = [
    { path: "/login", component: Login },
    { path: "/tickets", component: Tickets },
    { path: "/", component: App },
    { path: "/:catchAll(.*)", redirect: "/login" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Check login voor alle routes behalve /login
router.beforeEach(async (to) => {
    if (!user.value) {
        await fetchUser(); // probeer user op te halen
    }

    if (to.path !== "/login" && !user.value) {
        return "/login";
    }
});

export default router;
