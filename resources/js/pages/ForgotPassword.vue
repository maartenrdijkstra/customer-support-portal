<template>
    <div class="login-container">
        <h2>Wachtwoord vergeten</h2>
        <form @submit.prevent="sendResetLink">
            <div>
                <label for="email">Email:</label>
                <input id="email" v-model="email" type="email" required />
            </div>
            <button type="submit">Verstuur resetlink</button>
        </form>

        <p v-if="message" class="message">{{ message }}</p>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
import { ref, Ref } from "vue";
import axios from "axios";

const email = ref("");
const message = ref("");
const error = ref("");

const sendResetLink = async () => {
    try {
        const response = await axios.post("/forgot-password", {
            email: email.value,
        });
        message.value =
            response.data.message || "Check je e-mail voor de resetlink.";
        error.value = "";
    } catch (err) {
        error.value = err.response?.data?.message || "Er is iets misgegaan.";
        message.value = "";
    }
};
</script>

<style scoped>
.message {
    color: green;
}
.error {
    color: red;
}
</style>
