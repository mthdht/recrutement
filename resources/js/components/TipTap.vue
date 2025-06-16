<template>
  <div class="wrapper shadow border divide-y rounded" v-if="editor">
    <div class="actions p-1.5 flex">
      <div class="undeo-redo flex">
        <button
          @click="editor?.chain().focus().undo().run()"
          :disabled="!editor?.can().undo()"
          class="p-2 rounded-lg hover:bg-slate-200 disabled:opacity-30 cursor-pointer size-8 flex items-center justify-center"
          :class="{ 'bg-slate-100': editor?.isActive('undo') }"
          aria-label="Annuler"
          type="button"
          >
          <Undo2 class="size-4"></Undo2>
        </button>
          
        <button
          @click="editor?.chain().focus().redo().run()"
          :disabled="!editor?.can().redo()"
          class="p-2 rounded-lg hover:bg-slate-200 disabled:opacity-30 cursor-pointer size-8 flex items-center justify-center"
          :class="{ 'bg-slate-100': editor?.isActive('redo') }"
          aria-label="refaire"
          type="button"
        >
          <Redo2 class="size-4"></Redo2>
        </button>
      </div>

      <div class="w-0 border mx-2"></div>

      <div class="flex gap-1">
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <button 
              class="size-8 flex items-center gap-0.5 p-1 rounded-lg hover:bg-slate-200 disabled:opacity-30 cursor-pointer hover:text-slate-900"
              :class="{ 'bg-slate-100': editor?.isActive('heading') }"
              type="button"
            >
              <span>H</span>
              <ChevronDown class="size-3"></ChevronDown>
            </button>
          </DropdownMenuTrigger>

          <DropdownMenuContent align="start">
            <ul class="text-slate-700">
              <li>
                <button
                  @click="editor?.chain().focus().toggleHeading({level: 1}).run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('heading', {level: 1}) }"
                  aria-label="heading 1"
                  type="button"
                >
                  <span>H1</span> <span>Heading 1</span>
                </button>
              </li>

              <li>
                <button
                  @click="editor?.chain().focus().toggleHeading({level: 2}).run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('heading', {level: 2}) }"
                  aria-label="heading 2"
                  type="button"
                >
                  <span>H2</span> <span>Heading 2</span>
                </button>
              </li>

              <li>
                <button
                  @click="editor?.chain().focus().toggleHeading({level: 3}).run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('heading', {level: 3}) }"
                  aria-label="heading 3"
                  type="button"
                >
                  <span>H3</span> <span>Heading 3</span>
                </button>
              </li>
            </ul>
          </DropdownMenuContent>
        </DropdownMenu>

        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <button 
              class="size-8 flex items-center gap-0.5 p-1 rounded-lg hover:bg-slate-200 disabled:opacity-30 cursor-pointer hover:text-slate-900"
              :class="{ 'bg-slate-100': editor?.isActive('') }"
              type="button"
            >
              <List class="size-5" :absolute-stroke-width="true"></List>
            </button>
          </DropdownMenuTrigger>

          <DropdownMenuContent align="start">
            <ul class="text-slate-700">
              <li>
                <button
                  @click="editor?.chain().focus().toggleBulletList().run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('bulletList') }"
                  aria-label="bullet list"
                  type="button"
                >
                  <List class="size-5"></List> 
                  <span>Bullet list</span>
                </button>
              </li>

              <li>
                <button
                  @click="editor?.chain().focus().toggleOrderedList().run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('orderedList') }"
                  aria-label="ordered list"
                  type="button"
                >
                  <ListOrdered class="size-5"></ListOrdered>
                  <span>Ordered list</span>
                </button>
              </li>

              <li>
                <button
                  @click="editor?.chain().focus().toggleTaskList().run()"
                  class="p-1.5 rounded hover:bg-slate-200 disabled:opacity-30 cursor-pointer flex items-center gap-2 w-full"
                  :class="{ 'bg-slate-100': editor?.isActive('taskList') }"
                  aria-label="ordered list"
                  type="button"
                >
                  <ListTodo class="size-5"></ListTodo>
                  <span>Task list</span>
                </button>
              </li>
            </ul>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </div>

    <editor-content :editor="editor" class="p-8"/>
  </div>
</template>

<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import TaskItem from '@tiptap/extension-task-item'
import TaskList from '@tiptap/extension-task-list'

import { Undo2, Redo2, ChevronDown, List, ListOrdered, ListTodo } from 'lucide-vue-next'
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from './ui/dropdown-menu'

const editor = useEditor({
  content: "<p>I'm running Tiptap with Vue.js. 🎉</p>",
  extensions: [
    StarterKit, 
    TaskList, 
    TaskItem.configure({
          nested: true,
    })
  ],
})
</script>

<style>
@reference "tailwindcss";

.tiptap {
  @apply focus:outline-none;
}

.tiptap h1 {
  @apply text-2xl font-semibold;
} 

.tiptap h2 {
  @apply text-xl font-semibold;
} 

.tiptap h3 {
  @apply text-lg font-semibold;
} 

.tiptap ul li {
  @apply list-disc ml-4;
}

.tiptap ol li {
  @apply list-decimal ml-4
}

.tiptap li * {
  @apply inline space-x-2;
}
</style>
