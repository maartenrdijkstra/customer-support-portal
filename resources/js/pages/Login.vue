<template>
    <div class="login-container">
        <h2>Klantenhulpportaal login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email:</label>
                <input id="email" v-model="email" type="email" required />
            </div>

            <div>
                <label for="password">Password:</label>
                <input
                    id="password"
                    v-model="password"
                    type="password"
                    required
                />
            </div>

            <button type="submit">Login</button>
        </form>
        <p class="forgot-password">
            <router-link to="/forgot-password"
                >Wachtwoord vergeten?</router-link
            >
        </p>
        <p class="error" v-if="error">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { fetchUser } from "../auth";

const email = ref("");
const password = ref("");
const error = ref("");
const router = useRouter();

const login = async () => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        const response = await axios.post("/login", {
            email: email.value,
            password: password.value,
        });

        if (response.data.success) {
            await fetchUser(); // update globale user
            router.push("/tickets");
        } else {
            error.value = "Ongeldige inloggegevens";
        }
    } catch (err) {
        if (err.response.status === 401) {
            error.value = "Ongeldige inloggegevens";
        } else {
            error.value = "Er is een fout opgetreden bij het inloggen.";
        }
    }
};
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login-container h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 20px;
}

.login-container form {
    display: flex;
    flex-direction: column;
}

.login-container div {
    margin-bottom: 15px;
}

.login-container label {
    margin-bottom: 5px;
}

.login-container input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.login-container button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.login-container button:hover {
    background-color: #0056b3;
}

.error {
    color: red;
}

.forgot-password {
    margin-top: 10px;
    text-align: right;
}

.forgot-password a {
    color: #007bff;
    text-decoration: underline;
}

.forgot-password a:hover {
    color: #0056b3;
}
</style>
