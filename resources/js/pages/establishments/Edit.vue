<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AddressAutocomplete from '@/components/AddressAutocomplete.vue'
import FileImageInput from '@/components/FileImageInput.vue';

import { type BreadcrumbItem, type Organization, type Establishment } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    organization: Organization;
    establishment: Establishment;
}>();

const form = useForm({
    _method: 'put',
    name: props.establishment.name || '',
    description: props.establishment.description || '',
    street: props.establishment.street || '',
    postcode: props.establishment.postcode || '',
    city: props.establishment.city || '',
    country: 'France', // L'API ne le renvoie pas, donc on force FR
    address: props.establishment.address || '',
    logo: null as File | null,
    phone: props.establishment.phone || '',
    website: props.establishment.website || ''
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
        title: props.establishment.name,
        href: route('organizations.establishments.show', {organization: props.organization.id, establishment: props.establishment.id}),
    },
    {
        title: 'Modifier',
        href: route('organizations.establishments.edit', {organization: props.organization.id, establishment: props.establishment.id}),
    },
];


</script>

<template>
    <Head title="Modifier un établissement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
           <form @submit.prevent="form.post(route('organizations.establishments.update', {organization: organization.id, establishment: establishment.id}))" class="flex flex-col gap-4">
                <div class="flex flex-wrap gap-4 container">
                    <div class="logo-input-wrapper w-full lg:w-1/4 space-y-4">
                        <Label>Logo</Label>
                        <FileImageInput
                            v-model="form.logo"
                            v-model:error="form.errors.logo"
                            :delete-logo-url="route('organizations.establishments.deleteLogo', {organization: organization.id, establishment: establishment.id})"
                            :logo-url="establishment.logo"
                        />
                    </div>

                    <div class="text-input-wrapper grow space-y-6">
                        <div class="grid gap-3">
                            <Label class="">Nom de l'établissement <span class="text-red-500">*</span></label>
                            <Input name="name" v-model="form.name" :aria-invalid="form.errors.name && form.errors.name?.length != 0"></Input>
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-3">
                            <Label>Site web</label>
                            <Input 
                                v-model="form.website" 
                                :aria-invalid="form.errors.website && form.errors.website?.length != 0"
                                placeholder="www.monsite.com"
                            ></Input>
                            <InputError :message="form.errors.website" />
                        </div>

                        <div class="grid gap-3">
                            <Label>Téléphone</label>
                            <Input 
                                v-model="form.phone" 
                                :aria-invalid="form.errors.phone && form.errors.phone?.length != 0"
                                placeholder="07 08 09 01 02"
                            ></Input>
                            <InputError :message="form.errors.phone" />
                        </div>

                        <div class="grid gap-3">
                            <Label>Desription</label>
                            <Textarea name="description" class="min-h-40" v-model="form.description" :aria-invalid="form.errors.description && form.errors.description?.length != 0"></Textarea>
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
