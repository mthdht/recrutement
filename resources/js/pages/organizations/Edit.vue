<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AddressAutocomplete from '@/components/AddressAutocomplete.vue'
import FileImageInput from '@/components/FileImageInput.vue';

import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    organization: Organization;
}>();

const form = useForm({
    _method: 'put',
    name: props.organization.name || '',
    description: props.organization.description || '',
    street: props.organization.street || '',
    postcode: props.organization.postcode || '',
    city: props.organization.city || '',
    country: 'France', // L'API ne le renvoie pas, donc on force FR
    address: props.organization.address || '',
    logo: null as File | null
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
    {
        title: props.organization.name,
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
                    
                    <div class="logo-input-wrapper w-1/4 space-y-4">
                        <Label>Logo</Label>
                        <FileImageInput
                            v-model="form.logo"
                            v-model:error="form.errors.logo"
                            :logoUrl="props.organization.logo"
                            :deleteLogoUrl="route('organizations.deleteLogo', {organization: organization.id})"
                        />
                    </div>
                    

                    <div class="text-input-wrapper grow space-y-4">
                        <div class="grid gap-4">
                            <Label>Nom de l'organisation</label>
                            <Input name="name" v-model="form.name" :aria-invalid="form.errors.name && form.errors.name?.length != 0"></Input>
                            <InputError :message="form.errors.name" />
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
