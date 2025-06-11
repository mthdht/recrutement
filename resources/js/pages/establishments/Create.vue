<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import EstablishmentForm from '@/components/EstablishmentForm.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem, type Organization } from '@/types';

const props = defineProps<{
  organization: Organization;
}>();

const form = useForm({
  name: '',
  description: '',
  street: '',
  postcode: '',
  city: '',
  country: 'France',
  address: '',
  logo: null,
  phone: '',
  website: ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: 'Créer un établissement', href: route('organizations.establishments.create', { organization: props.organization.id }) },
];
</script>

<template>
  <Head title="Créer un établissement" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <EstablishmentForm
        :form="form"
        mode="create"
        @submit="form.post(route('organizations.establishments.store', { organization: props.organization.id }))"
      />
    </div>
  </AppLayout>
</template>