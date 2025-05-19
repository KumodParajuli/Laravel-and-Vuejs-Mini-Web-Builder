import './bootstrap';
import { createApp } from 'vue';
import Site from './components/site/Site.vue';
import router from './router/site/index.js';
import store from './store/site/index.js';

const site = createApp(Site)

site.use(router);
site.use(store);
site.mount('#site')