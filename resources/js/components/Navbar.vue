<template>
    <nav v-if="user" class="navbar">
        <ul>
            <li><router-link to="/tickets">Tickets</router-link></li>
            <li @click="logoutUser" class="logout">Logout</li>
        </ul>
        <div class="user-info">
            Ingelogd als: <strong>{{ user.name }}</strong> ({{ user.email }})
        </div>
    </nav>
</template>

<script setup>
import { user, logout } from "../auth.js";
import { useRouter } from "vue-router";

const router = useRouter();

const logoutUser = async () => {
    await logout();
    router.push("/login");
};
</script>

<style scoped>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
}

.navbar ul {
    display: flex;
    list-style: none;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.navbar li {
    cursor: pointer;
}

.navbar .logout {
    color: #ffdddd;
}

.navbar .user-info {
    font-size: 0.9rem;
}
</style>
