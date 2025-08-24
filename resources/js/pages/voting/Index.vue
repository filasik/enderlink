<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SetupLayout from '@/layouts/setup/Layout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';

interface VotingSite {
  id: number;
  name: string;
  url_template: string;
  pass_username: boolean;
  enabled: boolean;
  sort_order: number;
  __dirty?: boolean;
}

const props = defineProps<{ sites: VotingSite[] }>();
// Local editable copy to avoid mutating Inertia props directly
const localSites = ref(props.sites.map((s: VotingSite) => ({
  ...s,
  pass_username: !!s.pass_username,
  enabled: !!s.enabled,
  __dirty: false,
})));
watch(() => props.sites, (val: VotingSite[]) => {
  localSites.value = val.map((s: VotingSite) => ({
    ...s,
    pass_username: !!s.pass_username,
    enabled: !!s.enabled,
    __dirty: false,
  }));
});
const tenantId = computed(() => (usePage().props as any).tenant?.id);

const form = ref({
  name: '',
  url_template: '',
  pass_username: false,
  enabled: true,
  sort_order: 0,
});

function resetForm() {
  form.value = { name: '', url_template: '', pass_username: false, enabled: true, sort_order: 0 };
}

function submit() {
  // Send only expected fields; coerce booleans to primitives (avoids any proxy/reactivity artifacts)
  const payload = {
    name: form.value.name,
    url_template: form.value.url_template,
    pass_username: form.value.pass_username ? 1 : 0,
    enabled: form.value.enabled ? 1 : 0,
    sort_order: form.value.sort_order ?? 0,
  };
  router.post(route('tenant.voting.store', { tenant: tenantId.value }), payload, {
    onSuccess: () => {
      resetForm();
      router.reload({ only: ['sites'] });
    },
    preserveScroll: true,
  });
}

const savingRow = ref<number|null>(null);
function update(site: VotingSite) {
  savingRow.value = site.id;
  const payload = {
    name: site.name,
    url_template: site.url_template,
    pass_username: site.pass_username ? 1 : 0,
    enabled: site.enabled ? 1 : 0,
    sort_order: site.sort_order ?? 0,
  };
  router.put(route('tenant.voting.update', { tenant: tenantId.value, votingSite: site.id }), payload, {
    preserveScroll: true,
    onFinish: () => { savingRow.value = null; },
    onSuccess: () => {
      // After successful update fetch fresh sites so toggles reflect DB truth
      router.reload({ only: ['sites'] });
  const row = localSites.value.find(r => r.id === site.id);
  if (row) row.__dirty = false;
    },
  });
}

// Debounced auto-save logic -------------------------------------------------
function scheduleUpdate(site: VotingSite) { update(site); }
function immediateToggle(site: VotingSite) { update(site); }

// (Switch-based toggle removed; checkboxes directly mutate state.)

function remove(site: VotingSite) {
  if (!confirm('Delete voting site?')) return;
  router.delete(route('tenant.voting.destroy', { tenant: tenantId.value, votingSite: site.id }), {
    preserveScroll: true,
    onSuccess: () => router.reload({ only: ['sites'] }),
  });
}
</script>

<template>
  <Head title="Voting Sites" />
  <AppLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup/general' }, { title: 'Vote Sites', href: '/setup/vote-sites'}]">
    <SetupLayout :breadcrumbs="[{ title: 'App Setup', href: '/setup/general' }, { title: 'Vote Sites', href: '/setup/vote-sites'}]">
    <div class="space-y-6">
      <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-4">
        <h2 class="font-semibold text-lg">Add Voting Site</h2>
        <div class="grid md:grid-cols-4 gap-4 items-end">
          <div>
            <label class="text-sm font-medium">Name</label>
            <Input v-model="form.name" placeholder="Site name" />
          </div>
          <div class="md:col-span-2">
            <label class="text-sm font-medium">URL Template</label>
            <Input v-model="form.url_template" placeholder="https://example.com/vote?user={username}" />
          </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium">Pass Username?</label>
                <Switch v-model="form.pass_username" />
            </div>
          <div class="flex flex-col gap-2">
            <label class="text-sm font-medium">Enabled</label>
            <Switch v-model="form.enabled" />
          </div>
          <div>
            <label class="text-sm font-medium">Sort Order</label>
            <Input v-model.number="form.sort_order" type="number" />
          </div>
          <div class="md:col-span-4">
            <Button @click="submit" class="cursor-pointer">Create</Button>
          </div>
        </div>
        <p class="text-xs text-muted-foreground">Use {username} placeholder in URL if Pass Username is enabled.</p>
      </div>

      <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-4">
        <h2 class="font-semibold text-lg">Existing Sites</h2>
  <div v-if="!localSites.length" class="text-sm text-muted-foreground">No voting sites yet.</div>
  <table v-else class="w-full text-sm">
          <thead>
            <tr class="text-left border-b">
              <th class="py-2">Name</th>
              <th class="py-2">URL Template</th>
              <th class="py-2">Pass Username</th>
              <th class="py-2">Enabled</th>
              <th class="py-2">Sort</th>
              <th class="py-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="site in localSites" :key="site.id" class="border-b last:border-none">
              <td class="py-2">
                <Input v-model="site.name" @blur="scheduleUpdate(site)" />
              </td>
              <td class="py-2">
                <Input v-model="site.url_template" @blur="scheduleUpdate(site)" />
              </td>
              <td class="py-2">
                <Switch v-model="site.pass_username" @update:modelValue="() => { site.__dirty = true; }" />
              </td>
              <td class="py-2">
                <Switch v-model="site.enabled" @update:modelValue="() => { site.__dirty = true; }" />
              </td>
              <td class="py-2 w-16">
                <Input v-model.number="site.sort_order" type="number" @change="scheduleUpdate(site)" />
              </td>
              <td class="py-2 flex gap-2 justify-end">
                <Button :disabled="savingRow === site.id" variant="secondary" size="sm" @click="update(site)" class="cursor-pointer">
                  <span v-if="savingRow === site.id">Saving...</span>
                  <span v-else>Save</span>
                </Button>
                <Button variant="destructive" size="sm" @click="remove(site)" class="cursor-pointer">Delete</Button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </SetupLayout>
  </AppLayout>
</template>
