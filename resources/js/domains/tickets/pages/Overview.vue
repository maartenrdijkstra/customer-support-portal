<template>
    <ErrorMessage />

    <h4>Tickets</h4>
    <table v-if="me">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Categorieën</th>
                <th>Status</th>
                <th v-if="me.is_admin">Aangemaakt door</th>
                <th>Aangemaakt op</th>
                <th>Laatste update op</th>
                <th>Toegewezen aan</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="ticket in tickets" :key="ticket.id">
                <td>{{ ticket.id }}</td>
                <td>{{ ticket.title }}</td>
                <td>
                    {{ ticket.categories.map((c) => c.name).join(", ") }}
                </td>
                <td>{{ ticket.status }}</td>
                <td v-if="me.is_admin">
                    {{
                        userstore.getters.getById(ticket.reporter_id).value.name
                    }}
                </td>
                <td>{{ formatDate(ticket.made_timestamp) }}</td>
                <td>{{ formatDate(ticket.last_update_on) }}</td>
                <td>
                    {{
                        userstore.getters.getById(ticket.assignee_id).value
                            ?.name
                            ? userstore.getters.getById(ticket.assignee_id)
                                  .value.name
                            : "Nog niet toegewezen"
                    }}
                </td>
                <td>
                    <RouterLink
                        :to="{
                            name: 'tickets.edit',
                            params: { id: ticket.id },
                        }"
                        >Bewerk</RouterLink
                    >
                </td>
                <td>
                    <RouterLink
                        :to="{
                            name: 'tickets.show',
                            params: { id: ticket.id },
                        }"
                        >Show</RouterLink
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script lang="ts" setup>
import { onMounted, ref } from "vue";
import { getMe, getUserById, getUsers, me } from "../../../stores/user";
import { getCategories } from "../../../stores/categories";
import { formatDate } from "../../../services/helper-methods";
import { storeModuleFactory } from "../../../services/store";
import { userstore } from "../../users/store";
import { categoryStore } from "../../categories/store";
import { Ticket } from "../../../types/Ticket";
import { ticketStore } from "../store";
import ErrorMessage from "../../../ErrorMessage.vue";
import { User } from "../../../types/User";

const error = ref("");

ticketStore.actions.getAll();
userstore.actions.getAll();
categoryStore.actions.getAll();

const tickets = ticketStore.getters.all;
const users = userstore.getters.all;
const categories = categoryStore.getters.all;
getMe();

console.log(tickets.value);
</script>
<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}
th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}
tr:hover {
    background-color: #ddd;
}

h4 {
    margin-top: 1rem;
    font-size: 3rem;
    margin-bottom: 1rem;
    font-weight: 550;
}
</style>
