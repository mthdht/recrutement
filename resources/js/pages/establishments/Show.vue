<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Establishment, type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Globe, House, Image, Phone, Search, Trash } from 'lucide-vue-next';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogFooter, DialogTrigger, DialogTitle } from '@/components/ui/dialog';


const props = defineProps<{
    organization: Organization;
    establishment: Establishment
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
        href: '',
    },
];

</script>

<template>
    <Head :title="establishment.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #action>
            <!-- content for the header slot -->

             <Button class="bg-yellow-500 hover:bg-yellow-400 font-semibold" asChild>
                <Link :href="route('organizations.establishments.edit', {organization: props.organization.id, establishment: props.establishment.id})">Edit</Link>
             </Button>

             <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" class="font-semibold cursor-pointer" title="delete organisation">
                        <Trash class="stroke-3"></Trash>
                    </Button>
                </DialogTrigger>
                <DialogContent>
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Etes vous sur de vouloir supprimer cet établissement?</DialogTitle>
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
                                    <Link :href="route('organizations.establishments.destroy', {organization: props.organization.id, establishment: establishment.id})" method="delete">
                                        <Trash class="stroke-3"></Trash>
                                    </Link>
                                </Button>
                            </DialogClose>
                        </DialogFooter>
                </DialogContent>
            </Dialog>
        </template>

        <div class="flex h-full flex-1 flex-col gap-8 p-4">
            <div class="flex gap-4">
                <div class="logo-wrapper w-1/4 border rounded-xl overflow-hidden">
                    <img :src="'/storage/' + establishment.logo" alt="" class="aspect-video object-cover" v-if="establishment.logo">
                    <Image class="placeholder size-full aspect-video" :absoluteStrokeWidth="true" v-else></Image>
                </div>

                <div class="space-y-6">
                    <h2 class="font-semibold text-2xl">{{ establishment.name }}</h2>
                    
                    <p class="italic text-muted-foreground  text-balance" v-if="establishment.description">{{ establishment.description }}</p>
                    
                    <p class="flex items-center gap-2" v-if="establishment.address">
                        <House></House>
                        {{ establishment.address }}
                    </p>

                    <p class="flex items-center gap-2" v-if="establishment.phone">
                        <Phone></Phone>
                        {{ establishment.phone }}
                    </p>

                    <p class="flex items-center gap-2" v-if="establishment.website">
                        <Globe></Globe>
                        {{ establishment.website }}
                    </p>
                </div>
            </div>

            <!-- <div class="relative min-h-[100vh] flex-1 md:min-h-min  space-y-6">
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white"> Mes établissements</h1>
                    <p class="text-muted-foreground text-sm">Liste des établissements enregistrés dans votre organisation.</p>
                </div>

                <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4">
                    <Link 
                        :href="route('organizations.establishments.show', {organization: organization.id, establishment: establishment.id})" 
                        v-for="establishment in filteredEstablishments"
                        :key="establishment.id"
                    >
                        <div class="p-2 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-slate-50 flex flex-col justify-center items-center gap-4">
                            <img :src="'/storage/' + establishment.logo" alt="" class="size-1/3 aspect-video object-cover" v-if="establishment.logo">

                            <h3 class="font-semibold text-2xl">{{ establishment.name }}</h3>
                            <p class="text-muted-foreground text-sm text-center text-balance">{{ establishment.description }}</p>
                            <p class="text-xs">{{  establishment.address }}</p>
                        </div>
                    </Link>

                    <div class="no-establishments h-56 border rounded-xl flex flex-col items-center justify-center gap-8 col-span-full p-8" v-if="!organization.establishments.length">
                        <h3 class="font-semibold">OOps!! Il semble qu'il n'y ai pas d'établissements de créer.</h3>

                        <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                            <Link :href="route('establishments.create')">Ajouter un établissement</Link>
                        </Button>
                    </div>
                    
                </div>
            </div> -->
        </div>
    </AppLayout>
</template>
