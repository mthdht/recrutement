<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type Establishment, type BreadcrumbItem, type Organization, JobOffer } from '@/types';
import CandidateForm from '@/components/CandidateForm.vue';

const props = defineProps<{
  organization: Organization;
  establishment: Establishment;
  jobOffer: JobOffer
}>();

const form = useForm({
  last_name: '',
  first_name: '',
  email: '',
  cv: null,
  phone: '',
  bio: '',
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: props.establishment.name, href: route('organizations.establishments.show', { organization: props.organization.id, establishment: props.establishment.id }) },
  { title: props.jobOffer.title, href: route('organizations.establishments.jobs.show', { organization: props.organization.id, establishment: props.establishment.id, jobOffer: props.jobOffer.id }) },
  { title: 'Créer un candidat', href: ''},
];
</script>

<template>
  <Head title="Créer un candidat" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <CandidateForm
        :form="form"
        mode="create"
        @updatedCV="(cv) => form.cv = cv"
        @submit="form.post(route('organizations.establishments.jobs.candidates.store', { organization: props.organization.id, establishment: props.establishment.id, jobOffer: props.jobOffer.id }))"
      />
    </div>
  </AppLayout>
</template>