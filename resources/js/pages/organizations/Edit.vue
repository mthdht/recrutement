<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AddressAutocomplete from '@/components/AddressAutocomplete.vue'

import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ImagePlus, OrigamiIcon } from 'lucide-vue-next';
import { useTemplateRef, watch, ref } from 'vue';

const props = defineProps<{
    organization: Organization;
}>();

const form = useForm({
    _method: 'put',
    title: props.organization.title || '',
    description: props.organization.description || '',
    street: props.organization.street || '',
    postcode: props.organization.postcode || '',
    city: props.organization.city || '',
    country: 'France', // L'API ne le renvoie pas, donc on force FR
    address: props.organization.address || '',
    logo: null as File | null
})

const input = useTemplateRef('input')
const logoPreview = ref('/storage/' + props.organization.logo);

watch(() => form.logo, (file) => {
  if (file instanceof File) {
    logoPreview.value = URL.createObjectURL(file);
  } else {
    logoPreview.value = '';
  }
});



function handleLogoChange(event: Event) {
  const input = event.target as HTMLInputElement
  if (input?.files?.[0]) {
    form.logo = input.files[0]
  }
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
    {
        title: props.organization.title,
        href: route('organizations.show', {organization: props.organization.id}),
    },
    {
        title: 'Modifier',
        href: route('organizations.edit', {organization: props.organization.id}),
    },
];


</script>

<template>
    <Head title="Organisations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
           <form @submit.prevent="form.post(route('organizations.update', {organization: organization.id}))" class="flex flex-col gap-4">
                <div class="flex gap-4">
                    <div class="logo-input-wrapper w-1/4">
                        <div class="grid gap-4">
                            <Label>Logo</Label>
                            <div class="relative">
                                <input
                                    type="file"
                                    name="logo"
                                    accept="image/*"
                                    @change="handleLogoChange"
                                    class="rounded border px-3 py-2 text-sm hidden"
                                    ref="input"
                                />

                                <div class="rounded-xl border cursor-pointer bg-slate-50 overflow-hidden" @click="input?.click()">
                                    <img
                                    v-if="props.organization.logo || logoPreview != '/storage/'"
                                    :src="logoPreview"
                                    alt="Nouveau logo"
                                    class="size-full aspect-video"
                                    />
                                    <ImagePlus class="placeholder size-full aspect-video" :absoluteStrokeWidth="true" v-else></ImagePlus>
                                </div>
                            </div>
                            <InputError :message="form.errors.logo" />
                        </div>
                    </div>

                    <div class="text-input-wrapper grow space-y-4">
                        <div class="grid gap-4">
                            <Label>Nom de l'organisation</label>
                            <Input name="title" v-model="form.title" :aria-invalid="form.errors.title && form.errors.title?.length != 0"></Input>
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="grid gap-4">
                            <Label>Desription</label>
                            <Textarea name="description" class="min-h-56" v-model="form.description" :aria-invalid="form.errors.description && form.errors.description?.length != 0"></Textarea>
                            <InputError :message="form.errors.description" />
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

                <Button 
                    :disabled="form.processing"
                    type="submit" 
                    class="self-center bg-emerald-500 hover:bg-emerald-400">Modifier</Button>
            </form>
        </div>
    </AppLayout>
</template>
