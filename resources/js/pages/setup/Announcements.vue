<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SetupLayout from '@/layouts/setup/Layout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
const props = defineProps<{ announcements: Array<{ id:number; title:string; body:string; visibility:string; is_pinned:boolean; published_at?:string|null; created_at:string; updated_at:string; }>; }>()

// Access tenant id safely from the existing Inertia page props
const page = usePage();
const tenantId = computed(() => (page.props as any)?.tenant?.id as string | undefined);

const form = ref({ title:'', body:'', visibility:'both', is_pinned:false, published_at:'' })
function submit(){
  if (!tenantId.value) return;
  router.post(route('tenant.announcements.store', { tenant: tenantId.value }), form.value)
  form.value = { title:'', body:'', visibility:'both', is_pinned:false, published_at:'' }
}
function update(a:{ id:number }){
  if (!tenantId.value) return;
  router.put(route('tenant.announcements.update', { tenant: tenantId.value, announcement: a.id }), a)
}
function destroy(a:{ id:number }){
  if (!tenantId.value) return;
  if (confirm('Delete announcement?')) router.delete(route('tenant.announcements.destroy', { tenant: tenantId.value, announcement: a.id }))
}
</script>

<template>
  <Head title="Announcements" />
  <AppLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup' }, { title: 'Announcements', href: '/setup/announcements' }]">
    <SetupLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup' }, { title: 'Announcements', href: '/setup/announcements' }]">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
          <!-- Create Announcement Card -->
          <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <div class="flex flex-col gap-4 p-4 text-sm">
              <div>
                <h2 class="font-semibold mb-1">Create Announcement</h2>
                <p class="text-xs opacity-70">Share updates with your community.</p>
              </div>
              <form @submit.prevent="submit" class="grid gap-3">
                <input v-model="form.title" placeholder="Title" class="border rounded px-2 py-1 bg-background/50" required />
                <textarea v-model="form.body" placeholder="Body (Markdown or plain)" class="border rounded px-2 py-1 min-h-28 bg-background/50" required />
                <div class="flex flex-wrap gap-4 items-center text-xs">
                  <label class="flex items-center gap-1">Visibility
                    <select v-model="form.visibility" class="border rounded px-2 py-1 ml-1 bg-background/50">
                      <option value="public">Public</option>
                      <option value="private">Private</option>
                      <option value="both">Both</option>
                    </select>
                  </label>
                  <label class="flex items-center gap-1"><input type="checkbox" v-model="form.is_pinned" /> Pinned</label>
                  <label class="flex items-center gap-1">Publish at
                    <input type="datetime-local" v-model="form.published_at" class="border rounded px-2 py-1 ml-1 bg-background/50" />
                  </label>
                </div>
                <Button size="sm" class="w-max">Create</Button>
              </form>
            </div>
          </div>

          <!-- Existing Announcements Card -->
          <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:col-span-1">
            <div class="flex flex-col gap-4 p-4 text-sm">
              <div>
                <h2 class="font-semibold mb-1">Existing</h2>
                <p class="text-xs opacity-70">Manage and edit announcements.</p>
              </div>
              <div v-if="props.announcements.length===0" class="text-xs opacity-70">No announcements yet.</div>
              <div v-for="a in props.announcements" :key="a.id" class="rounded border border-border/50 p-3 space-y-2 bg-background/40">
                <input v-model="a.title" class="font-medium w-full border-b pb-1 bg-transparent" />
                <textarea v-model="a.body" class="w-full text-xs border rounded p-2 min-h-24 bg-background/50" />
                <div class="flex gap-3 flex-wrap items-center text-[11px]">
                  <label class="flex items-center gap-1">Visibility
                    <select v-model="a.visibility" class="border rounded px-1 py-0.5 ml-1 bg-background/50">
                      <option value="public">Public</option>
                      <option value="private">Private</option>
                      <option value="both">Both</option>
                    </select>
                  </label>
                  <label class="flex items-center gap-1"><input type="checkbox" v-model="a.is_pinned" /> Pinned</label>
                  <label class="flex items-center gap-1">Publish
                    <input type="datetime-local" v-model="a.published_at" class="border rounded px-1 py-0.5 ml-1 bg-background/50" />
                  </label>
                  <div class="flex gap-2 ml-auto">
                    <Button type="button" size="sm" variant="secondary" @click="update(a)">Save</Button>
                    <Button type="button" size="sm" variant="destructive" @click="destroy(a)">Delete</Button>
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
