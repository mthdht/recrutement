<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import InputError from '@/components/InputError.vue'
import FileImageInput from '@/components/FileImageInput.vue'
import AddressAutocomplete from '@/components/AddressAutocomplete.vue'
import Button from '@/components/ui/button/Button.vue'

const props = defineProps<{
  form: any,
  mode: 'create' | 'edit',
  logoUrl?: string,
  deleteLogoUrl?: string
}>()

</script>

<template>
  <form @submit.prevent="$emit('submit')" class="flex flex-col gap-4">
    <div class="flex flex-wrap gap-4 container">
      <div class="logo-input-wrapper w-full lg:w-1/4 space-y-4">
        <Label>Logo</Label>
        <FileImageInput
          v-model="form.logo"
          v-model:error="form.errors.logo"
          :logo-url="mode === 'edit' ? logoUrl : ''"
          :delete-logo-url="mode === 'edit' ? deleteLogoUrl : ''"
        />
      </div>

      <div class="text-input-wrapper grow space-y-6">
        <div class="grid gap-3">
          <Label for="name">Nom de l'établissement <span class="text-red-500">*</span></Label>
          <Input id="name" v-model="form.name" :aria-invalid="!!form.errors.name" />
          <InputError v-if="form.errors.name" :message="form.errors.name" />
        </div>

        <div class="grid gap-3">
          <Label for="website">Site web</Label>
          <Input id="website" v-model="form.website" placeholder="www.monsite.com" :aria-invalid="!!form.errors.website" />
          <InputError v-if="form.errors.website" :message="form.errors.website" />
        </div>

        <div class="grid gap-3">
          <Label for="phone">Téléphone</Label>
          <Input id="phone" v-model="form.phone" placeholder="07 08 09 01 02" :aria-invalid="!!form.errors.phone" />
          <InputError v-if="form.errors.phone" :message="form.errors.phone" />
        </div>

        <div class="grid gap-3">
          <Label for="description">Description</Label>
          <Textarea id="description" class="min-h-40" v-model="form.description" :aria-invalid="!!form.errors.description" />
          <InputError v-if="form.errors.description" :message="form.errors.description" />
        </div>

        <AddressAutocomplete 
          v-model:street="form.street"
          v-model:postcode="form.postcode"
          v-model:city="form.city"
          v-model:country="form.country"
          v-model:address="form.address"
        />
      </div>
    </div>

    <Button :disabled="form.processing" type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">
      {{ mode === 'create' ? 'Créer' : 'Modifier' }}
    </Button>
  </form>
</template>
