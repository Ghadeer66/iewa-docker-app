<template>
    <AdminAppLayout>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900">خوش آمدید، {{ user.name }}</h2>
                    <p class="mt-2 text-sm text-gray-600">شما به عنوان ادمین {{ user.admin_name }} وارد شده‌اید.</p>
                </div>
            </div>


        </div>
    </AdminAppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'

defineProps({
    user: Object,
    stats: Object
})


</script>
