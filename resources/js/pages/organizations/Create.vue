<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import OrganizationForm from '@/components/OrganizationForm.vue'
import type { BreadcrumbItem } from '@/types'

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
})

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: 'Créer une organisation', href: route('organizations.create') },
]
</script>

<template>
  <Head title="Créer une organisation" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <OrganizationForm
        :form="form"
        mode="create"
        @submit="() => form.post(route('organizations.store'))"
      />
    </div>
  </AppLayout>
</template>
