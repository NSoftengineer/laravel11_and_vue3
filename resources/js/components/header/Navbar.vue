<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-danger">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="/">Mittraphap Eexpress</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link text-white">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/about" class="nav-link text-white">about</router-link>
                        </li>
                        <li class="nav-item" v-if="token">
                            <button @click="logout()" class="nav-link text-white">logout</button>
                            <!-- <router-link @click="logout()" class="nav-link text-white">logout</router-link> -->
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const token = localStorage.getItem('token')
console.log(token);
function logout() {
    axios.get('logout')
        .then(response => {
            console.log(response);
            localStorage.setItem('token', '');
            localStorage.setItem('logged', false);
            // router.push({ name: 'LoginPage' });
            window.location.href = "/login"
        })
        .catch(error => {
            if (error.response.status === 422) {
                message.value = error.response.data.message;
            }
        });
}


</script>
