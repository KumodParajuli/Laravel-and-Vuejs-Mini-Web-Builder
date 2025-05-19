<template>
  <div class="container my-4">
    <h3>Navigation Settings</h3>

    <!-- Add New Navigation Item -->
    <div class="card p-3 mb-4">
      <h5>Add Navigation Item</h5>
      <input v-model="newItem.label" placeholder="Label" class="form-control mb-2" />
      <select v-model="newItem.page_id" class="form-select mb-2">
        <option disabled value="">Select Page</option>
        <option v-for="page in pages" :key="page.id" :value="page.id">
          {{ page.title }}
        </option>
      </select>
      <button @click="addItem" class="btn btn-primary">Add</button>
    </div>

    <!-- Navigation List -->
    <div v-for="(item, index) in navigation" :key="index" class="card p-3 mb-2">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <strong>{{ item.label }}</strong><br />
          <small>Page: {{ getPageTitle(item.page_id)  }}</small>
        </div>
        <div>
          <button @click="shiftUp(index)" class="btn btn-sm btn-secondary me-1" :disabled="index === 0">↑</button>
          <button @click="shiftDown(index)" class="btn btn-sm btn-secondary me-1" :disabled="index === navigation.length - 1">↓</button>
          <button @click="editItem(index)" class="btn btn-sm btn-warning me-1">Edit</button>
          <button @click="deleteItem(index)" class="btn btn-sm btn-danger">Delete</button>
        </div>
      </div>

      <div v-if="editIndex === index" class="mt-2">
        <input v-model="editForm.label" placeholder="Label" class="form-control mb-2" />
        <select v-model="editForm.page_id" class="form-select mb-2">
          <option disabled value="">Select Page</option>
          <option v-for="page in pages" :key="page.id" :value="page.id">
            {{ page.title }}
          </option>
        </select>
        <button @click="updateItem(index)" class="btn btn-success me-2">Save</button>
        <button @click="cancelEdit" class="btn btn-secondary">Cancel</button>
      </div>
    </div>

    <!-- Save Navigation -->
    <button @click="saveNavigation" class="btn btn-success mt-3">Save Navigation</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const pages = ref([])
const navigation = ref([])
const newItem = ref({ label: '', page_id: '' })
const editForm = ref({ label: '', page_id: '' })
const editIndex = ref(null)

onMounted(async () => {
  const res = await axios.get('/api/pagessettings')
  pages.value = res.data
  loadNavigation()
})

const getPageTitle = (pageId) => { 
  const page = pages.value.find(p => p.id === pageId)
  return page ? page.title : 'Unknown Page'
}

const addItem = () => {
  if (!newItem.value.label || !newItem.value.page_id) return
  navigation.value.push({
    ...newItem.value,
    order: navigation.value.length,
  })
  newItem.value = { label: '', page_id: '' }
}

const editItem = (index) => {
  editForm.value = { ...navigation.value[index] }
  editIndex.value = index
}

const updateItem = (index) => {
  navigation.value[index] = { ...editForm.value, order: index }
  editIndex.value = null
}

const deleteItem = (index) => {
  navigation.value.splice(index, 1)
  reorderNavigation()
}

const cancelEdit = () => {
  editIndex.value = null
}

const shiftUp = (index) => {
  if (index === 0) return
  const temp = navigation.value[index]
  navigation.value[index] = navigation.value[index - 1]
  navigation.value[index - 1] = temp
  reorderNavigation()
}

const shiftDown = (index) => {
  if (index === navigation.value.length - 1) return
  const temp = navigation.value[index]
  navigation.value[index] = navigation.value[index + 1]
  navigation.value[index + 1] = temp
  reorderNavigation()
}

const reorderNavigation = () => {
  navigation.value.forEach((item, i) => {
    item.order = i
  })
}

const saveNavigation = async () => { 
  await axios.post('/api/navigations', { navigation: navigation.value })
  alert('Navigation saved successfully!')
}

const loadNavigation = async () => {
  const res = await axios.get('/api/navigations')
  navigation.value = res.data.navigation || [] 
}
</script>
