<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

interface VotingSite {
  id: number;
  name: string;
  url_template: string;
  pass_username: boolean;
  enabled: boolean;
  sort_order: number;
}

const props = defineProps<{ sites: VotingSite[] }>();
const user = computed(() => (usePage().props as any).auth?.user);

function resolveUrl(site: VotingSite): string {
  if (site.pass_username) {
    const uname = encodeURIComponent(user.value?.name || 'PLAYER_NAME');
    return site.url_template.replace('{username}', uname);
  }
  return site.url_template;
}
</script>

<template>
  <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex flex-col gap-3">
    <div>
      <h3 class="font-semibold text-sm">Voting Sites</h3>
      <p class="text-xs text-muted-foreground">Support the server by voting</p>
    </div>
    <ul v-if="sites.length" class="space-y-2">
      <li v-for="s in sites.filter(s=>s.enabled)" :key="s.id">
        <a :href="resolveUrl(s)" target="_blank" rel="noopener" class="text-primary hover:underline text-sm">
          {{ s.name }}
        </a>
      </li>
    </ul>
    <p v-else class="text-xs text-muted-foreground">No sites configured.</p>
  </div>
</template>
