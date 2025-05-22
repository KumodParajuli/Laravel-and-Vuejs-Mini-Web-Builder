<template>
  <div class="container py-5">
    <div class="row mb-4">
      <div class="col">
        <h2 class="text-center">📝 Live HTML Page Editor <span class="mt-4 text-end">
            <button @click="savePage" class="btn btn-success">
              <i class="bi bi-save"></i> Save Page
            </button>
            <button v-if="editingId" @click="resetEditor" class="btn btn-secondary ms-2">
              Cancel Edit
            </button>
          </span></h2>

      </div>
    </div>
    <div class="container my-4">
      <div class="row">
        <div class="col-md-3">
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
                    <td><a href="#" @click="editPage(page)" class="link" aria-current="page">{{ page.title }}</a></td>
                    <td>
                      <router-link :to="`/banner/${page.id}`" class="btn btn-light m-0 btn-info"
                        aria-current="page">Bn</router-link>
                      <button class="btn btn-sm btn-danger" @click="deletePage(page.id)">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <!-- 70% Column -->
          <div class="p-3 border bg-white">

            <!-- Title Input -->
            <div class="mb-3">
              <label class="form-label fw-bold">Page Title</label>
              <input type="text" v-model="title" class="form-control" placeholder="Enter page title..." />
            </div>

            <div class="card shadow-sm">
              <div class="card-header bg-white border-bottom d-flex flex-wrap gap-2">
                <button @click="toggle('bold')" :class="buttonClass('bold')" title="Bold"><i
                    class="fas fa-bold"></i></button>
                <button @click="toggle('italic')" :class="buttonClass('italic')" title="Italic"><i
                    class="fas fa-italic"></i></button>
                <button @click="toggle('underline')" :class="buttonClass('underline')" title="Underline"><i
                    class="fas fa-underline"></i></button>
                <button @click="toggle('highlight')" :class="buttonClass('highlight')" title="Highlight"><i
                    class="fas fa-highlighter"></i></button>
                <button @click="toggleHeading" :class="buttonClass('heading')" title="Heading"><i
                    class="fas fa-heading"></i></button>
                <button @click="toggle('bulletList')" :class="buttonClass('bulletList')" title="Bullet List"><i
                    class="fas fa-list-ul"></i></button>
                <button @click="toggle('orderedList')" :class="buttonClass('orderedList')" title="Ordered List"><i
                    class="fas fa-list-ol"></i></button>
                <button @click="addLink" class="btn btn-outline-secondary btn-sm" title="Insert Link"><i
                    class="fas fa-link"></i></button>
                <button @click="addImage" class="btn btn-outline-secondary btn-sm" title="Insert Image"><i
                    class="fas fa-image"></i></button>
                <button @click="toggle('codeBlock')" :class="buttonClass('codeBlock')" title="Code"><i
                    class="fas fa-code"></i></button>
                <button @click="setAlign('left')" class="btn btn-outline-secondary btn-sm"><i
                    class="fas fa-align-left"></i></button>
                <button @click="setAlign('center')" class="btn btn-outline-secondary btn-sm"><i
                    class="fas fa-align-center"></i></button>
                <button @click="setAlign('right')" class="btn btn-outline-secondary btn-sm"><i
                    class="fas fa-align-right"></i></button>
                <button @click="insertContentBlock" class="btn btn-outline-secondary btn-sm"
                  title="Insert Content Block">
                  <i class="fas fa-layer-group"></i> Block
                </button>
                <button @click="insertHeroBlock" class="btn btn-outline-primary btn-sm">Hero</button>
                <button @click="insertFeaturesBlock" class="btn btn-outline-primary btn-sm">Features</button>
                <button @click="insertImageTextBlock" class="btn btn-outline-primary btn-sm">Image+Text</button>
                <button @click="insertTestimonialBlock" class="btn btn-outline-primary btn-sm">Testimonial</button>
                <button @click="insertCTABlock" class="btn btn-outline-primary btn-sm">CTA</button>
              </div>

              <div class="card-body p-3">
                <editor-content :editor="editor" class="editor-body form-control" style="min-height: 400px;" />
              </div>

              <div class="card-footer bg-white border-top" style="height: 1px; visibility: hidden;">
                <h6 class="mb-2 text-muted">HTML Output</h6>
                <textarea class="form-control" rows="5" v-model="htmlOutput" readonly />
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import '@fortawesome/fontawesome-free/css/all.min.css'
import { ref, onBeforeUnmount, onMounted } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

