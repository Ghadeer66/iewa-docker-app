<template>
    <AppLayout>
        <div class="flex flex-col md:flex-row gap-6 container mx-auto px-6 mt-6 mb-12">

            <!-- Sidebar Menu -->
            <aside class="w-full md:w-1/4 bg-white shadow rounded-xl p-4">
                <div class="flex items-center gap-3 mb-6">
                    <img :src="user.avatar ?? '/images/default-avatar.png'" alt="avatar"
                        class="w-12 h-12 rounded-full object-cover" />
                    <div>
                        <h3 class="font-bold text-gray-800">{{ user.name }}</h3>
                        <p class="text-sm text-gray-500">{{ user.phone ?? 'شماره تلفن ثبت نشده' }}</p>
                    </div>
                </div>

                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded" @click="goTo('')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>داشبورد</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('orders')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>سفارشات من</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('addresses')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>آدرس های من</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('transactions')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>تاریخچه تراکنش ها</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('wallet')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>کیف پول من</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('comments')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>نظرات</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded"
                        @click="goTo('settings')">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>تنظیمات پروفایل</span>
                    </li>
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded" @click="logout">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-red-500">خروج از حساب</span>
                    </li>
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">تنظیمات پروفایل</h2>

                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">اطلاعات شخصی</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">نام و نام
                                        خانوادگی</label>
                                    <input type="text" :value="user.name"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4e3356] focus:border-transparent"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                                    <input type="email" :value="user.email"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4e3356] focus:border-transparent"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">شماره تلفن</label>
                                    <input type="tel" :value="user.phone || ''"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4e3356] focus:border-transparent"
                                        placeholder="ثبت نشده" readonly>
                                </div>
                            </div>
                            <button
                                class="mt-4 bg-[#4e3356] text-white px-4 py-2 rounded-lg hover:bg-[#6b4781] transition">
                                ویرایش اطلاعات
                            </button>
                        </div>

                        <!-- Security Settings -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">تنظیمات امنیتی</h3>
                            <div class="space-y-3">
                                <button
                                    class="w-full text-right bg-gray-50 hover:bg-gray-100 p-3 rounded-lg transition text-gray-700">
                                    تغییر رمز عبور
                                </button>
                                <button
                                    class="w-full text-right bg-gray-50 hover:bg-gray-100 p-3 rounded-lg transition text-gray-700">
                                    تنظیمات اعلان‌ها
                                </button>
                                <button
                                    class="w-full text-right bg-gray-50 hover:bg-gray-100 p-3 rounded-lg transition text-gray-700">
                                    حریم خصوصی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    user: Object
})

const goTo = (page) => {
    router.get(`/profile/${page}`)
}

const logout = () => {
    router.post('/logout')
}
</script>
