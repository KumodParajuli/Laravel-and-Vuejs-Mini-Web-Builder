import './bootstrap';
import { createApp } from 'vue';
import Site from './components/Site.vue';
import router from './router/site/index.js';

const site = createApp(Site)

site.use(router);
site.mount('#site')