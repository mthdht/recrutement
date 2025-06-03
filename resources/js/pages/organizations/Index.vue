<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';


defineProps<{
    organizations: Organization[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
];


</script>

<template>
    <Head title="Organisations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #action>
            <!-- content for the header slot -->
             <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                <Link :href="route('organizations.create')">add</Link>
             </Button>
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Link 
                    :href="route('organizations.show', {organization: organization.id})" 
                    v-for="organization in organizations"
                    :key="organization.id"
                >
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-slate-50">
                        <PlaceholderPattern />
                        <pre>{{  organization }}</pre>
                    </div>
                </Link>
                
            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                
            </div>
        </div>
    </AppLayout>
</template>
