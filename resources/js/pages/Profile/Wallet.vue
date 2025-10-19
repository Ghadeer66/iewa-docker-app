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
                    <!-- Wallet Balance -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 mb-6">
                        <div class="text-center">
                            <h4 class="text-sm mb-2">موجودی کیف پول</h4>
                            <p class="text-3xl font-bold">{{ (user.wallet_balance || 0).toLocaleString() }} تومان</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <button
                            class="flex-1 bg-[#4e3356] text-white py-3 rounded-lg hover:bg-[#6b4781] transition font-medium">
                            افزایش موجودی
                        </button>
                        <button
                            class="flex-1 border border-[#4e3356] text-[#4e3356] py-3 rounded-lg hover:bg-[#4e3356] hover:text-white transition font-medium">
                            برداشت وجه
                        </button>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-4">تاریخچه کیف پول</h3>

                    <div class="text-center py-8">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <p class="text-gray-500">هیچ تراکنشی در کیف پول شما وجود ندارد</p>
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
