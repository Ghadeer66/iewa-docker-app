<template>
    <AppLayout>
        <div class="flex flex-col md:flex-row gap-6 container mx-auto px-6 mt-6 mb-12">

            <!-- Sidebar Menu -->
            <aside class="w-full md:w-1/4 bg-white shadow rounded-xl p-4">
                <div class="flex items-center gap-3 mb-6">
                    <img :src="user.avatar ?? '/storage/images/default-avatar.png'" alt="avatar"
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

            <!-- Orders Content -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <!-- Orders Tabs -->
                    <div class="flex gap-2 mb-6 border-b pb-2 overflow-x-auto">
                        <button v-for="tab in orderTabs" :key="tab.key" @click="activeTab = tab.key" :class="[
                            'px-4 py-2 rounded-lg transition whitespace-nowrap text-sm font-medium',
                            activeTab === tab.key
                                ? 'bg-[#4e3356] text-white'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                        ]">
                            {{ tab.title }}
                        </button>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredOrders.length === 0" class="text-center py-12">
                        <div class="max-w-md mx-auto">
                            <!-- Empty illustration -->
                            <div
                                class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-gray-700 mb-2" v-if="activeTab === 'all'">
                                هنوز سفارشی ثبت نکرده‌اید
                            </h3>
                            <h3 class="text-xl font-bold text-gray-700 mb-2" v-else>
                                هیچ سفارشی در این بخش وجود ندارد
                            </h3>

                            <p class="text-gray-500 mb-6" v-if="activeTab === 'all'">
                                می‌توانید از منوی محصولات، اولین سفارش خود را ثبت کنید
                            </p>
                            <p class="text-gray-500 mb-6" v-else>
                                در حال حاضر هیچ سفارشی با این وضعیت ندارید
                            </p>

                            <button v-if="activeTab === 'all'" @click="goToMenu"
                                class="bg-[#4e3356] text-white px-6 py-3 rounded-lg hover:bg-[#6b4781] transition font-medium">
                                مشاهده محصولات
                            </button>
                            <button v-else @click="activeTab = 'all'"
                                class="bg-[#4e3356] text-white px-6 py-3 rounded-lg hover:bg-[#6b4781] transition font-medium">
                                مشاهده همه سفارشات
                            </button>
                        </div>
                    </div>

                    <!-- Orders List -->
                    <div v-else class="space-y-4">
                        <div v-for="order in filteredOrders" :key="order.id"
                            class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-gray-800">سفارش #{{ order.id }}</h4>
                                <span :class="statusClasses[order.status]">
                                    {{ order.status_text }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                <div>
                                    <strong>تاریخ:</strong> {{ order.created_at }}
                                </div>
                                <div>
                                    <strong>مبلغ:</strong> {{ formatAmount(order.total_amount) }}
                                </div>
                                <div>
                                    <strong>تعداد آیتم‌ها:</strong> {{ order.items_count }}
                                </div>
                            </div>

                            <!-- Additional order info based on status -->
                            <div v-if="order.status === 'sent'" class="mt-3 bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-blue-700">
                                    <strong>پیگیری سفارش:</strong>
                                    <span v-if="order.tracking_code">کد رهگیری: {{ order.tracking_code }}</span>
                                    <span v-else>سفارش شما در حال ارسال است</span>
                                </p>
                            </div>

                            <div v-if="order.status === 'unpaid'" class="mt-3 bg-orange-50 p-3 rounded-lg">
                                <p class="text-sm text-orange-700">
                                    <strong>توجه:</strong> این سفارش در انتظار پرداخت است
                                </p>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <button @click="viewOrderDetails(order)"
                                    class="bg-[#4e3356] text-white px-4 py-2 rounded-lg hover:bg-[#6b4781] transition text-sm">
                                    مشاهده جزییات
                                </button>
                                <button v-if="order.status === 'pending' || order.status === 'unpaid'"
                                    @click="cancelOrder(order)"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                                    لغو سفارش
                                </button>
                                <button v-if="order.status === 'unpaid'" @click="payOrder(order)"
                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm">
                                    پرداخت سفارش
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
import { computed, ref } from 'vue'

const props = defineProps({
    user: Object,
    orders: {
        type: Array,
        default: () => []
    }
})

const activeTab = ref('all')

// Updated order tabs with your specific statuses
const orderTabs = [
    { key: 'all', title: 'همه سفارشات' },
    { key: 'pending', title: 'سفارشات جاری' },
    { key: 'sent', title: 'ارسال شده' },
    { key: 'canceled', title: 'لغو شده' },
    { key: 'unpaid', title: 'پرداخت نشده' }
]

const statusClasses = {
    pending: 'bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium',
    sent: 'bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium',
    canceled: 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium',
    unpaid: 'bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-medium',
    completed: 'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium'
}

const filteredOrders = computed(() => {
    if (activeTab.value === 'all') return props.orders
    return props.orders.filter(order => order.status === activeTab.value)
})

// Safe amount formatter
const formatAmount = (amount) => {
    if (amount === null || amount === undefined) {
        return '۰ تومان'
    }
    return `${amount.toLocaleString()} تومان`
}

const goTo = (page) => {
    router.get(`/profile/${page}`)
}

const goToMenu = () => {
    router.get('/menu')
}

const logout = () => {
    router.post('/logout')
}

const viewOrderDetails = (order) => {
    router.get(`/orders/${order.id}`)
}

const cancelOrder = (order) => {
    if (confirm('آیا از لغو این سفارش مطمئن هستید؟')) {
        router.post(`/orders/${order.id}/cancel`)
    }
}

const payOrder = (order) => {
    router.post(`/orders/${order.id}/pay`)
}
</script>

<style scoped>
/* Custom scrollbar for tabs */
.flex.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.flex.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.flex.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.flex.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
