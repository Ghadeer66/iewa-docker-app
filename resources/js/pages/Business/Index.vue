<template>
    <AppLayout>
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">پنل کسب‌وکار ایوا</h1>
                <p class="text-xl text-gray-600 mb-8">مدیریت حرفه‌ای کسب‌وکار غذایی خود را با ایوا تجربه کنید</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-green-600 mb-4">ورود به پنل</h3>
                        <p class="text-gray-600 mb-4">قبلاً ثبت‌نام کرده‌اید؟ وارد شوید</p>
                        <a href="/business/login" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                            ورود به پنل
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';

</script>
