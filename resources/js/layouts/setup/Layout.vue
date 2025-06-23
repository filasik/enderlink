<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Folder, LayoutGrid, Link2, Database, EthernetPort, Vote, ChartLine, Webhook } from 'lucide-vue-next';


const sidebarNavItems: NavItem[] = [
    {
        title: 'Main',
        href: '/setup/main',
        icon: LayoutGrid,
    },
    {
        title: 'Vote Sites',
        href: '/setup/vote-sites',
        icon: Vote,
    },
    {
        title: 'RCON',
        href: '/setup/rcon',
        icon: EthernetPort,
    },
    {
        title: 'Databases',
        href: '/setup/databases',
        icon: Database,
    },
    {
        title: 'Links',
        href: '/setup/links',
        icon: Link2,
    },
    {
        title: 'Vote sites',
        href: '/vote-sites',
        icon: Vote,
    },
    {
        title: 'Links',
        href: '/links',
        icon: Link2,
    },
    {
        title: 'Database',
        href: '/database',
        icon: Database,
    },
    {
        title: 'Residence',
        href: '/residence',
        icon: Folder,
    },
    {
        title: 'Server status',
        href: '/server-status',
        icon: ChartLine,
    },
    {
        title: 'API',
        href: '/setapi',
        icon: Webhook,
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Setup" description="Manage your profile and account settings" />

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

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
