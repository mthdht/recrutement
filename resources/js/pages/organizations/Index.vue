<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Organization } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props =defineProps<{
    organizations: Organization[];
}>();

const search = ref('')

const filteredOrganizations = computed(() => {
  return props.organizations.filter(org =>
    org.title.toLowerCase().includes(search.value.toLowerCase())
  )
})

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
            
                 <div class="organization-search hidden md:block relative">
                    <Input placeholder="Rechercher une organisation..." class="pl-8 lg:min-w-96" v-model="search"></Input>
                    <Search class="absolute top-2 left-2 size-5 text-muted-foreground"></Search>
                </div>
                <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                    <Link :href="route('organizations.create')">Ajouter une organisation</Link>
                </Button>
           
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="space-y-1">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white"> Mes Organisations</h1>
                <p class="text-muted-foreground text-sm">Liste des établissements enregistrés dans votre compte.</p>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4">
                <Link 
                    :href="route('organizations.show', {organization: organization.id})" 
                    v-for="organization in filteredOrganizations"
                    :key="organization.id"
                >
                    <div class="p-2 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border hover:bg-slate-50 flex flex-col justify-center items-center gap-4">
                        <img :src="'/storage/' + organization.logo" alt="" class="size-1/3 aspect-video object-cover" v-if="organization.logo">

                        <h3 class="font-semibold text-2xl">{{ organization.title }}</h3>
                        <p class="text-muted-foreground text-sm text-center text-balance">{{ organization.description }}</p>
                        <p class="text-xs">{{  organization.address }}</p>
                    </div>
                </Link>

                <div class="no-organizations h-56 border rounded-xl flex flex-col items-center justify-center gap-8 col-span-full p-8" v-if="!organizations.length">
                    <h3 class="font-semibold">OOps!! Il semble qu'il n'y ai pas d'organisations de créer.</h3>

                    <Button class="bg-emerald-500 hover:bg-emerald-400 font-semibold" asChild>
                        <Link :href="route('organizations.create')">Ajouter une organisation</Link>
                    </Button>
                </div>
                
            </div>

            <!-- <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                
            </div> -->
        </div>
    </AppLayout>
</template>
