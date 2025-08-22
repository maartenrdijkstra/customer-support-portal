import { createRouter, createWebHistory } from "vue-router";
import Login from "../../js/pages/Login.vue";
import Tickets from "../../js/pages/Tickets.vue";
import App from "../../App.vue";
import { fetchUser, user } from "../auth";
import ForgotPassword from "../pages/ForgotPassword.vue";
import ResetPassword from "../pages/ResetPassword.vue";

const routes = [
    { path: "/login", component: Login },
    { path: "/forgot-password", component: ForgotPassword },
    { path: "/reset-password", component: ResetPassword }, // token via query
    { path: "/tickets", component: Tickets },
    { path: "/", component: App },
    { path: "/:catchAll(.*)", redirect: "/login" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const publicPaths = ["/login", "/forgot-password", "/reset-password"];

// Check login voor alle routes behalve /login
router.beforeEach(async (to) => {
    if (!user.value) {
        await fetchUser(); // probeer user op te halen
    }
    if (user.value) {
        // Ingelogd → blokkeer toegang tot login/forgot/reset en stuur door naar tickets
        if (publicPaths.includes(to.path)) {
            return "/tickets";
        }
    } else {
        // Niet ingelogd → blokkeer toegang tot private routes
        if (!publicPaths.includes(to.path)) {
            return "/login";
        }
    }
});

export default router;
