<script setup lang="ts">
import InputError from '@/components/InputError.vue'
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import AddressAutocomplete from '@/components/AddressAutocomplete.vue'
import FileImageInput from '@/components/FileImageInput.vue'

const props = defineProps<{
  form: any,
  mode: 'create' | 'edit',
  
}>()
</script>

<template>
  <form @submit.prevent="$emit('submit')" class="flex flex-col gap-4">
    <div class="flex flex-wrap gap-4 container">
      <div class="logo-input-wrapper w-full lg:w-1/4 space-y-4">
        <Label>Logo</Label>
        <FileImageInput
          v-model="props.form.logo"
          v-model:error="props.form.errors.logo"
        />
      </div>

      <div class="text-input-wrapper grow space-y-6">
        <div class="grid gap-3">
          <Label>Nom de l’organisation <span class="text-red-500">*</span></Label>
          <Input v-model="props.form.name" />
          <InputError :message="props.form.errors.name" />
        </div>

        <div class="grid gap-3">
          <Label>Site web</Label>
          <Input v-model="props.form.website" placeholder="www.monsite.com" />
          <InputError :message="props.form.errors.website" />
        </div>

        <div class="grid gap-3">
          <Label>Téléphone</Label>
          <Input v-model="props.form.phone" placeholder="07 08 09 01 02" />
          <InputError :message="props.form.errors.phone" />
        </div>

        <div class="grid gap-3">
          <Label>Description</Label>
          <Textarea v-model="props.form.description" class="min-h-40" />
          <InputError :message="props.form.errors.description" />
        </div>

        <AddressAutocomplete
          v-model:street="props.form.street"
          v-model:postcode="props.form.postcode"
          v-model:city="props.form.city"
          v-model:country="props.form.country"
          v-model:address="props.form.address"
        />
      </div>
    </div>

    <Button :disabled="props.form.processing" type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">
      {{ props.mode === 'edit' ? 'Modifier' : 'Créer' }}
    </Button>
  </form>
</template>