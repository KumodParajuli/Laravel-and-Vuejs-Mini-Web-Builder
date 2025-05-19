<template>
       <!-- Background image -->
  <div class="p-5 text-center bg-image"
  :style="`background-image: url('/storage/${pageBanner.image}'); height: 400px;`">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">
          <h1  class="mb-3">{{ pageBanner.title }}</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Background image -->
     <div class="container mt-2 mb-2">
          <div class="  shadow-sm">
               <div class="card-body">
               <h3 class="card-title mt-2 mb-2" >{{ pageDetail.title }}</h3>
               <div v-html="myHtml"> </div>
               </div>
          </div>
     </div>
     
</template>
<script setup>
import { ref, onMounted } from 'vue'
import axios from '../../axios.js';
import { useRoute } from 'vue-router'

const route = useRoute()
const pageId = route.params.id
const settings = ref({ site_title: '', homepage_id: '', footer_content: '' })
const pageDetail = ref({title: '', html_content: ''});
const myHtml = ref('');
const pageBanner = ref({image: '', title:'' });

const fetchSettings = async () => {
  const res = await axios.get('/api/site_settings')
  settings.value = res.data || {}
  const pg_id = settings.value.homepage_id
  const pgd = await axios.get('/api/page_detail/' + pg_id)
  pageDetail.value = pgd.data || {}
  myHtml.value = pageDetail.value.html_content
  const pgb = await axios.get('/api/page_banner/' + pg_id)
  pageBanner.value = pgb.data || {}
  console.log(pageBanner.value)
} 
const stripSlash = (str) => {
  return str.replace(/\//g, '')
}
onMounted(() => {
  fetchSettings()
})

 
</script>