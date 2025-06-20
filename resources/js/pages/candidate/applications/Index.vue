<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Application } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { computed, ref } from 'vue';
import { Search } from 'lucide-vue-next';
import { Input } from '@/components/ui/input';


const props = defineProps<{
    applications: Application[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Candidatures',
        href: '/applications',
    },
];

const search = ref('')

const filteredApplications = computed(() => {
  return props.applications?.filter(application =>
    application.job_offer.title.toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>

<template>
    <Head title="" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <template #action>
            <div class="organization-search hidden md:block relative">
                <Input placeholder="Rechercher une offre candidature..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
            </div>

        </template>

        <div class="flex h-full flex-1 flex-col gap-8 p-4">
            <div class="relative min-h-[100vh] flex-1 md:min-h-min  space-y-6">
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex justify-between"> 
                        Toutes mes candidatures
                    </h1>
                    <p class="text-muted-foreground text-sm">Liste des offres d'emploi pour lesquelles t'as postulé.</p>
                </div>

                <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4">
                    <Link 
                        :href="route('applications.show', {application: application.id})" 
                        v-for="application in filteredApplications"
                        :key="application.id"
                    >
                        <div class="p-2 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-slate-50 flex flex-col justify-center items-center gap-4">
                            <p>{{  application.job_offer.title }}</p>
                        </div>
                    </Link>

                    <div class="no-organizations h-56 border rounded-xl flex flex-col items-center justify-center gap-8 col-span-full p-8" v-if="!applications.length">
                        <h3 class="font-semibold">Oops!! Il semble que tu n'as postulé à aucune offre.</h3>

                        <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                            <Link :href="route('jobs.index')">Voir les offres</Link>
                        </Button>
                    </div>
                    
                </div>
            </div>
        </div>
    </AppLayout>
</template>
