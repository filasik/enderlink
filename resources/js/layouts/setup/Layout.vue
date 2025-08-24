<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Folder, Cog, LayoutGrid, Link2, Database, EthernetPort, Vote, ChartLine, Webhook } from 'lucide-vue-next';
import { computed } from 'vue';

const tenantId = computed(() => (usePage().props as any).tenant?.id);

const sidebarNavItems: NavItem[] = [
    {
        title: 'General',
        href: '/'+tenantId.value+'/setup/general',
        icon: Cog,
    },
    {
        title: 'Vote Sites',
        href: '/'+tenantId.value+'/setup/vote-sites',
        icon: Vote,
    },
    {
        title: 'RCON',
        href: '/'+tenantId.value+'/setup/rcon',
        icon: EthernetPort,
    },
    {
        title: 'Databases',
        href: '/'+tenantId.value+'/setup/databases',
        icon: Database,
    },
    {
        title: 'Links',
        href: '/'+tenantId.value+'/setup/links',
        icon: Link2,
    },
    {
        title: 'Residence',
        href: '/'+tenantId.value+'/setup/residence',
        icon: Folder,
    },
    {
        title: 'Server status',
        href: '/'+tenantId.value+'/server-status',
        icon: ChartLine,
    },
    {
        title: 'API',
        href: '/'+tenantId.value+'/setup/api',
        icon: Webhook,
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
    <Heading title="Setup" description="Configure project-wide settings and integrations" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" />
                             <span>{{ item.title }}</span>
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1">
                <section class="space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
