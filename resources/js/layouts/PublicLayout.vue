<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
// Expect pages list passed from controller (published pages)
const props = defineProps<{ pages?: Array<{ title:string; slug:string }>; title?: string }>()
const page = usePage();
const tenantId = (page.props as any)?.tenant?.id;
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
    <header class="w-full border-b border-[#19140015] dark:border-[#3E3E3A] backdrop-blur supports-[backdrop-filter]:bg-white/70 dark:supports-[backdrop-filter]:bg-[#161615]/70 bg-white/60 dark:bg-[#161615]/60 sticky top-0 z-30">
      <div class="mx-auto w-full max-w-5xl px-4 py-3 flex items-center gap-4">
        <Link :href="route('tenant.home', { tenant: tenantId })" class="text-sm font-medium hover:underline">Home</Link>
        <nav class="flex items-center gap-3 text-xs flex-wrap">
          <Link v-for="p in props.pages" :key="p.slug" :href="route('tenant.pages.show', { tenant: tenantId, page: p.slug })" class="px-2 py-1 rounded hover:bg-[#19140008] dark:hover:bg-[#ffffff10] border border-transparent hover:border-[#19140020] dark:hover:border-[#ffffff22] transition-colors">{{ p.title }}</Link>
        </nav>
        <div class="ml-auto flex items-center gap-3">
          <template v-if="(page.props as any).auth?.user">
            <Link :href="route('tenant.dashboard', { tenant: tenantId })" class="text-xs font-medium px-3 py-1 rounded border border-[#19140035] hover:bg-[#19140008] dark:border-[#3E3E3A] dark:hover:bg-[#ffffff10]">Dashboard</Link>
          </template>
          <template v-else>
            <Link :href="route('tenant.login', { tenant: tenantId })" class="text-xs font-medium px-3 py-1 rounded border border-[#19140035] hover:bg-[#19140008] dark:border-[#3E3E3A] dark:hover:bg-[#ffffff10]">Log in</Link>
          </template>
        </div>
      </div>
    </header>
    <main class="flex-1">
      <slot />
    </main>
    <footer class="mt-12 py-6 text-center text-[11px] opacity-60">
      <span>Powered by EnderLink</span>
    </footer>
  </div>
</template>
