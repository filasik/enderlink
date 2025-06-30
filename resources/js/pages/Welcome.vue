<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<style scoped>
@keyframes animate-pulse-slow {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.8; }
}

.animate-pulse-slow {
  animation: animate-pulse-slow 3s ease-in-out infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

@keyframes glow {
  0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); }
  50% { box-shadow: 0 0 40px rgba(168, 85, 247, 0.8); }
}

.animate-glow {
  animation: glow 2s ease-in-out infinite;
}
</style>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="relative flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-40 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
        </div>

        <div class="relative w-full max-w-4xl mx-auto text-center p-8 z-10">
            <!-- Illustration with hover effects -->
            <div class="my-16 flex justify-center">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                    <img
                        src="/images/enderlink.png"
                        alt="EnderLink - Modern Minecraft Server Management Platform"
                        class="relative w-40 h-40 object-cover object-center transform group-hover:scale-105 transition-all duration-300"
                        loading="eager"
                    />
                </div>
            </div>
            <!-- Logo/Project Name with animation -->
            <h1 class="text-6xl md:text-8xl font-bold bg-gradient-to-r from-purple-400 via-pink-500 to-indigo-400 text-transparent bg-clip-text select-none animate-pulse-slow drop-shadow-lg">
                EnderLink
            </h1>
            <!-- Enhanced Subtitle -->
            <p class="mt-6 text-xl md:text-3xl text-gray-200 font-light tracking-wide">
                The Future of <span class="text-green-400 font-semibold">Minecraft</span> Server Management
            </p>
            <!-- Enhanced Project Description -->
            <div class="mt-8 max-w-2xl mx-auto">
                <p class="text-lg md:text-xl text-gray-300 leading-relaxed">
                    EnderLink is a <span class="text-purple-400 font-semibold">modern companion web application</span> for Minecraft servers, designed to help administrators and communities manage, monitor, and interact with their server and its users.
                </p>

            </div>
            <!-- Enhanced Action Buttons -->
            <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center items-center flex-wrap">
                <a href="https://github.com/filasik/enderlink"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group inline-flex items-center px-8 py-4 rounded-xl font-semibold shadow-lg transition-all duration-300
                          bg-white/10 backdrop-blur-sm text-white border border-white/20 hover:bg-white/20 hover:scale-110 hover:shadow-2xl
                          focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-transparent"
                   aria-label="View EnderLink source code on GitHub"
                >
                    <svg class="w-6 h-6 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.165 6.839 9.489.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.378.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                    </svg>
                    GitHub
                </a>
                <a href="https://discord.gg/uTnaQrCrK6"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group inline-flex items-center px-8 py-4 rounded-xl font-semibold shadow-lg transition-all duration-300
                          bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-0 hover:from-indigo-700 hover:to-purple-700 hover:scale-110 hover:shadow-2xl
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent"
                   aria-label="Join EnderLink Discord community"
                >
                    <svg class="w-6 h-6 mr-3 group-hover:bounce transition-all duration-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.317 4.369A19.791 19.791 0 0 0 16.885 3.1a.112.112 0 0 0-.119.056c-.524.908-1.11 2.096-1.527 3.037a18.524 18.524 0 0 0-5.086 0c-.417-.941-1.003-2.129-1.527-3.037a.115.115 0 0 0-.119-.056A19.736 19.736 0 0 0 3.684 4.369a.105.105 0 0 0-.047.043C.533 9.043-.32 13.579.099 18.057a.116.116 0 0 0 .045.081c2.052 1.507 4.041 2.422 5.992 3.029a.112.112 0 0 0 .123-.042c.462-.63.873-1.295 1.226-1.994a.112.112 0 0 0-.061-.155c-.652-.247-1.27-.549-1.872-.892a.112.112 0 0 1-.011-.188c.126-.094.252-.192.374-.291a.112.112 0 0 1 .114-.013c3.927 1.793 8.18 1.793 12.062 0a.112.112 0 0 1 .115.012c.122.099.248.197.374.291a.112.112 0 0 1-.01.188 12.298 12.298 0 0 1-1.873.893.112.112 0 0 0-.06.154c.36.699.771 1.364 1.225 1.994a.112.112 0 0 0 .123.042c1.961-.607 3.95-1.522 5.993-3.029a.112.112 0 0 0 .045-.081c.5-5.177-.838-9.673-3.637-13.645a.104.104 0 0 0-.047-.043zM8.02 15.331c-1.183 0-2.156-1.085-2.156-2.419 0-1.333.955-2.418 2.156-2.418 1.21 0 2.175 1.095 2.156 2.418 0 1.334-.955 2.419-2.156 2.419zm7.974 0c-1.183 0-2.156-1.085-2.156-2.419 0-1.333.955-2.418 2.156-2.418 1.21 0 2.175 1.095 2.156 2.418 0 1.334-.946 2.419-2.156 2.419z"/>
                    </svg>
                    Discord
                </a>
                <a href="https://github.com/filasik/enderlink"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group inline-flex items-center px-8 py-4 rounded-xl font-semibold shadow-lg transition-all duration-300
                          bg-gradient-to-r from-orange-500 to-pink-500 text-white border-0 hover:from-orange-600 hover:to-pink-600 hover:scale-110 hover:shadow-2xl
                          focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 focus:ring-offset-transparent"
                   aria-label="View EnderLink documentation"
                >
                    <svg class="w-6 h-6 mr-3 group-hover:translate-y-[-2px] transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 19V6M5 12l7-7 7 7"/>
                    </svg>
                    Documentation
                </a>
            </div>
            <!-- Enhanced Register/Create Project Button -->
            <div class="mt-10 flex justify-center">
                <Link v-if="$page.props.tenant?.id == undefined"
                    :href="route('register')"
                    class="group relative inline-flex items-center px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105
                           bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-xl hover:shadow-2xl
                           focus:outline-none focus:ring-4 focus:ring-green-500/50 overflow-hidden"
                    role="button"
                    tabindex="0"
                    aria-label="Create a new EnderLink project account"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-700 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    <svg class="relative w-6 h-6 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="relative">Create New EnderLink Project</span>
                </Link>
            </div>
        </div>
    </div>
</template>
