import { createRouter, createWebHistory } from "vue-router";
import axios from 'axios';
import HomePage from "../pages/HomePage.vue";
import AboutPage from "../pages/AboutPage.vue";
import LoginPage from "../pages/LoginPage.vue";
import NotFoundPage from "../pages/NotFoundPage.vue";


const routes = [
    {
        path: '/',
        name: 'HomePage',
        component: HomePage
    },
    {
        path: '/about',
        name: 'AboutPage',
        component: AboutPage
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: LoginPage
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFoundPage',
        component: NotFoundPage
    }
]

const router = createRouter(
    {
        history: createWebHistory(),
        linkActiveClass: 'active',
        routes
    }
);

router.beforeEach(async (to, from, next) => {

    const token = localStorage.getItem('token')
    const logged = localStorage.getItem('logged')

    if (!token && to.name !== 'LoginPage') {
        // console.log(to.name);
        // return router.push({ name: 'LoginPage' })
        next({ name: 'LoginPage' })
    } else {
        axios.defaults.headers.common['Accept'] = `application/json`;
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        next()
    }
    // if (
    //     // make sure the user is authenticated
    //     !isAuthenticated &&
    //     to.name !== 'Login'
    // ) {
    //     // redirect the user to the login page
    //     return { name: 'Login' }
    // }
})

export default router
