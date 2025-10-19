<template>
    <AppLayout>
        <div class="min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 py-16 flex items-center justify-center">
            <div class="max-w-5xl w-full mx-auto px-6 text-center">
                <!-- Hero Section -->
                <div class="mb-12">
                    <h1 class="text-5xl font-extrabold text-gray-800 mb-4 leading-tight">
                        پنل کسب‌وکار ایوا
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        با ایوا، مدیریت هوشمند و ساده کسب‌وکار غذایی خود را تجربه کنید
                    </p>
                </div>

                <!-- Card Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Login Card -->
                    <div class="bg-white/70 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-white/30 hover:shadow-2xl transition duration-300">
                        <div class="flex flex-col items-center">
                            <div class="bg-green-100 p-4 rounded-full mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-green-700 mb-3">ورود به پنل</h3>
                            <p class="text-gray-600 mb-6">قبلاً ثبت‌نام کرده‌اید؟ وارد شوید و کسب‌وکار خود را مدیریت کنید</p>
                            <a href="/business/login"
                                class="bg-green-500 text-white px-8 py-3 rounded-xl shadow hover:bg-green-600 hover:shadow-md transition duration-300">
                                ورود به پنل
                            </a>
                        </div>
                    </div>

                    <!-- Register Card -->
                    <div class="bg-white/70 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-white/30 hover:shadow-2xl transition duration-300">
                        <div class="flex flex-col items-center">
                            <div class="bg-indigo-100 p-4 rounded-full mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-indigo-700 mb-3">ثبت‌نام کسب‌وکار</h3>
                            <p class="text-gray-600 mb-6">هنوز عضو ایوا نیستید؟ همین حالا ثبت‌نام کنید</p>
                            <a href="/business/register"
                                class="bg-indigo-500 text-white px-8 py-3 rounded-xl shadow hover:bg-indigo-600 hover:shadow-md transition duration-300">
                                ثبت‌نام
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="mt-12 text-sm text-gray-500">
                    © ۲۰۲۵ ایوا - همه حقوق محفوظ است
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
</script>
