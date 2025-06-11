<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import EstablishmentForm from '@/components/EstablishmentForm.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem, type Organization, type Establishment } from '@/types';

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
  country: 'France',
  address: props.establishment.address || '',
  logo: null as File | null,
  phone: props.establishment.phone || '',
  website: props.establishment.website || ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: props.establishment.name, href: route('organizations.establishments.show', { organization: props.organization.id, establishment: props.establishment.id }) },
  { title: 'Modifier', href: route('organizations.establishments.edit', { organization: props.organization.id, establishment: props.establishment.id }) },
];
</script>

<template>
  <Head title="Modifier un établissement" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <EstablishmentForm
        :form="form"
        mode="edit"
        :logo-url="props.establishment.logo"
        :delete-logo-url="route('organizations.establishments.deleteLogo', { organization: props.organization.id, establishment: props.establishment.id })"
        @submit="form.post(route('organizations.establishments.update', { organization: props.organization.id, establishment: props.establishment.id }))"
      />
    </div>
  </AppLayout>
</template>
