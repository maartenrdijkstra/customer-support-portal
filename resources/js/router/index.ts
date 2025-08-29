import { createRouter, createWebHistory } from "vue-router";
import Login from "../../js/pages/Login.vue";
import App from "../../App.vue";
import { fetchUser, user } from "../auth";
import ForgotPassword from "../pages/ForgotPassword.vue";
import ResetPassword from "../pages/ResetPassword.vue";
import Create from "../domains/tickets/pages/Create.vue";
import Overview from "../domains/tickets/pages/Overview.vue";
import { ticketRoutes } from "../domains/tickets/routes";

const routes = [
    { path: "/login", component: Login },
    { path: "/forgot-password", component: ForgotPassword },
    { path: "/reset-password", component: ResetPassword }, // token via query
    { path: "/tickets", component: Overview },
    { path: "/add-ticket", component: Create },
    { path: "/", component: App },
    { path: "/:catchAll(.*)", redirect: "/login" },
];

const router = createRouter({
    history: createWebHistory(),
    routes: [...ticketRoutes, ...routes],
});

const publicPaths = ["/login", "/forgot-password", "/reset-password"];

router.beforeEach(async (to) => {
    if (!user.value) {
        try {
            await fetchUser();
        } catch (e) {
            // user blijft null als niet ingelogd
        }
    }

    if (user.value) {
        if (publicPaths.includes(to.path)) {
            return "/tickets";
        }
        if (to.path === "/add-ticket" && user.value.is_admin) {
            return "/tickets"; // admins mogen hier niet heen
        }
        return true;
    } else {
        if (!publicPaths.includes(to.path)) {
            return "/login";
        }
        return true;
    }
});

export default router;
