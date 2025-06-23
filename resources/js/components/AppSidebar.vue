<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, PackageOpen} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';


const tenantId = computed(() => usePage().props.tenant?.id);

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/'+tenantId.value+'/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Setup',
        href: '/'+tenantId.value+'/setup',
        icon: PackageOpen,
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
        href: 'https://github.com/filasik/enderlink/wiki',
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
                        <Link :href="route('dashboard', { tenant: tenantId })">
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