import 'bootstrap/dist/css/bootstrap.min.css'
import Underline from '@tiptap/extension-underline'
import Highlight from '@tiptap/extension-highlight'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import TextAlign from '@tiptap/extension-text-align'

const htmlOutput = ref('')
const childRef = ref()
const title = ref('')

const pages = ref([])
const editingId = ref(null)
const editorRef = ref(null)

const insertContentBlock = () => {
  const title = "Block title"
  const imageUrl = ''
  const bodyText = 'Your body text here...'

  if (!title || !bodyText) return

  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'heading', attrs: { level: 2 }, content: [{ type: 'text', text: title }] },
      { type: 'image', attrs: { src: imageUrl, alt: title } },
      { type: 'paragraph', content: [{ type: 'text', text: bodyText }] },
    ])
    .run()
}

const insertHeroBlock = () => {
  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'heading', attrs: { level: 1 }, content: [{ type: 'text', text: 'Welcome to Our Website!' }] },
      { type: 'paragraph', content: [{ type: 'text', text: 'Discover amazing features and services we offer.' }] },
      { type: 'image', attrs: { src: 'https://via.placeholder.com/800x300', alt: 'Hero Image' } },
    ])
    .run()
}
const insertFeaturesBlock = () => {
  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'heading', attrs: { level: 2 }, content: [{ type: 'text', text: 'Features' }] },
      {
        type: 'bulletList', content: [
          { type: 'listItem', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Fast and Reliable' }] }] },
          { type: 'listItem', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'User-Friendly Interface' }] }] },
          { type: 'listItem', content: [{ type: 'paragraph', content: [{ type: 'text', text: '24/7 Support' }] }] },
        ]
      }
    ])
    .run()
}

const insertImageTextBlock = () => {
  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'image', attrs: { src: 'https://via.placeholder.com/300x200', alt: 'Sample Image' } },
      { type: 'paragraph', content: [{ type: 'text', text: 'This is a descriptive text accompanying the image.' }] },
    ])
    .run()
}
const insertTestimonialBlock = () => {
  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'paragraph', content: [{ type: 'text', text: '“This product changed my life!”' }] },
      { type: 'paragraph', content: [{ type: 'text', text: '— Happy Customer' }] },
    ])
    .run()
}
const insertCTABlock = () => {
  editor
    .chain()
    .focus()
    .insertContent([
      { type: 'heading', attrs: { level: 2 }, content: [{ type: 'text', text: 'Ready to Get Started?' }] },
      { type: 'paragraph', content: [{ type: 'text', text: 'Join now and start your journey with us today.' }] },
    ])
    .run()
}

const fetchPages = async () => {
  const res = await axios.get('/api/pages')
  pages.value = res.data
}

const savePage = async () => {

  try {
    const payload = {
      title: title.value,
      html_content: editor.getHTML(),
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
  editor.commands.setContent(page.html_content)
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
  editor.commands.setContent('<h1>Hello, world!</h1>')
}
onBeforeUnmount(() => {
  editor.destroy()
})
onMounted(fetchPages)


const editor = new Editor({
  extensions: [
    StarterKit,
    Underline,
    Highlight,
    Link,
    Image,
    TextAlign.configure({ types: ['heading', 'paragraph'] }),
  ],
  content: '<p>Start writing something...</p>',
  onUpdate: ({ editor }) => {
    htmlOutput.value = editor.getHTML()
  },
})

const toggle = (action) => {
  editor.chain().focus()[`toggle${capitalize(action)}`]().run()
}

const toggleHeading = () => {
  editor.chain().focus().toggleHeading({ level: 2 }).run()
}

const addImage = () => {
  const url = prompt('Image URL')
  if (url) editor.chain().focus().setImage({ src: url }).run()
}

const addLink = () => {
  const url = prompt('Link URL')
  if (url) editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
}

function setAlign(align) {
  editor.chain().focus().setTextAlign(align).run()
}

const buttonClass = (feature) => {
  return [
    'btn',
    'btn-outline-secondary',
    'btn-sm',
    editor.isActive(feature) ? 'active' : '',
  ]
}

const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)
defineExpose({ editor, htmlOutput })

</script>

<style scoped>
.editor-body {
  border: 1px solid #ddd;
  background: #fdfdfd;
  padding: 1rem;
  overflow-y: auto;
  height: 500px;
}

/* Target the actual editable content inside tiptap */
::v-deep(.ProseMirror) {
  min-height: 100%;
  height: 100%;
  padding: 10px;
  overflow-y: auto;
  outline: none;
}

.btn.active {
  background-color: #0d6efd;
  color: #fff;
  border-color: #0d6efd;
}
</style>
