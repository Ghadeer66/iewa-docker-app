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
                        <button @click="logout" class="text-red-600 hover:text-red-800">خروج</button>
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
