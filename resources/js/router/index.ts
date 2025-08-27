import { createRouter, createWebHistory } from "vue-router";
import Login from "../../js/pages/Login.vue";
import Tickets from "../../js/pages/Tickets.vue";
import App from "../../App.vue";
import { fetchUser, user } from "../auth";
import ForgotPassword from "../pages/ForgotPassword.vue";
import ResetPassword from "../pages/ResetPassword.vue";
import AddTicket from "../pages/AddTicket.vue";

const routes = [
    { path: "/login", component: Login },
    { path: "/forgot-password", component: ForgotPassword },
    { path: "/reset-password", component: ResetPassword }, // token via query
    { path: "/tickets", component: Tickets },
    { path: "/add-ticket", component: AddTicket },
    { path: "/", component: App },
    { path: "/:catchAll(.*)", redirect: "/login" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
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
