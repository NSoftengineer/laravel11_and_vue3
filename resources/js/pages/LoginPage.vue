<template>
    <div>
        <Navbar />
        <p v-if="message" class="error">{{ message }}</p>
        <div class="container">
            <div class="row d-flex justify-content-center pt-5">
                <div class="col-md-4">
                    <div class="card border border-danger">
                        <div class="card-body ">
                            <form @submit.prevent="submit" class="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" v-model="form.email" class="form-control" id="email"
                                        placeholder="email@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" v-model="form.password" class="form-control" id="password"
                                        placeholder="password">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="form.email" type="text" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input v-model="form.password" type="password" class="form-input">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-input">Login</button>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from "../components/header/Navbar.vue";
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const form = reactive({
    email: '',
    password: ''
});
const message = ref();
function submit() {
    message.value = '';
    axios.post('login', form)
        .then(response => {
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('logged', true);
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
            // router.push({ name: 'HomePage' });
            window.location.href = "/"
        })
        .catch(error => {
            if (error.response.status === 422) {
                message.value = error.response.data.message;
            }
        })
        .finally(() => form.password = '');
}
</script>
