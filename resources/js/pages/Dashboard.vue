<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import ServerStatusBlock from '@/components/ServerStatusBlock.vue';
import QuickLinks from '@/components/QuickLinks.vue';
import VotingSitesWidget from '@/components/VotingSitesWidget.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// These should come from your backend/Inertia page props!
const settings = defineProps<{
  status_enabled?: boolean;
  status_query_ip: string;
  status_query_port: string | number;
  links_enabled: boolean;
  discord_link?: string;
  instagram_link?: string;
  tiktok_link?: string;
  youtube_link?: string;
    voting_sites: Array<{ id:number; name:string; url_template:string; pass_username:boolean; enabled:boolean; sort_order:number; }>;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                    <ServerStatusBlock
                        :status-enabled="settings.status_enabled"
                        :host="settings.status_query_ip"
                        :port="settings.status_query_port"
                    />

                    <QuickLinks
                        :links_enabled="settings.links_enabled"
                        :discord_link="settings.discord_link"
                        :instagram_link="settings.instagram_link"
                        :tiktok_link="settings.tiktok_link"
                        :youtube_link="settings.youtube_link"
                    />

                    <VotingSitesWidget :sites="settings.voting_sites" />

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
