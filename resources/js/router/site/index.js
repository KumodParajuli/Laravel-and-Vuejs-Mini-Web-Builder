import { createRouter, createWebHistory } from "vue-router";
import Site from '../../components/site/Sitehome.vue';
import NotFound from '../../components/site/404.vue';
 

const routes = [
     {
        path: '/:any',
        name: 'notfound',
        component: NotFound
    },
    {
        path: '/',
        name: 'Site',
        component: Site
    }
   
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active'
});

 

export default router;