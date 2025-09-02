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
    <form v-if="user?.is_admin" @submit.prevent="handleSubmit">
        <label for="assignee">Toewijzen aan:</label>
        <select v-model="selectedAssigneeId">
            <option v-for="admin in adminUsers" :key="admin.id" :value="admin.id">
                {{ admin.name }}
            </option>
            <option :value="null">Niet toegewezen</option>
        </select>
        <button type="submit">Opslaan</button>
    </form>

    
        <p>
        Toegewezen aan: 
        {{ selectedAssigneeId !== null ? getUserById(selectedAssigneeId) : "Niet toegewezen" }}
        </p>
    </div>
</template>

<script lang="ts" setup>
import { getTicketById, updateTicket } from "../store";
import { useRoute, useRouter } from "vue-router";
import { getUserById, users } from "../../../stores/user";
import { formatDate } from "../../../services/helper-methods";
import { user } from "../../../auth";
import { ref } from "vue";

const router = useRouter();
const route = useRoute();
const ticket = getTicketById(route.params.id);

const selectedAssigneeId = ref<number | null>(ticket.value?.assignee_id ?? null);
const assignee = getUserById(selectedAssigneeId.value) || "Niet toegewezen";
const reactions = ticket.value?.reactions || [];
const reporter_id = ticket.value?.reporter_id || null;
const reporter = getUserById(reporter_id) || "Onbekend";



const adminUsers = users.value.filter((user) => user.is_admin);


//TODO: Fix bug with updating assignee
const handleSubmit = async () => {
    try {
        await updateTicket(route.params.id, {
            assignee_id: selectedAssigneeId.value !== null ? Number(selectedAssigneeId.value) : null
        });
    } catch (err) {
        console.error("Update failed:", err);
    }
};

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
