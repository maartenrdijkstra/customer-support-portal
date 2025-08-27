<template>
    <div class="login-container">
        <h2>Nieuw wachtwoord instellen</h2>
        <form @submit.prevent="resetPassword">
            <div>
                <label for="email">E-mail:</label>
                <input id="email" v-model="email" type="email" required />
            </div>
            <div>
                <label for="password">Nieuw wachtwoord:</label>
                <input
                    id="password"
                    v-model="password"
                    type="password"
                    required
                />
            </div>
            <div>
                <label for="password_confirmation">Bevestig wachtwoord:</label>
                <input
                    id="password_confirmation"
                    v-model="passwordConfirmation"
                    type="password"
                    required
                />
            </div>
            <button type="submit">Reset wachtwoord</button>
        </form>

        <p v-if="message" class="message">{{ message }}</p>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, Ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const email = ref("");
const token = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const message = ref("");
const error = ref("");

onMounted(() => {
    token.value = (route.query.token as string) || "";
    email.value = (route.query.email as string) || "";
});

const resetPassword = async () => {
    if (password.value !== passwordConfirmation.value) {
        error.value = "Wachtwoorden komen niet overeen.";
        return;
    }

    try {
        await axios.post("/reset-password", {
            email: email.value,
            token: token.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
        });
        message.value = "Wachtwoord succesvol gewijzigd!";
        error.value = "";
        setTimeout(() => router.push("/login"), 2000);
    } catch (err) {
        error.value =
            err.response?.data?.message || "Fout bij wachtwoord reset.";
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
