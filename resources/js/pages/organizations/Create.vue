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
import FileImageInput from '@/components/FileImageInput.vue';

const form = useForm<{
    name: string
    description: string
    street: string
    postcode: string
    city: string
    country: string
    address: string
    logo: File | null
}>({
    name: '',
    description: '',
    street: '',
    postcode: '',
    city: '',
    country: 'France', // L'API ne le renvoie pas, donc on force FR
    address: '',
    logo: null
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
                <div class="flex gap-4">
                    <div class="logo-input-wrapper w-1/4 space-y-4">
                        <Label>Logo</Label>
                        <FileImageInput
                            v-model="form.logo"
                            v-model:error="form.errors.logo"
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
                    class="self-center bg-emerald-500 hover:bg-emerald-400">Créer</Button>
            </form>
        </div>
    </AppLayout>
</template>
