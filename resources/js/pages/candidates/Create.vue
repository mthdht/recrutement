<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type Establishment, type BreadcrumbItem, type Organization, JobOffer } from '@/types';

const props = defineProps<{
  organization: Organization;
  establishment: Establishment;
  jobOffer: JobOffer
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
  { title: props.jobOffer.title, href: route('organizations.establishments.jobs.show', { organization: props.organization.id, establishment: props.establishment.id, jobOffer: props.jobOffer.id }) },
  { title: 'Créer une candidat', href: ''},
];
</script>

<template>
  <Head title="Créer un établissement" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <CandidateForm
        :form="form"
        mode="create"
        @submit="form.post(route('organizations.establishments.jobs.candidates.store', { organization: props.organization.id, establishment: props.establishment.id, jobOffer: props.jobOffer.id }))"
      />
    </div>
  </AppLayout>
</template>