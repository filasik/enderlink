<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
const props = defineProps<{ page: { title:string; slug:string; content:string; meta_description?:string|null }; pages?: Array<{ title:string; slug:string }> }>()
</script>
<template>
  <PublicLayout :pages="props.pages" :title="props.page.title">
    <Head :title="props.page.title">
      <meta name="description" :content="props.page.meta_description || ''" />
    </Head>
    <div class="max-w-3xl mx-auto p-6 prose dark:prose-invert">
      <h1>{{ props.page.title }}</h1>
      <div v-html="props.page.content" />
    </div>
  </PublicLayout>
</template>
