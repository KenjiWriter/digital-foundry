<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Mail } from 'lucide-vue-next';
import NavFooter from '@/Components/NavFooter.vue';
import NavMain from '@/Components/NavMain.vue';
import NavUser from '@/Components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/Components/ui/sidebar';
// import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import AppLogo from './AppLogo.vue';

// Use ziggy's route helper globally or declare it
declare const route: any;

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Case Studies',
        href: '/admin/case-studies',
        icon: Folder,
    },
    {
        title: 'Leads',
        href: '/admin/leads',
        icon: Mail,
    },
];

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/dashboard">
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

