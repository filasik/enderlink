<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert"
import { LockKeyholeOpen } from 'lucide-vue-next';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex items-center justify-center min-h-screen bg-gray-900 text-white dark:bg-gray-900 dark:text-white bg-white text-gray-900 transition-colors duration-300">
        <div class="w-full max-w-3xl mx-auto text-center p-8">
            <!-- Illustration -->
            <div class="my-12 flex justify-center">
                <img
                    src="/images/enderlink.png"
                    alt="EnderLink Welcome Image"
                    class="rounded-lg shadow-lg w-32 h-32 object-cover object-center bg-gray-100 dark:bg-gray-800"
                />
            </div>
            <!-- Logo/Project Name -->
            <h1 class="text-5xl md:text-7xl font-bold bg-gradient-to-r from-purple-500 to-indigo-500 text-transparent bg-clip-text select-none">
                EnderLink
            </h1>
            <!-- Coming Soon Subtitle -->
            <p class="mt-4 text-xl md:text-2xl text-gray-700 font-light dark:text-gray-300">
                A new era of Minecraft server management is coming soon.
            </p>
            <!-- Project Description -->
            <p class="mt-6 text-base md:text-lg text-gray-500 dark:text-gray-400">
                EnderLink is a modern companion web application for Minecraft servers, designed to help administrators and communities manage, monitor, and interact with their server and its users. We are working hard to bring it to you!
            </p>
            <!-- Action Buttons -->
            <div class="mt-10 flex flex-col md:flex-row gap-4 justify-center">
                <a href="https://github.com/filasik/enderlink"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center px-6 py-3 rounded-lg font-semibold shadow transition-all duration-200
                          bg-gray-800 text-white border border-gray-700 hover:bg-gray-900 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white
                          dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-900 dark:focus:ring-offset-gray-900"
                >
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.165 6.839 9.489.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.378.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                    </svg>
                    GitHub
                </a>
                <a href="https://discord.gg/uTnaQrCrK6"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center px-6 py-3 rounded-lg font-semibold shadow transition-all duration-200
                          bg-indigo-600 text-white border border-indigo-700 hover:bg-indigo-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white
                          dark:bg-indigo-500 dark:border-indigo-400 dark:hover:bg-indigo-700 dark:focus:ring-offset-gray-900"
                >
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.317 4.369A19.791 19.791 0 0 0 16.885 3.1a.112.112 0 0 0-.119.056c-.524.908-1.11 2.096-1.527 3.037a18.524 18.524 0 0 0-5.086 0c-.417-.941-1.003-2.129-1.527-3.037a.115.115 0 0 0-.119-.056A19.736 19.736 0 0 0 3.684 4.369a.105.105 0 0 0-.047.043C.533 9.043-.32 13.579.099 18.057a.116.116 0 0 0 .045.081c2.052 1.507 4.041 2.422 5.992 3.029a.112.112 0 0 0 .123-.042c.462-.63.873-1.295 1.226-1.994a.112.112 0 0 0-.061-.155c-.652-.247-1.27-.549-1.872-.892a.112.112 0 0 1-.011-.188c.126-.094.252-.192.374-.291a.112.112 0 0 1 .114-.013c3.927 1.793 8.18 1.793 12.062 0a.112.112 0 0 1 .115.012c.122.099.248.197.374.291a.112.112 0 0 1-.01.188 12.298 12.298 0 0 1-1.873.893.112.112 0 0 0-.06.154c.36.699.771 1.364 1.225 1.994a.112.112 0 0 0 .123.042c1.961-.607 3.95-1.522 5.993-3.029a.112.112 0 0 0 .045-.081c.5-5.177-.838-9.673-3.637-13.645a.104.104 0 0 0-.047-.043zM8.02 15.331c-1.183 0-2.156-1.085-2.156-2.419 0-1.333.955-2.418 2.156-2.418 1.21 0 2.175 1.095 2.156 2.418 0 1.334-.955 2.419-2.156 2.419zm7.974 0c-1.183 0-2.156-1.085-2.156-2.419 0-1.333.955-2.418 2.156-2.418 1.21 0 2.175 1.095 2.156 2.418 0 1.334-.946 2.419-2.156 2.419z"/>
                    </svg>
                    Discord
                </a>
                <a href="https://github.com/filasik/enderlink"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center px-6 py-3 rounded-lg font-semibold shadow transition-all duration-200
                          bg-gradient-to-r from-orange-500 to-pink-500 text-white border-0 hover:from-orange-600 hover:to-pink-600 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 focus:ring-offset-white
                          dark:from-orange-400 dark:to-pink-500 dark:hover:from-orange-500 dark:hover:to-pink-600 dark:focus:ring-offset-gray-900"
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 19V6M5 12l7-7 7 7"/>
                    </svg>
                    Documentation
                </a>
            </div>
            <!-- Register/Create Project Buttons -->
            <div class="mt-8 flex flex-col md:flex-row gap-3 justify-center">
                <Link v-if="$page.props.tenant?.id == undefined"
                    :href="route('register', { tenant: $page.props.tenant?.id })"
                    class="inline-block rounded-lg border border-black bg-[#1b1b18] px-5 py-2 text-sm leading-normal text-white hover:bg-black hover:scale-105 transition-all duration-200
                           dark:border-gray-200 dark:bg-gray-200 dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:text-black"
                >
                    Create new EnderLink project
                </Link>
            </div>
        </div>
    </div>
</template>
