<template>
    <form @submit.prevent="handleSubmit">
        <p v-if="error" style="color: red">{{ error }}</p>
        <div>
            <label for="title">Titel</label>
            <input id="title" v-model="form.title" required />
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

        <button type="submit">Opslaan</button>
    </form>
</template>
+

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { Ticket } from "../../../types/Ticket";
import { getMe, getUsers, me, users } from "../../../stores/user";
import { categories, getCategories } from "../../../stores/categories";
import axios from "axios";

const selectedCategories = ref<number[]>([]);
const error = ref("");

onMounted(async () => {
    try {
        await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
        await getMe();
        await getUsers();
        await getCategories();
    } catch (e: any) {
        error.value = e.message || "Fout bij ophalen van data";
    }
});

const props = defineProps<{
    ticket: Ticket | Partial<Ticket>;
}>();

const emit = defineEmits(["submit"]);

const form = ref({ ...props.ticket });

const handleSubmit = async () => {
    error.value = "";

    if (!form.value.title) {
        error.value = "Titel is verplicht.";
        return;
    }

    if (selectedCategories.value.length === 0) {
        error.value = "Selecteer minimaal één categorie.";
        return;
    }

    form.value.reporter_id = me.value ? me.value.id : 0;

    emit("submit", {
        ...form.value,
        categories: selectedCategories.value,
    });
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
