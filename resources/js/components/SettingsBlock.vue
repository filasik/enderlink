<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from 'vue';
import { Switch } from '@/components/ui/switch';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    title: string,
    settings: Record<string, any>,
    fields: Array<{ key: string, label: string, type: string }>
}>();
const emit = defineEmits(['update']);

const localSettings = ref({ ...props.settings });

watch(localSettings, () => {
    emit('update', localSettings.value);
}, { deep: true });
</script>

<template>
    <h2 class="font-bold mb-2">{{ title }}</h2>
    <form class="flex flex-col gap-4">
        <div v-for="field in fields" :key="field.key">
            <template v-if="field.type === 'toggle'">
                <div class="flex items-center justify-between">
                    <Label class="block font-medium mb-1">{{ field.label }}</label>
                    <Switch v-model="localSettings[field.key]" />
                </div>
            </template>
            <template v-else>
                <div class="grid gap-2">
                    <Label>{{ field.label }}</Label>
                    <Input
                        class="mt-1 block w-full"
                        :type="field.type"
                        v-model="localSettings[field.key]"
                    />
                </div>
            </template>
        </div>
    </form>
</template>