<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head as InertiaHead, router } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import SettingsBlock from '@/components/SettingsBlock.vue';
import { Button } from '@/components/ui/button';
import { Toaster } from '@/components/ui/sonner';
import { toast } from 'vue-sonner';

export default {
    components: {
        AppLayout,
        InertiaHead,
        PlaceholderPattern,
        SettingsBlock,
        Button,
        Toaster,
    },
    props: {
        settings: {
            type: Object,
            required: true
        },
        breadcrumbs: {
            type: Array,
            default: () => [
                {
                    title: 'App Setup',
                    href: '/setup',
                },
            ]
        }
    },
    data() {
        return {
            form: {
                status_enabled: this.settings.status_enabled === 'true' || this.settings.status_enabled === true,
                status_query_ip: this.settings.status_query_ip || '',
                status_query_port: this.settings.status_query_port || '',
                app_name: this.settings.app_name || '',
            },
            flashTimeout: null,
            flashMessage: null,
        };
    },
    watch: {
        'flash.success'(val) {
            if (val) {
                this.flashMessage = val;
                clearTimeout(this.flashTimeout);
                this.flashTimeout = setTimeout(() => {
                    this.flashMessage = null;
                }, 3000);
            }
        }
    },
    computed: {
        flash() {
            return this.$page.props.flash || {};
        }
    },
    methods: {
        submit() {
            router.post(route('setup.store'), this.form, {
                preserveScroll: true,
            });
            toast("Saved.", {
                description: "Settings have been saved successfully.",
            });
        },
        updateForm(values) {
            this.form = { ...this.form, ...values };
        }
    },
}
</script>

<template>
    <InertiaHead title="App Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <Toaster position="top-right" />

            <!-- Flash message -->
            <div v-if="flash.success" class="mb-4 rounded bg-green-100 px-4 py-2 text-green-800 border border-green-300">
                {{ flash.success }}
            </div>
            <div v-if="flash.error" class="mb-4 rounded bg-red-100 px-4 py-2 text-red-800 border border-red-300">
                {{ flash.error }}
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex flex-col gap-4 p-4">
                        <SettingsBlock
                            title="Server Status"
                            :settings="form"
                            :fields="[
                                { key: 'status_enabled', label: 'Enabled', type: 'toggle' },
                                { key: 'status_query_ip', label: 'IP', type: 'text' },
                                { key: 'status_query_port', label: 'Port', type: 'number' }
                            ]"
                            @update="updateForm"
                        />
                        <Button @click="submit" class="cursor-pointer">
                            Save
                        </Button>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex flex-col gap-4 p-4">
                        <SettingsBlock
                            title="App Settings"
                            :settings="form"
                            :fields="[
                                { key: 'app_name', label: 'App Name', type: 'text' },
                            ]"
                            @update="updateForm"
                        />
                        <Button @click="submit" class="cursor-pointer">
                            Save
                        </Button>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
