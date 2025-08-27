import { ref } from "vue";
import axios from "axios";
import type { User } from "../types/User";

export const user = ref<User | null>(null);
export const error = ref("");
export const me = ref<User | null>(null);
export const users = ref<User[]>([]);

export const getMe = async () => {
    try {
        await axios.get("/sanctum/csrf-cookie"); // CSRF voor Sanctum
        me.value = await axios
            .get("/api/me", { withCredentials: true })
            .then((res) => res.data);
        console.log("User data:", me.value);
        error.value = "";
    } catch (err) {
        user.value = null;
        error.value = "Niet ingelogd of sessie verlopen.";
    }
};

export const getUsers = async (): Promise<void> => {
    try {
        const response = await axios.get("/api/users", {
            withCredentials: true,
        });
        users.value = response.data;
    } catch (err) {
        console.error("Fout bij ophalen users", err);
    }
};

export const getUserById = (id: number | null) => {
    const found = users.value.find((user) => user.id === id);
    return found ? found.name : "Onbekend";
};

export const logout = async () => {
    await axios.post("/logout", {}, { withCredentials: true });
    user.value = null;
};
