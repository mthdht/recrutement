<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';
import { Image, Trash } from 'lucide-vue-next';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogFooter, DialogTrigger, DialogTitle } from '@/components/ui/dialog';


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

const form = useForm({
  title: '',
  description: '',
})

</script>

<template>
    <Head title="Organisations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #action>
            <!-- content for the header slot -->
             <Button class="bg-yellow-500 hover:bg-yellow-400 font-semibold" asChild>
                <Link :href="route('organizations.edit', {organization: props.organization.id})">Edit</Link>
             </Button>

             <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" class="font-semibold cursor-pointer" title="delete organisation">
                        <Trash class="stroke-3"></Trash>
                    </Button>
                </DialogTrigger>
                <DialogContent>
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Etes vous sur de vouloir supprimer cette organisation?</DialogTitle>
                            <DialogDescription>
                                Une fois effacées, toutes les informations et ressources seront definitivement supprimées !
                            </DialogDescription>
                        </DialogHeader>


                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button variant="secondary"> Cancel </Button>
                            </DialogClose>

                            <DialogClose as-child>
                                <Button asChild variant="destructive" :disabled="form.processing" class="cursor-pointer">
                                    <Link :href="route('organizations.destroy', {organization: props.organization.id})" method="delete">
                                        <Trash class="stroke-3"></Trash>
                                    </Link>
                                </Button>
                            </DialogClose>
                        </DialogFooter>
                </DialogContent>
            </Dialog>
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex gap-4">

                <div class="logo-wrapper w-1/4 border rounded-xl overflow-hidden">
                    <img :src="'/storage/' + organization.logo" alt="" class="aspect-video object-cover" v-if="organization.logo">
                    <Image class="placeholder size-full aspect-video" :absoluteStrokeWidth="true" v-else></Image>
                </div>

                <div class="space-y-6">

                    <h2 class="font-semibold text-xl">{{ organization.title }}</h2>
                    
                    <p class="italic text-slate-700/80">{{ organization.description }}</p>
                    
                    <p>{{ organization.address }}</p>
                </div>
            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                
            </div>
        </div>
    </AppLayout>
</template>
