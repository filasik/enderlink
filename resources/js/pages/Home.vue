<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert"
import { LoaderCircle, LockKeyholeOpen } from 'lucide-vue-next';
import AnnouncementsList from '@/components/AnnouncementsList.vue';
import DiscordWidget from '@/components/DiscordWidget.vue';

const props = defineProps<{ public_announcements?: Array<{ id:number; title:string; body:string; is_pinned:boolean; published_at?:string|null }>; pages?: Array<{ title:string; slug:string }>; discord?: { guild_id?: string|null; widget_enabled:boolean } }>()


</script>

<template>
    <PublicLayout :pages="props.pages" title="Home">
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex flex-col items-center p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:text-[#EDEDEC]">
        <header class="w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                
            </nav>
            <Alert variant="default" v-if="$page.props.tenant?.id" class="mt-4 mb-3">
                <LockKeyholeOpen />
                <AlertTitle>{{ $page.props.tenant?.id }}</AlertTitle>
                <AlertDescription>
                    You're going to log in to the server with the username {{ $page.props.tenant?.id }}.
                </AlertDescription>
            </Alert>
        </header>

        <div class="w-full max-w-4xl grid gap-6 my-8" v-if="props.public_announcements || props.discord || props.pages">
                <div class="grid md:grid-cols-2 gap-6 w-full">
                    <div class="rounded-xl border p-4">
                        <AnnouncementsList :announcements="props.public_announcements||[]" title="Latest Announcements" />
                    </div>
                    <DiscordWidget v-if="props.discord" :guild-id="props.discord.guild_id" :enabled="props.discord.widget_enabled" />
                </div>
            </div>

        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">

            
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <h1 class="mb-1 font-medium">Let's get started</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        EnderLink is built to help. <br />You and your community can unite in a single app.
                    </p>
                    <ul class="mb-4 flex flex-col lg:mb-6">
                        <li
                            class="relative flex items-center gap-4 py-2 before:absolute before:top-1/2 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]"
                        >
                            <span class="relative bg-white py-1 dark:bg-[#161615]">
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                </span>
                            </span>
                            <span>
                                Read the
                                <a
                                    href="https://github.com/filasik/enderlink"
                                    target="_blank"
                                    class="ml-1 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
                                >
                                    <span>Documentation</span>
                                    <svg
                                        width="10"
                                        height="11"
                                        viewBox="0 0 10 11"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-2.5 w-2.5"
                                    >
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square" />
                                    </svg>
                                </a>
                            </span>
                        </li>
                        <li
                            class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-1/2 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]"
                        >
                            <span class="relative bg-white py-1 dark:bg-[#161615]">
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                </span>
                            </span>
                            <span>
                                Join our community on
                                <a
                                    href="https://discord.gg/uTnaQrCrK6"
                                    target="_blank"
                                    class="ml-1 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
                                >
                                    <span>Discord</span>
                                    <svg
                                        width="10"
                                        height="11"
                                        viewBox="0 0 10 11"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-2.5 w-2.5"
                                    >
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square" />
                                    </svg>
                                </a>
                            </span>
                        </li>
                    </ul>
                    <ul class="flex gap-3 text-sm leading-normal">
                        <li>
                            <Link v-if="$page.props.tenant?.id == undefined"
                                :href="route('register', { tenant: $page.props.tenant?.id })"
                                class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-sm leading-normal text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                            >
                                Create new EnderLink project
                            </Link>
                            <Link v-if="$page.props.tenant?.id !== undefined && !$page.props.auth.user"
                                :href="route('tenant.register', { tenant: $page.props.tenant?.id })"
                                class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-sm leading-normal text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                            >
                                Create new account
                            </Link>
                        </li>
                    </ul>
                </div>
                <div
                    class="relative -mb-px aspect-335/376 w-full shrink-0 overflow-hidden rounded-t-lg bg-[#fff2f2] lg:mb-0 lg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg dark:bg-[#1D0002]"
                >
                    <img
                        src="/images/enderlink.png"
                        alt="EnderLink Welcome Image"
                        class="absolute inset-0 p-25 h-full w-full object-cover object-center"
                    />
                                </div>
            </main>
            </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
    </PublicLayout>
</template>
