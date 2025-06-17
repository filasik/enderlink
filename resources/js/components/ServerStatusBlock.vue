<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Loader2, CheckCircle, XCircle } from 'lucide-vue-next';

interface Props {
  statusEnabled: boolean;
  host: string;
  port: string | number;
}

const props = defineProps<Props>();

const loading = ref(false);
const error = ref<string | null>(null);
const status = ref<any>(null);

const fetchStatus = async () => {
  if (!props.statusEnabled) return;
  loading.value = true;
  error.value = null;
  try {
    const res = await fetch(`https://api.mcstatus.io/v2/status/java/${props.host}:${props.port}`);
    if (!res.ok) throw new Error('Failed to fetch status');
    status.value = await res.json();
  } catch (e: any) {
    error.value = e.message || 'Unknown error';
  } finally {
    loading.value = false;
  }
};

onMounted(fetchStatus);

const online = computed(() => status.value?.online);
const players = computed(() => status.value?.players?.online ?? 0);
const maxPlayers = computed(() => status.value?.players?.max ?? 0);
const motd = computed(() => status.value?.motd?.clean?.[0] ?? '');
const ipAddress = computed(() => status.value?.ip_address ?? '');
const versionName = computed(() => status.value?.version?.name_clean ?? '');
const icon = computed(() => status.value?.icon ?? '');
const retrievedAt = computed(() => status.value?.retrieved_at ? new Date(status.value.retrieved_at).toLocaleString() : '');
const software = computed(() => status.value?.software ?? '');
const eulaBlocked = computed(() => status.value?.eula_blocked);
const motdHtml = computed(() => status.value?.motd?.html ?? '');
const playerList = computed(() => status.value?.players?.list ?? []);
const plugins = computed(() => status.value?.plugins?.length ? status.value.plugins.map((p: any) => p.name).join(', ') : null);
const mods = computed(() => status.value?.mods?.length ? status.value.mods.map((m: any) => m.name).join(', ') : null);
</script>

<template>
  <Card v-if="statusEnabled" class="h-full flex flex-col justify-between">
    <CardHeader>
      <CardTitle class="flex items-center gap-2">
        <span v-html="motdHtml"></span>
        <Loader2 v-if="loading" class="animate-spin size-4 text-muted-foreground" />
        <CheckCircle v-else-if="online" class="size-4 text-green-500" />
        <XCircle v-else class="size-4 text-red-500" />
      </CardTitle>
    </CardHeader>
    <CardContent>
      <div v-if="loading" class="text-muted-foreground">Checking status...</div>
      <div v-else-if="error" class="text-red-500">Error: {{ error }}</div>
      <div v-else-if="online">
        <div class="font-medium text-green-600">Online</div>
        <div class="flex items-center gap-2 mt-2">
          <img v-if="icon" :src="icon" alt="Server Icon" class="w-8 h-8 rounded" />
          <span class="text-sm text-muted-foreground">IP: {{ ipAddress }}:{{ port }}</span>
        </div>
        <div class="text-sm text-muted-foreground">Version: {{ versionName }}</div>
        <div class="text-sm text-muted-foreground">Players: {{ players }} / {{ maxPlayers }}</div>
        <div class="text-xs text-muted-foreground">Last updated: {{ retrievedAt }}</div>
        <div v-if="eulaBlocked" class="text-xs text-red-500">Server is blocked due to EULA violation!</div>
        <div v-if="plugins" class="text-xs text-muted-foreground">Plugins: {{ plugins }}</div>
        <div v-if="mods" class="text-xs text-muted-foreground">Mods: {{ mods }}</div>
        <div v-if="playerList.length" class="text-xs text-muted-foreground mt-2">
          Online players: {{ playerList.map(p => p.name_clean).join(', ') }}
        </div>
      </div>
      <div v-else>
        <div class="font-medium text-red-600">Offline</div>
      </div>
    </CardContent>
  </Card>
</template>
