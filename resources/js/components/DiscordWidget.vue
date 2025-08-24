<script setup lang="ts">
import { ref, onMounted } from 'vue';
const props = defineProps<{ guildId?: string|null; enabled:boolean; }>()
const loading = ref(false)
const data = ref<any|null>(null)
onMounted(async () => {
  if (!props.enabled || !props.guildId) return
  loading.value = true
  try {
    const res = await fetch(route('tenant.discord.widget', { tenant: (window as any).Laravel?.page?.props?.tenant?.id }))
    data.value = await res.json()
  } catch (e) {
    // ignore
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="rounded-xl border p-4 text-xs h-full flex flex-col">
    <h3 class="font-semibold text-sm mb-2">Discord</h3>
    <div v-if="!enabled || !guildId" class="opacity-60">Discord widget disabled.</div>
    <div v-else-if="loading" class="animate-pulse">Loading widget...</div>
    <div v-else-if="data?.enabled && data?.data" class="space-y-2 overflow-auto">
      <div class="flex items-center gap-2 flex-wrap">
        <img v-if="data.data.instant_invite" :src="`https://cdn.discordapp.com/icons/${guildId}/${data.data.id}.png`" class="w-6 h-6 rounded" alt="icon" />
        <span class="font-medium">{{ data.data.name }}</span>
      </div>
      <div class="text-[10px] uppercase tracking-wide opacity-60">Online: {{ data.data.presence_count }}</div>
      <ul class="space-y-1 max-h-40 overflow-auto pr-1 text-xs">
        <li v-for="m in data.data.members" :key="m.id" class="flex items-center gap-2">
          <img :src="m.avatar_url" class="w-4 h-4 rounded-full" />
          <span>{{ m.username }}</span>
        </li>
      </ul>
      <a v-if="data.data.instant_invite" :href="data.data.instant_invite" target="_blank" class="inline-block text-[11px] font-medium underline">Join Server</a>
    </div>
    <div v-else class="opacity-60">Widget unavailable.</div>
  </div>
</template>
