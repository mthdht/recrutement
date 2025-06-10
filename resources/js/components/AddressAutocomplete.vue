<template>
  <div class="space-y-4">
    <div class="relative">
      <Label for="autocomplete" class="mb-3">Adresse</Label>
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

    <!-- <div v-if="address" class="grid grid-cols-2 gap-3">
      <div class="space-y-2">
        <Label>Rue</Label>
        <Input v-model="street" />
      </div>
      <div class="space-y-2">
        <Label>Code postal</Label>
        <Input v-model="postcode" />
      </div>
      <div class="space-y-2">
        <Label>Ville</Label>
        <Input v-model="city" />
      </div>
      <div class="space-y-2">
        <Label>Pays</Label>
        <Input v-model="country" />
      </div>
    </div> -->
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import axios from 'axios'
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'

const street = defineModel<string>('street')
const postcode = defineModel<string>('postcode')
const city = defineModel<string>('city')
const country = defineModel<string>('country')
const address = defineModel<string>('address')

const addressQuery = ref(address)
const suggestions = ref<any[]>([])
const showSuggestions = ref(false)
const isSelecting = ref(false)

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
  street.value = props.street
  postcode.value = props.postcode
  city.value = props.city
  country.value = 'France' // ou `result.country` si dispo
  address.value = props.label

  addressQuery.value = props.label
  showSuggestions.value = false

  setTimeout(() => {
    isSelecting.value = false
  }, 200)
}
</script>
