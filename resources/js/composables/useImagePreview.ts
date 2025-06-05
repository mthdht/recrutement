import { ref } from 'vue'

export function useImagePreview(logo: string | null) {
  const previewUrl = ref<string | null>(logo)

  function updatePreview(file: File | null) {
    if (file) {
      previewUrl.value = URL.createObjectURL(file)
    } else {
      previewUrl.value = null
    }
  }

  return {
    previewUrl,
    updatePreview,
  }
}