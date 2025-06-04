<template>
  <div class="space-y-4">
    <div class="relative">
      <Label for="autocomplete">Adresse</Label>
      <Input
        id="autocomplete"
        v-model="addressQuery"
        placeholder="Commencez à taper une adresse..."
        autocomplete="off"
      />

      <ul
        v-if="showSuggestions && suggestions.length"
        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-md mt-1 max-h-60 overflow-y-auto"
      >
        <li
          v-for="suggestion in suggestions"
          :key="suggestion.properties.id"
          @click="selectSuggestion(suggestion)"
          class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
        >
            {{ suggestion.properties.label }}
        </li>
      </ul>
    </div>

    <div v-if="selected.address" class="grid grid-cols-2 gap-4">
      <div>
        <Label>Rue</Label>
        <Input v-model="selected.street" />
      </div>
      <div>
        <Label>Code postal</Label>
        <Input v-model="selected.postcode" />
      </div>
      <div>
        <Label>Ville</Label>
        <Input v-model="selected.city" />
      </div>
      <div>
        <Label>Pays</Label>
        <Input v-model="selected.country" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import axios from 'axios'
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'

const selected = defineModel({
    default: {
        street: '',
        postcode: '',
        city: '',
        country: 'France', // L'API ne le renvoie pas, donc on force FR
        address: '',
    }
})
const addressQuery = ref(selected.value.address)
const suggestions = ref<any[]>([])
const showSuggestions = ref(false)
const isSelecting = ref(false)



let debounce: number | null = null

watch(addressQuery, async (value) => {
    if (isSelecting.value) return

    if (!value || value.length < 3) {
        suggestions.value = []
        return
    }

    try {
        const res = await axios.get('https://api-adresse.data.gouv.fr/search/', {
        params: {
            q: value,
            limit: 5,
        },
        })

        suggestions.value = res.data.features || []
        showSuggestions.value = true
    } catch (e) {
        console.error('Erreur recherche adresse:', e)
        suggestions.value = []
    }
 
})

function selectSuggestion(suggestion: any) {
  const props = suggestion.properties

  isSelecting.value = true

  selected.value = {
    street: [props.housenumber, props.street].filter(Boolean).join(' '),
    postcode: props.postcode || '',
    city: props.city || '',
    country: 'France',
    address: props.label,
  }

  addressQuery.value = props.label
  showSuggestions.value = false

  setTimeout(() => {
    isSelecting.value = false
  }, 200)
}
</script>
