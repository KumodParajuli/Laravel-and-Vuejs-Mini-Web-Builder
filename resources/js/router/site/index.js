import { createRouter, createWebHistory } from "vue-router";
import Page from '../../components/site/Page.vue';
import Home from '../../components/site/Home.vue';
import NotFound from '../../components/site/404.vue';
 

const routes = [
     {
    path: '/site/:id',
    name: 'Innerpage',
    component: Page,
    props: true,
  },
  {
    path: '/',
    name: 'Home',
    component: Home,
    // props: { id: 0 }, // Optional: send default prop
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
       
];


const router = createRouter({
  history: createWebHistory(), // Make sure you're using web history
  routes,
})

export default router