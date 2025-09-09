<template>
    <div>
        <h2>Ticket Bewerken</h2>
        <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script lang="ts" setup>
import { useRoute, useRouter } from "vue-router";
import Form from "../components/Form.vue";
import { computed, onMounted, ref } from "vue";
import { ticketStore } from "../store";

const route = useRoute();
const router = useRouter();

const tickts = ticketStore.getters.all;

const ticket = ticketStore.getters.getById(route.params.id);

const handleSubmit = async (data) => {
    console.log(route.params.id, data);
    await ticketStore.actions.update(route.params.id, data);
    router.push({ name: "tickets.overview" });
};
</script>
