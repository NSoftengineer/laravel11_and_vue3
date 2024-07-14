import './bootstrap';

import { createApp } from 'vue';
import app from './layouts/app.vue';

import router from './router/index.js';

import axios from 'axios';
// Set up axios globally:
window.axios = axios;
// Configure the default headers for axios:
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Define the base URL for all axios requests:
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
// const token = localStorage.getItem('token')
// if (token) {
//     console.log(token);
//     // router.push({ name: 'LoginPage' })
//     // window.location.href="/login"
// } else {

// }

// Create and mount the Vue app:
createApp(app).use(router).mount('#app');

