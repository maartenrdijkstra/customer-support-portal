import Create from "./pages/Create.vue";
import Edit from "./pages/Edit.vue";
import Overview from "./pages/Overview.vue";

export const ticketRoutes = [
    {
        path: "/tickets",
        component: Overview,
        name: "tickets.overview",
    },
    {
        path: "/tickets/create",
        component: Create,
        name: "tickets.create",
    },
    {
        path: "/tickets/:id/edit",
        component: Edit,
        name: "tickets.edit",
    },
];
