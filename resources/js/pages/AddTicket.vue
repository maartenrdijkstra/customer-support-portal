<template>
    <div>
        <h2>Nieuw Ticket Aanmaken</h2>

        <p v-if="error" style="color: red">{{ error }}</p>

        <form @submit.prevent="submitTicket">
            <div>
                <label for="title">Titel</label>
                <input id="title" v-model="ticket.title" required />
            </div>

            <div>
                <label for="status">Status</label>
                <select id="status" v-model="ticket.status">
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <!-- Assignee (alleen admins) -->
            <div>
                <label for="assignee">Toegewezen aan</label>
                <select id="assignee" v-model="ticket.assignee_id">
                    <option :value="null">Niet toegewezen</option>
                    <option
                        v-for="user in users.filter((user) => user.is_admin)"
                        :key="user.id"
                        :value="user.id"
                    >
                        {{ user.name }}
                    </option>
                </select>
            </div>

            <div>
                <label>Categorieën</label>
                <div v-for="category in categories" :key="category.id">
                    <input
                        type="checkbox"
                        :value="category.id"
                        v-model="selectedCategories"
                    />
                    {{ category.name }}
                </div>
            </div>

            <button type="submit">Aanmaken</button>
        </form>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { getMe, getUsers, me, users } from "../stores/user";
import { getCategories, categories } from "../stores/categories";
import axios from "axios";
import { Ticket } from "../types/Ticket";
import { useRoute, useRouter } from "vue-router";
import { User } from "../types/User";

const route = useRoute();
const router = useRouter();

const ticket = ref<Partial<Ticket>>({
    title: "",
    status: "open",
    reporter_id: 0, // vul later met ingelogde user
    assignee_id: null,
    categories: [],
});

const selectedCategories = ref<number[]>([]);
const error = ref("");

onMounted(async () => {
    try {
        await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
        await getMe();
        await getUsers();
        await getCategories();
        ticket.value.reporter_id = me.value?.id;
    } catch (e: any) {
        error.value = e.message || "Fout bij ophalen van data";
    }
});

const submitTicket = async () => {
    error.value = "";

    if (selectedCategories.value.length === 0) {
        error.value = "Selecteer minimaal één categorie.";
        return;
    }

    try {
        const ticketCopy = {
            ...ticket.value,
            reporter_id: me.value.id,
            categories: selectedCategories.value,
        };

        await axios.post("/api/tickets", ticketCopy, {
            withCredentials: true,
        });
        router.push("/tickets");
    } catch (e: any) {
        error.value = e.response?.data?.message || "Fout bij aanmaken ticket";
    }
};
</script>

<style scoped>
form > div {
    margin-bottom: 1rem;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 0.3rem;
}

input[type="text"],
select {
    width: 100%;
    padding: 0.5rem;
    box-sizing: border-box;
}
</style>
