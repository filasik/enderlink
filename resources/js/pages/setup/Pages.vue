<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SetupLayout from '@/layouts/setup/Layout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
const props = defineProps<{ pages: Array<{ id:number; title:string; slug:string; content:string; is_published:boolean; published_at?:string|null; meta_description?:string|null; }>; }>()
const page = usePage();
const tenantId = computed(() => (page.props as any)?.tenant?.id as string | undefined);
const form = ref({ title:'', slug:'', content:'', is_published:false, published_at:'', meta_description:'' })
function submit(){
  if (!tenantId.value) return;
  router.post(route('tenant.pages.store', { tenant: tenantId.value }), form.value)
  form.value = { title:'', slug:'', content:'', is_published:false, published_at:'', meta_description:'' }
}
function update(p:{ id:number }){
  if (!tenantId.value) return;
  router.put(route('tenant.pages.update', { tenant: tenantId.value, page: p.id }), p)
}
function destroy(p:{ id:number }){
  if (!tenantId.value) return;
  if (confirm('Delete page?')) router.delete(route('tenant.pages.destroy', { tenant: tenantId.value, page: p.id }))
}
</script>

<template>
  <Head title="Pages" />
  <AppLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup' }, { title: 'Pages', href: '/setup/pages' }]">
    <SetupLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup' }, { title: 'Pages', href: '/setup/pages' }]">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
          <!-- Create Page Card -->
          <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <div class="flex flex-col gap-4 p-4 text-sm">
              <div>
                <h2 class="font-semibold mb-1">Create Page</h2>
                <p class="text-xs opacity-70">Add custom public pages for your site.</p>
              </div>
              <form @submit.prevent="submit" class="grid gap-3">
                <div class="flex gap-2 flex-wrap">
                  <input v-model="form.title" placeholder="Title" class="border rounded px-2 py-1 flex-1 min-w-[200px] bg-background/50" required />
                  <input v-model="form.slug" placeholder="Slug (optional)" class="border rounded px-2 py-1 w-48 bg-background/50" />
                </div>
                <textarea v-model="form.content" placeholder="Content (HTML / Markdown)" class="border rounded px-2 py-1 min-h-40 bg-background/50" />
                <input v-model="form.meta_description" placeholder="Meta description" class="border rounded px-2 py-1 bg-background/50" />
                <div class="flex gap-4 flex-wrap items-center text-xs">
                  <label class="flex items-center gap-1"><input type="checkbox" v-model="form.is_published" /> Published</label>
                  <label class="flex items-center gap-1">Publish at <input type="datetime-local" v-model="form.published_at" class="border rounded px-2 py-1 ml-1 bg-background/50" /></label>
                </div>
                <Button size="sm" class="w-max">Create</Button>
              </form>
            </div>
          </div>

          <!-- Existing Pages Card -->
          <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <div class="flex flex-col gap-4 p-4 text-sm">
              <div>
                <h2 class="font-semibold mb-1">Existing Pages</h2>
                <p class="text-xs opacity-70">Edit or publish pages.</p>
              </div>
              <div v-if="props.pages.length===0" class="text-xs opacity-70">No pages yet.</div>
              <div v-for="p in props.pages" :key="p.id" class="rounded border border-border/50 p-3 space-y-2 bg-background/40">
                <div class="flex gap-2 flex-wrap">
                  <input v-model="p.title" class="font-medium w-full border-b pb-1 bg-transparent" />
                  <input v-model="p.slug" class="w-48 border-b pb-1 bg-transparent" />
                </div>
                <textarea v-model="p.content" class="w-full text-xs border rounded p-2 min-h-32 bg-background/50" />
                <input v-model="p.meta_description" class="w-full text-xs border rounded p-2 bg-background/50" placeholder="Meta description" />
                <div class="flex gap-3 flex-wrap items-center text-[11px]">
                  <label class="flex items-center gap-1"><input type="checkbox" v-model="p.is_published" /> Published</label>
                  <label class="flex items-center gap-1">Publish
                    <input type="datetime-local" v-model="p.published_at" class="border rounded px-1 py-0.5 ml-1 bg-background/50" />
                  </label>
                  <a v-if="tenantId" :href="route('tenant.pages.show', { tenant: tenantId, page: p.slug })" target="_blank" class="underline ml-auto">View</a>
                  <div class="flex gap-2 ml-auto">
                    <Button type="button" size="sm" variant="secondary" @click="update(p)">Save</Button>
                    <Button type="button" size="sm" variant="destructive" @click="destroy(p)">Delete</Button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </SetupLayout>
  </AppLayout>
 </template>
