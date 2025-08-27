import { ref } from "vue";
import axios from "axios";
import type { Category } from "../types/Category";

export const categories = ref<Category[]>([]);
export const error = ref("");

export const getCategories = async (): Promise<void> => {
    try {
        const response = await axios.get("/api/categories", {
            withCredentials: true,
        });
        categories.value = response.data;
    } catch (err) {
        console.error("Fout bij ophalen categories", err);
    }
};
