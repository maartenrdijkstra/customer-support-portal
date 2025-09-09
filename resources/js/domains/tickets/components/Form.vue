<template>
    <form v-if="me && me.id" @submit.prevent="handleSubmit">
        <p style="color: red"></p>
        <div>
            <label for="title">Titel</label>
            <input v-model="form.title" id="title" required />
        </div>
        <div>
            <label for="categories">Categorieën</label>
            <div v-for="category in categories" :key="category.id">
                <input
                    type="checkbox"
                    :value="category.id"
                    v-model="form.categories"
                />
                {{ category.name }}
            </div>
        </div>

        <p>{{ form }}</p>

        <button type="submit">Opslaan</button>
    </form>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { Ticket } from "../../../types/Ticket";
import { categoryStore } from "../../categories/store";
import { getMe, me } from "../../../stores/user";
import { ticketStore } from "../store";

categoryStore.actions.getAll();
const categories = categoryStore.getters.all;

const props = defineProps<{ ticket: Ticket }>();

getMe();

const emit = defineEmits(["submit"]);
const form = ref({ ...props.ticket });

form.value.reporter_id = me.value?.id || 0;
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
