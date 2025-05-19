<template>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-header">
            Website Settings
          </div>
          <form @submit.prevent="saveSettings" class="m-3">
            <input v-model="settings.site_title" placeholder="Site Title" class="form-control mb-2" />

            <select v-model="settings.homepage_id" class="form-control mb-2">
              <option v-for="page in pages" :key="page.id" :value="page.id">
                {{ page.title }}
              </option>
            </select>

            <textarea v-model="settings.footer_content" placeholder="Footer Content"
              class="form-control mb-2"></textarea>

            <button class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../../axios.js';

const settings = ref({ site_title: '', homepage_id: '', footer_content: '' })
const pages = ref([])

const fetchSettings = async () => {
  const res = await axios.get('/api/settings')
  settings.value = res.data || {}
}

const fetchPages = async () => {
  const res = await axios.get('/api/pagessettings')
  pages.value = res.data
}

const saveSettings = async () => {
  await axios.put('/api/settings', settings.value)
  alert('Settings saved')
}

onMounted(() => {
  fetchSettings()
  fetchPages()
})
</script>
