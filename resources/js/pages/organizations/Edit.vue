<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import OrganizationForm from '@/components/OrganizationForm.vue'
import type { BreadcrumbItem, Organization } from '@/types'

const props = defineProps<{
  organization: Organization;
}>()

const form = useForm({
  _method: 'put',
  name: props.organization.name || '',
  description: props.organization.description || '',
  street: props.organization.street || '',
  postcode: props.organization.postcode || '',
  city: props.organization.city || '',
  country: 'France',
  address: props.organization.address || '',
  logo: null,
  phone: props.organization.phone || '',
  website: props.organization.website || ''
})

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Organisations', href: '/organizations' },
  { title: props.organization.name, href: route('organizations.show', { organization: props.organization.id }) },
  { title: 'Modifier', href: route('organizations.edit', { organization: props.organization.id }) },
]
</script>

<template>
  <Head title="Modifier une organisation" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <OrganizationForm
        :form="form"
        mode="edit"
        @submit="() => form.post(route('organizations.update', { organization: props.organization.id }))"
      />
    </div>
  </AppLayout>
</template>
