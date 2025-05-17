import { createRouter, createWebHistory } from "vue-router";
import Home from '../components/Home.vue';
import Register from '../components/Auth/Register.vue';
import Login from '../components/Auth/Login.vue';
import Dashboard from '../components/Auth/Dashboard.vue';
import NotFound from '../components/Errors/404.vue';
// import store from '../store/index.js';

const routes = [
     {
        path: '/:any',
        name: 'notfound',
        component: NotFound
    },
    {
        path: '/',
        name: 'Home',
        component: Home
    }
    ,
      {
        path: '/register',
        name: 'Register',
        component: Register
    },
      {
        path: '/login',
        name: 'Login',
        component: Login
    },
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active'
});

// router.beforeEach((to, form, next) => {

//     const isAuthenticated = store.getters.authStatus

//     if(to.meta.requiresAuth && !isAuthenticated){
//       next('/login')
//     }
//     else if ( (to.name == 'login' || to.name == 'register') && isAuthenticated) {
//       next('/dashboard')
//     }
//     else {
//       next()
//     }
// });

export default router;