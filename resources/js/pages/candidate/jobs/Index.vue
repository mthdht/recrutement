<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type JobOffer, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Search, Trash } from 'lucide-vue-next';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogFooter, DialogTrigger, DialogTitle } from '@/components/ui/dialog';
import { computed, ref } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';


const props = defineProps<{
    jobOffers: JobOffer[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Offres d\'emploi',
        href: '/jobs',
    },
];

const search = ref('')

const filteredJobOffers = computed(() => {
  return props.jobOffers?.filter(job =>
    job.title.toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>

<template>
    <Head title="Toutes les offres d'emploi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <template #action>
            <div class="organization-search hidden md:block relative">
                <Input placeholder="Rechercher une offre d'emploi..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
            </div>
        </template>

        <div class="flex h-full flex-1 flex-col gap-8 p-8">
            <div class="relative min-h-[100vh] flex-1 md:min-h-min  space-y-6">
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex justify-between"> 
                        Toutes les offres d'emploi
                    </h1>
                    <p class="text-muted-foreground text-sm">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis, repellendus!</p>
                </div>
                    
                 <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4">
                    <Link 
                        :href="route('jobs.show', {jobOffer: jobOffer.id})" 
                        v-for="jobOffer in filteredJobOffers"
                        :key="jobOffer.id"
                    >
                        <div class="p-2 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-slate-50 flex flex-col justify-center items-center gap-4">
                            <h3 class="font-semibold text-2xl text-center">{{ jobOffer.title }}</h3>
                            <p class="text-muted-foreground text-sm text-center text-balance truncate">{{ jobOffer.description }}</p>
                            <p class="text-xs">{{  jobOffer.contract_type }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
