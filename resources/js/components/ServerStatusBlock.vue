<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'; // adjust if you have these
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
</script>

<template>
  <Card v-if="statusEnabled" class="h-full flex flex-col justify-between">
    <CardHeader>
      <CardTitle class="flex items-center gap-2">
        <span>Minecraft Server</span>
        <Loader2 v-if="loading" class="animate-spin size-4 text-muted-foreground" />
        <CheckCircle v-else-if="online" class="size-4 text-green-500" />
        <XCircle v-else class="size-4 text-red-500" />
      </CardTitle>
    </CardHeader>
    <CardContent>
      <div v-if="loading" class="text-muted-foreground">Checking status…</div>
      <div v-else-if="error" class="text-red-500">Error: {{ error }}</div>
      <div v-else-if="online">
        <div class="font-medium text-green-600">Online</div>
        <div class="text-sm text-muted-foreground">Players: {{ players }} / {{ maxPlayers }}</div>
        <div class="text-xs mt-2 italic text-muted-foreground">{{ motd }}</div>
      </div>
      <div v-else>
        <div class="font-medium text-red-600">Offline</div>
      </div>
    </CardContent>
  </Card>
</template>