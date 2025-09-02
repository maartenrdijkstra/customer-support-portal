<template>
    <p v-if="error" style="color: red">{{ error }}</p>

    <router-link to="/add-ticket" v-if="me && !me.is_admin"
        >Maak Nieuw Ticket aan</router-link
    >

    <div v-if="me">
        <h4>Tickets</h4>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titel</th>
                    <th>Categorieën</th>
                    <th>Status</th>
                    <th>Aangemaakt door</th>
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
                    <td>{{ getUserById(ticket.reporter_id) }}</td>
                    <td>{{ formatDate(ticket.made_timestamp) }}</td>
                    <td>{{ formatDate(ticket.last_update_on) }}</td>
                    <td>{{ getUserById(ticket.assignee_id) }}</td>
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
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from "vue";
import { getMe, getUserById, getUsers, me } from "../../../stores/user";
import { getCategories } from "../../../stores/categories";
import { fetchTickets, tickets } from "../store";
import { formatDate } from "../../../services/helper-methods";

const error = ref("");

onMounted(async () => {
    try {
        await getMe();
        await getUsers();
        await getCategories();
        if (me.value && me.value.is_admin) {
            fetchTickets("/api/alltickets");
        } else {
            fetchTickets("/api/usertickets");
        }
    } catch (err) {
        error.value = err?.message || "Onbekende fout";
    }
});
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
