<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Establishment, type BreadcrumbItem, type Organization, JobOffer } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';


const props = defineProps<{
    jobOffer: JobOffer
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Offres d\'emploi',
        href: '/jobs',
    },
    {
        title: props.jobOffer.title,
        href: route('jobs.show', {jobOffer: props.jobOffer.id}),
    },
    
];
</script>

<template>
    <Head :title="jobOffer.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <template #action>
            <!-- <div class="organization-search hidden md:block relative">
                <Input placeholder="Rechercher une offre d'emploi..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
            </div> -->

            <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                <Link :href="route('applications.create', {jobOffer: jobOffer.id})">Postuler</Link>
            </Button>
        </template>

        <div class="flex h-full flex-1 flex-col gap-8 p-8">
            <div class="relative min-h-[100vh] flex-1 md:min-h-min  space-y-6">
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex gap-16"> 
                        <span class="flex gap-2 items-center">
                            <div class="status size-5 rounded-full" :class="[props.jobOffer.published_at ? 'bg-emerald-500': 'bg-yellow-500']"></div>
                            {{ jobOffer.title }}
                        </span>
                        <div class="infos flex gap-2">
                            <Badge variant="secondary">
                                {{ props.jobOffer.contract_type }}
                            </Badge>

                            <Badge variant="secondary" v-if="props.jobOffer.working_hours">
                                {{ props.jobOffer.working_hours }}
                            </Badge>

                            <Badge variant="secondary" v-if="props.jobOffer.salary">
                                {{ props.jobOffer.salary }}
                            </Badge>
                        </div>
                    </h1>
                    <p 
                        class="text-muted-foreground text-sm italic" 
                        v-if="props.jobOffer.published_at"
                    >
                        Publié le {{ new Date(props.jobOffer.published_at).toLocaleDateString("fr-FR", {year: "numeric", month: "long", day: "numeric",}) }}
                    </p>

                    <p 
                        class="text-muted-foreground text-sm italic" 
                        v-else
                    >
                        Non publié
                    </p>
                    
                </div>

                <Tabs default-value="description" class="">
                    <TabsList class="">
                        <TabsTrigger value="description" class="">
                            Description
                        </TabsTrigger>
                    </TabsList>
                    <TabsContent value="description">
                        {{ props.jobOffer.description }}
                    </TabsContent>
                    
                </Tabs>
                    

                
                
                
            </div>
        </div>
    </AppLayout>
</template>
