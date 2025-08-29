<template>
    <div>
        <h2>Nieuw Ticket Aanmaken</h2>
        <Form :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script setup lang="ts">
import Form from "../components/Form.vue";
import { useRoute, useRouter } from "vue-router";
import { Ticket } from "../../../types/Ticket";
import { ref } from "vue";
import { createTicket } from "../store";
import { categories } from "../../../stores/categories";

const route = useRoute();
const router = useRouter();

const ticket = ref({
    title: "",
    status: "open",
    reporter_id: 0,
    assignee_id: 0,
    categories: [],
});

const handleSubmit = async (data: Ticket) => {
    try {
        await createTicket(data);
        router.push("/tickets");
    } catch (err) {
        console.error("Fout bij het aanmaken van ticket:", err);
    }
};
</script>
