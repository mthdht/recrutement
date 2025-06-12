<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type Establishment, type BreadcrumbItem, type Organization } from '@/types';
import JobOfferForm from '@/components/JobOfferForm.vue';

const props = defineProps<{
  organization: Organization;
  establishment: Establishment;
}>();

const form = useForm({
  title: '',
  description: '',
  contract_type: '',
  start_date: '',
  end_date: '',
  working_hours: '',
  salary: '',
  status: 'draft',
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: props.establishment.name, href: route('organizations.establishments.show', { organization: props.organization.id, establishment: props.establishment.id }) },
  { title: 'Créer une offre d\'emploi', href: route('organizations.establishments.jobs.create', { organization: props.organization.id, establishment: props.establishment.id }) },
];
</script>

<template>
  <Head title="Créer un établissement" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <JobOfferForm
        :form="form"
        mode="create"
        @submit="form.post(route('organizations.establishments.jobs.store', { organization: props.organization.id, establishment: props.establishment.id }))"
      />
    </div>
  </AppLayout>
</template>