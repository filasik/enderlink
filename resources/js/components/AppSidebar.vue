<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, PackageOpen, Link2, Database, EthernetPort, Vote, ChartLine, Webhook } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Setup',
        href: '/setup',
        icon: PackageOpen,
    },
    {
        title: 'RCON',
        href: '/rcon',
        icon: EthernetPort,
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

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/filasik/enderlink',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://github.com/filasik/enderlink',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
