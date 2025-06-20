<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Application } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Trash } from 'lucide-vue-next';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogFooter, DialogTrigger, DialogTitle } from '@/components/ui/dialog';
import { ref } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Card } from '@/components/ui/card';


const props = defineProps<{
    application: Application
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Candidatures',
        href: '/applications',
    },
    {
        title: props.application.job_offer.title,
        href: '',
    }
];

// const search = ref('')

// const filteredJobOffers = computed(() => {
//   return props.jobOffer?.filter(job =>
//     job.title.toLowerCase().includes(search.value.toLowerCase())
//   )
// })
</script>

<template>
    <Head :title="application.job_offer.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <template #action>
            <!-- <div class="organization-search hidden md:block relative">
                <Input placeholder="Rechercher une offre d'emploi..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
            </div> -->

             <Button class="bg-yellow-500 hover:bg-yellow-400 font-semibold" asChild>
                <Link :href="route('applications.edit', {application: application.id})">Edit</Link>
             </Button>

             <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" class="font-semibold cursor-pointer" title="delete job offer">
                        <Trash class="stroke-3"></Trash>
                    </Button>
                </DialogTrigger>
                <DialogContent>
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Etes vous sur de vouloir supprimer cette candidature?</DialogTitle>
                            <DialogDescription>
                                Une fois effacées, toutes les informations et ressources seront definitivement supprimées !
                            </DialogDescription>
                        </DialogHeader>


                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button variant="secondary"> Cancel </Button>
                            </DialogClose>

                            <DialogClose as-child>
                                <Button asChild variant="destructive" class="cursor-pointer">
                                    <Link :href="route('applications.destroy', {application: application.id})" method="delete">
                                        <Trash class="stroke-3"></Trash>
                                    </Link>
                                </Button>
                            </DialogClose>
                        </DialogFooter>
                </DialogContent>
            </Dialog>
        </template>

        <div class="flex h-full flex-1 flex-col gap-8 p-8">
            <div class="relative min-h-[100vh] flex-1 md:min-h-min  space-y-6">
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex gap-16"> 
                        <span class="flex gap-2 items-center">
                            <!-- <div class="status size-5 rounded-full" :class="[props.application.job_offer.published_at ? 'bg-emerald-500': 'bg-yellow-500']"></div> -->
                            {{ application.job_offer.title }}
                        </span>
                        <!-- <Button asChild class="bg-emerald-500 hover:bg-emerald-400">
                            <Link :href="route('organizations.establishments.jobs.create', {organization: organization.id, establishment: establishment.id})">
                                Ajouter un candidat
                            </Link>
                        </Button> -->
                        <div class="infos flex gap-2">
                            <Badge variant="secondary">
                                {{ props.application.job_offer.contract_type }}
                            </Badge>

                            <Badge variant="secondary" v-if="props.application.job_offer.working_hours">
                                {{ props.application.job_offer.working_hours }}
                            </Badge>

                            <Badge variant="secondary" v-if="props.application.job_offer.salary">
                                {{ props.application.job_offer.salary }}
                            </Badge>
                        </div>
                    </h1>
                    <p class="text-muted-foreground text-sm italic" >
                        Postulé le {{ new Date(props.application.applied_at).toLocaleDateString("fr-FR", {year: "numeric", month: "long", day: "numeric",}) }}
                    </p>
                </div>

                <Tabs default-value="application" class="">
                    <TabsList class="">
                        <TabsTrigger value="application" class="">
                            candidature
                        </TabsTrigger>
                        <TabsTrigger value="description" class="">
                            Offre d'emploi
                        </TabsTrigger>
                        
                    </TabsList>
                    <TabsContent value="description">
                        {{ props.application.job_offer.description }}
                    </TabsContent>
                    <TabsContent value="candidates">
                        <div class="grid grid-cols-4">
                            infos
                        </div>
                    </TabsContent>
                </Tabs>
                    

                
                
                
            </div>
        </div>
    </AppLayout>
</template>
