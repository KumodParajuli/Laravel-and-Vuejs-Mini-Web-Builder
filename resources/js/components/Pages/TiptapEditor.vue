<template>
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
        </div>

        <div class="card-body p-3">
            <editor-content :editor="editor" class="editor-body form-control" />
        </div>

        <div class="card-footer bg-white border-top">
            <h6 class="mb-2 text-muted">HTML Output</h6>
            <textarea class="form-control" rows="5" v-model="htmlOutput" readonly />
        </div>
    </div>
</template>

<script setup>
import 'bootstrap/dist/css/bootstrap.min.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Highlight from '@tiptap/extension-highlight'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
// import CodeBlock from '@tiptap/extension-code-block'
import TextAlign from '@tiptap/extension-text-align'
import { ref, onBeforeUnmount } from 'vue'

const htmlOutput = ref('')

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
onBeforeUnmount(() => {
    editor.destroy()
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

const setAlign = (align) => {
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
    min-height: 200px;
    border: none;
    background: #fdfdfd;
    font-family: 'Segoe UI', sans-serif;
}

.btn.active {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}
</style>
