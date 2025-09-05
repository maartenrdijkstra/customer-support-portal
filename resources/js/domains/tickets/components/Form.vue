<template>
    <form @submit.prevent="handleSubmit">
        <p style="color: red"></p>
        <div>
            <label for="title">Titel</label>
            <input v-model="ticket.title" id="title" required />
        </div>
        <div>
            <label for="categories">Categorieën</label>
            <div
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
            >
                <input type="checkbox" :value="category.id" />
                {{ category.name }}
            </div>
        </div>

        <button type="submit">Opslaan</button>
    </form>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { Ticket } from "../../../types/Ticket";
import { getMe, getUsers, me, users } from "../../../stores/user";
import { categories, getCategories } from "../../../stores/categories";
import axios from "axios";
import { storeModuleFactory } from "../../../services/store";
import { ticketStore } from "../store";

onMounted(async () => {
    try {
        await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
        await getMe();
        await getUsers();
    } catch (e: any) {
        error.value = e.message || "Fout bij ophalen van data";
    }
});

const props = defineProps<{ ticket: Ticket }>();

const emit = defineEmits(["submit"]);
const form = ref({ ...props.ticket });

const handleSubmit = () => emit("submit", form.value);
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
