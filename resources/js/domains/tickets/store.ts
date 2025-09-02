import { computed, ref } from "vue";
import axios from "axios";
import { Ticket } from "../../types/Ticket";

export const tickets = ref<Ticket[]>([]);
export const error = ref("");

export const fetchTickets = async (apiCall: string) => {
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

export const createTicket = async (newTicket: Ticket) => {
    console.log("New ticket data:", newTicket);
    const { data } = await axios.post("/api/tickets", newTicket);
    if (!data) return;
    tickets.value = data;
};

export const updateTicket = async (id, updatedTicket) => {
    const { data } = await axios.put(`/api/tickets/${id}`, updatedTicket);
    if (!data) return;
    console.log("Updated ticket data:", data);
};

export const getTicketById = (id) =>
    computed(() => tickets.value.find((ticket) => ticket.id == id));
