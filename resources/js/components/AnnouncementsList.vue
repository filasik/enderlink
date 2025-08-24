<script setup lang="ts">
defineProps<{ announcements: Array<{ id:number; title:string; body:string; is_pinned:boolean; published_at?: string | null; }>; title?: string }>()
</script>

<template>
  <div class="space-y-3">
    <h3 v-if="title" class="font-semibold text-sm opacity-70 tracking-wide">{{ title }}</h3>
    <div v-if="announcements.length === 0" class="text-xs text-muted-foreground">No announcements yet.</div>
    <div v-for="a in announcements" :key="a.id" class="rounded-md border p-3 bg-background/60 dark:bg-muted/30">
      <div class="flex items-center gap-2 mb-1">
        <span class="font-medium text-sm">{{ a.title }}</span>
        <span v-if="a.is_pinned" class="text-[10px] uppercase tracking-wide bg-primary/10 text-primary px-1.5 py-0.5 rounded">Pinned</span>
      </div>
      <div class="prose dark:prose-invert max-w-none text-xs" v-html="a.body.replace(/\n/g,'<br>')" />
      <div class="mt-2 text-[10px] opacity-60" v-if="a.published_at">{{ new Date(a.published_at).toLocaleString() }}</div>
    </div>
  </div>
</template>
