<template>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-header">
            Page Banner | <router-link to="/pages" class="btn btn-sm btn-info me-2"
                aria-current="page"> << Go Back </router-link>
          </div>
          <div>
            <input v-model="banner.title" placeholder="Banner Title" class="form-control mb-2" />
            <input type="file" @change="onFileChange" class="form-control mb-2" />
            <button @click="saveBanner" class="btn btn-success">Save Banner</button>
            <div v-if="banner.image">
              <img :src="`/storage/${banner.image}`" class="mt-2" style="max-width: 100%;" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageId = route.params.id

const banner = ref({ title: '', image: '' })
const imageFile = ref(null)

const fetchBanner = async () => {
  try {
    const res = await axios.get(`/api/banner/${pageId}`)
    if (res.data) banner.value = res.data
  } catch (err) {
    console.warn('No existing banner found')
  }
}

const onFileChange = (e) => {
  imageFile.value = e.target.files[0]
}

const saveBanner = async () => {
  const form = new FormData()
  form.append('page_id', pageId)
  form.append('title', banner.value.title)
  if (imageFile.value) form.append('image', imageFile.value)

  try {
    const res = await axios.post('/api/banner', form)
    banner.value = res.data
  } catch (err) {
    console.error('Failed to save banner:', err)
  }
}

onMounted(fetchBanner)
</script>
