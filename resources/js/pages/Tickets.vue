<template>
    <p>Ingelogd!</p>
    <button @click="getMe">Check /me</button>

    <p v-if="error" style="color: red">{{ error }}</p>

    <div v-if="me">
        <h3>Ingelogde gebruiker:</h3>
        <p>{{ me.name }} | {{ me.email }}</p>
    </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { user } from "../auth";

const me = ref(null);
const error = ref("");

const getMe = async () => {
    try {
        const response = await axios.get("/api/me", { withCredentials: true });
        me.value = response.data;
    } catch (err) {
        error.value = "Niet ingelogd of sessie verlopen.";
    }
};
</script>
