<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import InputError from '@/components/InputError.vue'
import Button from '@/components/ui/button/Button.vue'
import { MdEditor, config } from 'md-editor-v3';
import 'md-editor-v3/lib/style.css';

const props = defineProps<{
  form: any,
  mode: 'create' | 'edit',
  logoUrl?: string,
  deleteLogoUrl?: string
}>()

</script>

<template>
    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-4">
        <div class="text-input-wrapper grow space-y-6">
            <div class="grid gap-3">
                <Label for="title">Titre de l'offre <span class="text-red-500">*</span></Label>
                <Input id="title" v-model="form.title" :aria-invalid="!!form.errors.title" />
                <InputError v-if="form.errors.title" :message="form.errors.title" />
            </div>

            <div class="grid gap-3">
                <Label for="description">Description <span class="text-red-500">*</span></Label>
                <MdEditor v-model="form.description" language="us_US" :preview="false"/>
                <InputError v-if="form.errors.description" :message="form.errors.description" />
            </div>

            <div class="flex gap-8">
                <div class="grid gap-3">
                    <Label for="status">Type de contrat <span class="text-red-500">*</span></Label>
                    <select
                        id="contract_type"
                        v-model="form.contract_type"
                        :aria-invalid="!!form.errors.contract_type"
                        class="border rounded-md p-2"
                    >
                        <option value="" disabled selected class="italic text-sm">Choisir un type de contrat</option>
                        <option value="draft">CDI</option>
                        <option value="published">CDD</option>
                        <option value="archived">Interim</option>
                        <option value="archived">Alternance</option>
                    </select>
                    <InputError v-if="form.errors.contract_type" :message="form.errors.contract_type" />
                </div>

                <div class="grid gap-3">
                    <Label for="salary">Salaire</Label>
                    <Input id="salary" v-model="form.salary" :aria-invalid="!!form.errors.salary" />
                    <InputError v-if="form.errors.salary" :message="form.errors.salary" />
                </div>
            
                <div class="grid gap-3">
                    <Label for="start_date">Date de début</Label>
                    <Input id="start_date" type="date" v-model="form.start_date" :aria-invalid="!!form.errors.start_date" />
                    <InputError v-if="form.errors.start_date" :message="form.errors.start_date" />
                </div>
                
                <div class="grid gap-3">
                    <Label for="end_date">Date de fin</Label>
                    <Input id="end_date" type="date" v-model="form.end_date" :aria-invalid="!!form.errors.end_date" />
                    <InputError v-if="form.errors.end_date" :message="form.errors.end_date" />
                </div>
            </div>

            

            <div class="grid gap-3">
                <Label for="status">Statut <span class="text-red-500">*</span></Label>
                <select
                    id="status"
                    v-model="form.status"
                    :aria-invalid="!!form.errors.status"
                    class="border rounded-md p-2"
                >
                    <option value="draft">Brouillon</option>
                    <option value="published">Publié</option>
                    <option value="archived">Archivé</option>
                </select>
                <InputError v-if="form.errors.status" :message="form.errors.status" />
            </div>
        </div>

        <Button :disabled="form.processing" type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">
        {{ mode === 'create' ? 'Créer' : 'Modifier' }}
        </Button>
    </form>
</template>
