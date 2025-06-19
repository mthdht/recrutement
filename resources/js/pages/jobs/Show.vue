<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Establishment, type BreadcrumbItem, type Organization, JobOffer } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Trash } from 'lucide-vue-next';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogFooter, DialogTrigger, DialogTitle } from '@/components/ui/dialog';
import { ref } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Card } from '@/components/ui/card';


const props = defineProps<{
    organization: Organization;
    establishment: Establishment;
    jobOffer: JobOffer
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Organisations',
        href: '/organizations',
    },
    {
        title: props.organization.name,
        href: route('organizations.show', {organization: props.organization.id}),
    },
    {
        title: props.establishment.name,
        href: route('organizations.establishments.show', {organization: props.organization.id, establishment: props.establishment.id}),
    },
    {
        title: props.jobOffer.title,
        href: route('organizations.establishments.jobs.show', {organization: props.organization.id, establishment: props.establishment.id, jobOffer: props.jobOffer.id}),
    },
];

const search = ref('')

// const filteredJobOffers = computed(() => {
//   return props.jobOffer?.filter(job =>
//     job.title.toLowerCase().includes(search.value.toLowerCase())
//   )
// })
</script>

<template>
    <Head :title="jobOffer.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <template #action>
            <!-- <div class="organization-search hidden md:block relative">
                <Input placeholder="Rechercher une offre d'emploi..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
            </div> -->

             <Button class="bg-yellow-500 hover:bg-yellow-400 font-semibold" asChild>
                <Link :href="route('organizations.establishments.jobs.edit', {organization: props.organization.id, establishment: props.establishment.id, jobOffer: jobOffer.id})">Edit</Link>
             </Button>

             <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" class="font-semibold cursor-pointer" title="delete job offer">
                        <Trash class="stroke-3"></Trash>
                    </Button>
                </DialogTrigger>
                <DialogContent>
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Etes vous sur de vouloir supprimer cet offre d'emploi?</DialogTitle>
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
                                    <Link :href="route('organizations.establishments.jobs.destroy', {organization: props.organization.id, establishment: establishment.id, jobOffer: jobOffer.id})" method="delete">
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
                            <div class="status size-5 rounded-full" :class="[props.jobOffer.published_at ? 'bg-emerald-500': 'bg-yellow-500']"></div>
                            {{ jobOffer.title }}
                        </span>
                        <!-- <Button asChild class="bg-emerald-500 hover:bg-emerald-400">
                            <Link :href="route('organizations.establishments.jobs.create', {organization: organization.id, establishment: establishment.id})">
                                Ajouter un candidat
                            </Link>
                        </Button> -->
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
                        <TabsTrigger value="candidates" class="">
                            Candidats
                        </TabsTrigger>
                        <TabsTrigger value="diffusion" class="">
                            Diffusion
                        </TabsTrigger>
                    </TabsList>
                    <TabsContent value="description">
                        {{ props.jobOffer.description }}
                    </TabsContent>
                    <TabsContent value="candidates">
                        <!-- <Button asChild>
                            <Link :href="route('organizations.establishments.jobs.candidates.create', {
                                    organization: organization.id,
                                    establishment: establishment.id,
                                    jobOffer: jobOffer.id
                                })"
                            >
                                Add candidates
                            </Link>
                        </Button> -->
                        <div class="grid grid-cols-4">

                            <Card v-for="candidate in jobOffer.candidates" class="p-4">
                                <h3>{{ candidate.name }}</h3>

                            </Card>

                            <div class="no-candidates h-56 border rounded-xl flex flex-col items-center justify-center gap-8 col-span-full p-8" v-if="!jobOffer.candidates?.length">
                                <h3 class="font-semibold">Oops!! Il semble qu'il n'y ai pas de candidats pour cette offre.</h3>

                                <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                                    <Link :href="route('organizations.establishments.jobs.create', {organization: props.organization.id, establishment: establishment.id})">Ajouter un offre d'emploi</Link>
                                </Button>
                            </div>
                        </div>
                    </TabsContent>
                    <TabsContent value="diffusion">
                        Change your password here.
                    </TabsContent>
                </Tabs>
                    

                
                
                
            </div>
        </div>
    </AppLayout>
</template>
