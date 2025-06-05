<script setup lang="ts">
import { ImagePlus } from 'lucide-vue-next'
import InputError from '@/components/InputError.vue'
import { ref, watch } from 'vue'
import { useImagePreview } from '@/composables/useImagePreview'

const props = defineProps({
  logoUrl: String,
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
      class="aspect-video cursor-pointer overflow-hidden rounded-xl border bg-slate-50"
      @click="inputRef?.click()"
    >
      <img
        v-if="previewUrl"
        :src="previewUrl"
        alt="Prévisualisation"
        class="h-full w-full object-cover"
      />
      <ImagePlus v-else class="size-full p-4 text-slate-500" :absoluteStrokeWidth="true"/>
    </div>

    <InputError :message="error" />
  </div>
</template>
