<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type Establishment, type BreadcrumbItem, type Organization, JobOffer } from '@/types';
import CandidateForm from '@/components/CandidateForm.vue';
import ApplicationForm from '@/components/ApplicationForm.vue';

const props = defineProps<{
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
  { title: props.jobOffer.title, href: route('jobs.show', {jobOffer: props.jobOffer.id}) },
  { title: 'Postuler', href: '' },
  
];
</script>

<template>
  <Head title="Créer un candidat" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <ApplicationForm
        :form="form"
        mode="create"
        @updatedCV="(cv) => form.cv = cv"
        @submit="form.post(route('applications.store', { jobOffer: props.jobOffer.id }))"
      />
    </div>
  </AppLayout>
</template>