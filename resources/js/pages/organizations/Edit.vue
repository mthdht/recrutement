<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem, type Organization, type Establishment } from '@/types';
import OrganizationForm from '@/components/OrganizationForm.vue';

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
  country: 'France',
  address: props.organization.address || '',
  logo: null as File | null,
  phone: props.organization.phone || '',
  website: props.organization.website || ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: 'Modifier', href: route('organizations.edit', { organization: props.organization.id }) },
];
</script>

<template>
  <Head title="Modifier un établissement" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <OrganizationForm
        :form="form"
        mode="edit"
        :logo-url="props.organization.logo"
        :delete-logo-url="route('organizations.deleteLogo', { organization: props.organization.id })"
        @submit="form.post(route('organizations.update', { organization: props.organization.id }))"
      />
    </div>
  </AppLayout>
</template>
