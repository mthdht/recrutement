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
    <form @submit.prevent="$emit('submitApplication')" class="flex flex-col gap-4">
        <div class="text-input-wrapper grow space-y-6">
            <div class="grid gap-3">
                <Label for="cover_letter">Lettre de motivation</Label>
                <TipTap v-model="form.cover_letter" class="max-h-108 overflow-auto"></TipTap>
                <InputError v-if="form.errors.cover_letter" :message="form.errors.cover_letter" />

                {{ form.cover_letter }}
            </div>

            <div class="grid gap-3">
                <Label for="cv">CV<span class="text-red-500">*</span></Label>
                <Input id="cv" @change="(e: Event) => $emit('updatedCV', (e.target as HTMLInputElement)?.files?.[0] || null)" :aria-invalid="!!form.errors.cv" type="file"/>
                <InputError v-if="form.errors.cv" :message="form.errors.cv" />
            </div>
        </div>

        <Button :disabled="form.processing" type="submit" class="self-center bg-emerald-500 hover:bg-emerald-400">
            {{ mode === 'create' ? 'Postuler' : 'Modifier' }}
        </Button>
    </form>
</template>
