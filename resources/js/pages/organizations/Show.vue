<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';


const props = defineProps<{
    organization: Organization;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
    {
        title: props.organization.title,
        href: route('organizations.show', {organization: props.organization.id}),
    },
];


</script>

<template>
    <Head title="Organisations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #action>
            <!-- content for the header slot -->
             <Button class="bg-yellow-500 hover:bg-yellow-400 font-semibold" asChild>
                <Link :href="route('organizations.edit', {organization: props.organization.id})">Edit</Link>
             </Button>
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div 
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                    <pre>{{  organization }}</pre>
                </div>
                
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                
            </div>
        </div>
    </AppLayout>
</template>
