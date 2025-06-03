<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: null,
  description: null,
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
                    <Input name="name"></Input>
                </div>

                <div class="grid gap-4">
                    <Label>Desription</label>
                    <Textarea name="name" class="min-h-56"></Textarea>
                </div>

                <Button type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">Créer</Button>
            </form>
        </div>
    </AppLayout>
</template>
