<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem, JobOffer } from '@/types';
import ApplicationForm from '@/components/ApplicationForm.vue';

const props = defineProps<{
  jobOffer: JobOffer
}>();

const form = useForm({
  cv: null,
  cover_letter: ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: props.jobOffer.title, href: route('jobs.show', {jobOffer: props.jobOffer.id}) },
  { title: 'Postuler', href: '' },
  
];

const handleSubmit = () => {
  form.post(route('applications.store', { jobOffer: props.jobOffer.id }))
}
</script>

<template>
  <Head title="Créer un candidat" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <ApplicationForm
        :form="form"
        mode="create"
        @updatedCV="(cv) => form.cv = cv"
        @submitApplication="handleSubmit"
      />
    </div>
  </AppLayout>
</template>