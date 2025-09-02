<template>
    <div>
        <h2>Ticket Bewerken</h2>
        <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" />
    </div>
</template>

<script lang="ts" setup>
import { useRoute, useRouter } from "vue-router";
import { fetchTickets, getTicketById, updateTicket } from "../store";
import Form from "../components/Form.vue";
import { computed, onMounted, ref } from "vue";
import { me } from "../../../stores/user";

const route = useRoute();
const router = useRouter();

onMounted(async () => {
    if (me.value && me.value.is_admin) {
        await fetchTickets("/api/alltickets");
    } else {
        await fetchTickets("/api/usertickets");
    }
});

const ticket = getTicketById(route.params.id);

const handleSubmit = async (data) => {
    console.log(route.params.id, data);
    await updateTicket(route.params.id, data);
    router.push({ name: "tickets.overview" });
};
</script>
