import { ref } from "vue";
import axios from "axios";
import { User } from "./types/User";

export const user = ref(null as User | null);

export const fetchUser = async () => {
    try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        const response = await axios.get("/api/me", { withCredentials: true });
        user.value = response.data;
    } catch (err) {
        user.value = null;
    }
};

export const logout = async () => {
    await axios.post("/logout", {}, { withCredentials: true });
    user.value = null;
};
