<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import AddressAutocomplete from '@/components/AddressAutocomplete.vue'

const form = useForm({
    title: '',
    description: '',
    fullAddress: {
        street: '',
        postcode: '',
        city: '',
        country: 'France', // L'API ne le renvoie pas, donc on force FR
        address: '',
    }
})


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
    {
        title: 'Créer',
        href: '/organizations/create',
    },
];


</script>

<template>
    <Head title="Organisations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="form.post(route('organizations.store'))" class="flex flex-col gap-4">
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

                <AddressAutocomplete apiKey="ce6533ac4a3746bf8e801c669696457e" v-model="form.fullAddress"/>

                <Button 
                    :disabled="form.processing"
                    type="submit" 
                    class="self-center bg-emerald-500 hover:bg-emerald-400">Créer</Button>
            </form>
        </div>
    </AppLayout>
</template>
