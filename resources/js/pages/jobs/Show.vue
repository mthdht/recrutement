<script setup lang="ts">
import { type JobOffer } from '@/types';

defineProps<{
    jobOffer: JobOffer
}>();

</script>
<template>
<pre>{{  jobOffer }}</pre>
</template>