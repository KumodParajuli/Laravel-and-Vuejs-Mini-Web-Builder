<template>

  <div class="container justify-content-center h1 text-center mt-5">
     {{ settings.site_title }} 
  </div>
  <!-- Navbar -->
    
  <nav class="navbar navbar-expand-lg bg-body shadow-sm">
    <div class="container-fluid">
      <button
        data-mdb-collapse-init
        class="navbar-toggler"
        type="button"
        data-mdb-target="#navbarExample01"
        aria-controls="navbarExample01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarExample01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li v-for="(item, index) in navigations" class="nav-item active">
            <router-link :to="`/site/${item.page_id}`" class="nav-link  " >{{ item.label }}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->


 
    <router-view :key="$route.fullPath"> </router-view>
    <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            {{ settings.footer_content }}
        </div>
        <!-- Copyright -->
    </footer>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios.js';
import { useRoute } from 'vue-router'

const settings = ref({ site_title: '', homepage_id: '', footer_content: '' })
const navigations = ref([])

const route = useRoute()
// const pageId = route.params.id

 

const fetchSettings = async () => {
  const res = await axios.get('/api/site_settings')
  settings.value = res.data || {}
}
 
const fetchNavigation = async () => {
  const res = await axios.get('/api/site_navigation')
  navigations.value = res.data.navigation || []
}

 
onMounted(() => {
  fetchSettings()
  fetchNavigation()
})
</script>


