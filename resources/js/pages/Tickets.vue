<template>
    <p v-if="error" style="color: red">{{ error }}</p>

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
                    <td>{{ ticket.made_timestamp }}</td>
                    <td>{{ ticket.last_update_on }}</td>
                    <td>{{ getUserById(ticket.assignee_id) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { user } from "../auth";

const me = ref(null);
const users = ref([]);
const error = ref("");
const tickets = ref([]);
const categories = ref([]);

const getData = async () => {
    try {
        const response = await axios.get("/api/me", { withCredentials: true });
        me.value = response.data;
        console.log("me", me.value);
        if (me.value.is_admin == 1) {
            getTickets("/api/alltickets");
        } else {
            getTickets("/api/usertickets");
        }
    } catch (err) {
        error.value = "Niet ingelogd of sessie verlopen.";
    }
};

const getTickets = async (apiCall) => {
    try {
        const response = await axios.get(apiCall, {
            withCredentials: true,
        });
        tickets.value = response.data;
        console.log("tickets by user" + tickets.value);
    } catch (err) {
        console.error("Fout bij ophalen tickets", err);
    }
};

const getUsers = async () => {
    try {
        const response = await axios.get("/api/users", {
            withCredentials: true,
        });
        users.value = response.data;
    } catch (err) {
        console.error("Fout bij ophalen users", err);
    }
};

const getCategories = async () => {
    try {
        const response = await axios.get("/api/categories", {
            withCredentials: true,
        });
        categories.value = response.data;
    } catch (err) {
        console.error("Fout bij ophalen categories", err);
    }
};

const getUserById = (id) => {
    const user = users.value.find((user) => user.id === id);
    return user ? user.name : "Onbekend";
};

const getCategoriesByTicket = async (ticketId) => {
    const ticketCategories = tickets.value
        .filter((ticket) => ticket.id === ticketId)
        .map((ticket) => ticket.category.name)
        .join(", ");
    return ticketCategories;
};

getData();
getUsers();
getCategories();
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
