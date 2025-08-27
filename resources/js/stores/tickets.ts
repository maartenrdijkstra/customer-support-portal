import { ref } from "vue";
import axios from "axios";
import type { Ticket } from "../types/Ticket";

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
