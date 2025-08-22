import { ref } from "vue";
import axios from "axios";

export const user = ref(null);

export const fetchUser = async () => {
    try {
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
