<template>
  <div class="container py-5">
    <div class="row mb-4">
      <div class="col">
        <h2 class="text-center">📝 Live HTML Page Editor</h2>
      </div>
    </div>
    <div class="container my-4">
      <div class="row">
        <div class="col-md-4">
          <!-- 30% Column -->
          <div class="p-3 border bg-light">
            <!-- Page List -->
            <div class="mt-5">
              <h4 class="mb-3">📁 Stored Pages</h4>
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>Title</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="page in pages" :key="page.id">
                    <td>{{ page.title }}</td>
                    <td>
                      <router-link :to="`/banner/${page.id}`" class="btn btn-sm btn-info me-2"
                        aria-current="page">Banner</router-link>
                      <button class="btn btn-sm btn-info me-2" @click="editPage(page)">
                        <i class="bi bi-pencil-square"></i> Edit
                      </button>
                      <button class="btn btn-sm btn-danger" @click="deletePage(page.id)">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <!-- 70% Column -->
          <div class="p-3 border bg-white">
            <!-- Title Input -->
            <div class="mb-3">
              <label class="form-label fw-bold">Page Title</label>
              <input type="text" v-model="title" class="form-control" placeholder="Enter page title..." />
            </div>
            
             
            <div class="row">
              <div class="col-md-6">
                <label class="form-label fw-bold">HTML Editor</label>
                <textarea v-model="htmlContent" rows="16" class="form-control font-monospace"
                  placeholder="Write HTML here..."></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Live Preview</label>
                <div class="border rounded p-2 bg-white" style="min-height: 400px;">
                  <iframe :srcdoc="htmlContent" class="w-100" style="height: 100%; border: none;"></iframe>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 text-end">
              <button @click="savePage" class="btn btn-success">
                <i class="bi bi-save"></i> Save Page
              </button>
              <button v-if="editingId" @click="resetEditor" class="btn btn-secondary ms-2">
                Cancel Edit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import TiptapEditor from '../../components/Pages/TiptapEditor.vue';

import axios from '../../axios.js';
import { ref, onMounted } from 'vue'
 
const title = ref('')
const htmlContent = ref('<h1>Hello, world!</h1>')
const pages = ref([])
const editingId = ref(null)

const fetchPages = async () => {
  const res = await axios.get('/api/pages')
  pages.value = res.data
}

const savePage = async () => {
  try {
    const payload = {
      title: title.value,
      html_content: htmlContent.value,
    }

    if (editingId.value) {
      await axios.put(`/api/pages/${editingId.value}`, payload)
    } else {
      await axios.post('/api/pages', payload)
    }

    await fetchPages()
    resetEditor()
    alert('New page saved successfully !')
  } catch (err) {
    console.error(err)
    alert('Failed to save page')
  }
}

const editPage = (page) => {
  editingId.value = page.id
  title.value = page.title
  htmlContent.value = page.html_content
}

const deletePage = async (id) => {
  if (confirm('Are you sure you want to delete this page?')) {
    await axios.delete(`/api/pages/${id}`)
    await fetchPages()
  }
}

const resetEditor = () => {
  editingId.value = null
  title.value = ''
  htmlContent.value = '<h1>Hello, world!</h1>'
}

onMounted(fetchPages)
</script>

<style scoped>
iframe {
  min-height: 400px;
}
</style>
