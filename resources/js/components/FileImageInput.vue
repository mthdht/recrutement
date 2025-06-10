<script setup lang="ts">
import { ImagePlus, Trash, X } from 'lucide-vue-next'
import InputError from '@/components/InputError.vue'
import { ref, watch } from 'vue'
import { useImagePreview } from '@/composables/useImagePreview'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  logoUrl: String,
  deleteLogoUrl: String
})
const logo = defineModel<File | null>()
const error = defineModel<string>('error')

const inputRef = ref<HTMLInputElement | null>(null)
const { previewUrl, updatePreview } = useImagePreview(props.logoUrl ? '/storage/' + props.logoUrl : null)

watch(logo, (file) => {
  updatePreview(file ?? null)
})
</script>

<template>
  <div class="space-y-2">
    <input
      type="file"
      accept="image/*"
      class="hidden"
      ref="inputRef"
      @change="(e: Event) => logo = (e.target as HTMLInputElement)?.files?.[0] || null"
    />

    <div
      class="lg:aspect-video cursor-pointer overflow-hidden rounded-xl border bg-slate-50 relative group flex justify-center"
    >
      <img
        v-if="previewUrl"
        :src="previewUrl"
        alt="Prévisualisation"
        class="size-36 lg:size-full object-cover"
         @click="inputRef?.click()"
      />
      <ImagePlus v-else class="size-20 lg:size-full p-4 text-slate-500" :absoluteStrokeWidth="true"  @click="inputRef?.click()"/>

      <div class="delete-image absolute inset-0 group-hover:bg-slate-500/30 z-50 pointer-events-none" v-if="deleteLogoUrl">
        <Link :href="deleteLogoUrl" method="delete" class="cursor-pointer pointer-events-auto hidden group-hover:block float-right m-2 p-2 border border-slate-700 bg-white rounded-full hover:bg-slate-50">
          <Trash class=""></Trash>
        </Link>
      </div>
    </div>

    <InputError :message="error" />
  </div>
</template>
