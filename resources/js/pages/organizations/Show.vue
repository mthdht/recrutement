<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';
import { Trash } from 'lucide-vue-next';
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
                    <Button variant="destructive" class="font-semibold" title="delete organisation">
                        <Trash class="stroke-3"></Trash>
                    </Button>
                </DialogTrigger>
                <DialogContent>
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
                            <DialogDescription>
                                Once your account is deleted, all of its resources and data will also be permanently deleted. Please enter your
                                password to confirm you would like to permanently delete your account.
                            </DialogDescription>
                        </DialogHeader>


                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button variant="secondary"> Cancel </Button>
                            </DialogClose>

                            <Button variant="destructive" :disabled="form.processing">
                                <Link :href="route('organizations.destroy', {organization: props.organization.id})" method="delete">
                                    <Trash class="stroke-3"></Trash>
                                </Link>
                            </Button>
                        </DialogFooter>
                </DialogContent>
            </Dialog>
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex gap-4">

                <img :src="'/storage/' + organization.logo" alt="" class="w-1/3">
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
