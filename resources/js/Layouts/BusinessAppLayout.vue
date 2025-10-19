<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Business Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">پنل شرکت</h1>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <span class="text-gray-700 mx-4">{{ $page.props.auth.user.business_name }}</span>
                        <button
    @click="logout"
    class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-400"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
    </svg>
    خروج
</button>

                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const logout = () => {
    router.post('/business/logout')
}
</script>
