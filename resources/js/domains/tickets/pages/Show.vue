<template>
    <h2>Ticket Details</h2>
    <div v-if="ticket">
        <p>Ticket-id: {{ ticket.id }}</p>
        <p>Titel: {{ ticket.title }}</p>
        <p>Status: {{ ticket.status }}</p>
        <p>Aangemaakt door: {{ reporter }}</p>
        <p>Toegewezen aan: {{ assignee }}</p>
        <p>
            Laatste update:
            {{ formatDate(ticket.last_update_on) }}
        </p>
        <p>Aangemaakt op: {{ formatDate(ticket.made_timestamp) }}</p>
        <p>Reacties: <ul>
            <li v-for="reaction in reactions" :key="reaction.id">
                {{ getUserById(reaction.user_id) }}: {{ reaction.content }}
            </li>
        </ul></p>
    </div>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue";
import { getTicketById } from "../store";
import { useRoute } from "vue-router";
import { getUserById } from "../../../stores/user";
import { formatDate } from "../../../services/helper-methods";

const route = useRoute();
const ticketId = route.params.id;
const error = ref("");
const ticket = getTicketById(route.params.id);

const assigneeId = ticket.value?.assignee_id || null;
const assignee = getUserById(assigneeId) || "Niet toegewezen";

const reactions = ticket.value?.reactions || [];

const reporter_id = ticket.value?.reporter_id || null;
const reporter = getUserById(reporter_id) || "Onbekend";
</script>
<style scoped>
h2 {
    margin-bottom: 1rem;
    font-size: 2rem;
    font-weight: 550;
}

div {
    background-color: #f9f9f9;
    padding: 1rem;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

p {
    margin: 0.5rem 0;
    font-size: 1.1rem;
}

ul {
    list-style-type: disc;
    padding-left: 1.5rem;
}
li {
    margin: 0.3rem 0;
}
</style>
