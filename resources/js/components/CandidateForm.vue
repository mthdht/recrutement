<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import InputError from '@/components/InputError.vue'
import Button from '@/components/ui/button/Button.vue'
import 'md-editor-v3/lib/style.css';
import TipTap from './TipTap.vue'

const props = defineProps<{
  form: any,
  mode: 'create' | 'edit',
}>()

</script>

<template>
    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-4">
        <div class="text-input-wrapper grow space-y-6">
            <div class="flex gap-4">
                <div class="grid gap-3 w-1/2">
                    <Label for="last_name">Nom<span class="text-red-500">*</span></Label>
                    <Input id="last_name" v-model="form.last_name" :aria-invalid="!!form.errors.last_name" />
                    <InputError v-if="form.errors.last_name" :message="form.errors.last_name" />
                </div>

                <div class="grid gap-3 w-1/2">
                    <Label for="first_name">Prénom<span class="text-red-500">*</span></Label>
                    <Input id="first_name" v-model="form.first_name" :aria-invalid="!!form.errors.first_name" />
                    <InputError v-if="form.errors.first_name" :message="form.errors.first_name" />
                </div>
            </div>

            <div class="flex gap-4">
                <div class="grid gap-3 w-1/2">
                    <Label for="email">Email<span class="text-red-500">*</span></Label>
                    <Input id="email" v-model="form.email" :aria-invalid="!!form.errors.email" type="email"/>
                    <InputError v-if="form.errors.email" :message="form.errors.email" />
                </div>

                <div class="grid gap-3 w-1/2">
                    <Label for="phone">Téléphone</Label>
                    <Input id="phone" v-model="form.phone" :aria-invalid="!!form.errors.phone" />
                    <InputError v-if="form.errors.phone" :message="form.errors.phone" />
                </div> 
            </div>

            <div class="grid gap-3">
                <Label for="bio">Bio</Label>
                <TipTap v-model="form.bio" class="max-h-108 overflow-auto"></TipTap>
                <InputError v-if="form.errors.bio" :message="form.errors.bio" />
            </div>

            <div class="grid gap-3">
                <Label for="cv">CV<span class="text-red-500">*</span></Label>
                <Input id="cv" @change="(e: Event) => $emit('updatedCV', (e.target as HTMLInputElement)?.files?.[0] || null)" :aria-invalid="!!form.errors.cv" type="file"/>
                <InputError v-if="form.errors.cv" :message="form.errors.cv" />
            </div>
        </div>

        <Button :disabled="form.processing" type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">
        {{ mode === 'create' ? 'Créer' : 'Modifier' }}
        </Button>
    </form>
</template>
