<template>
    <BusinessAppLayout>
        <div class="flex" dir="rtl">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-lg h-screen p-6 border-l border-gray-200 sticky top-0">
                <nav class="space-y-4">
                    <Link
                        href="/business/dashboard"
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium"
                    >
                        داشبورد
                    </Link>
                    <Link
                        href="/business/employees-management"
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium"
                    >
                        مدیریت کاربران
                    </Link>
                    <Link
                        href="/business/wallet"
                        class="block px-4 py-2 rounded-lg bg-indigo-50 text-indigo-700 font-semibold"
                    >
                        کیف پول
                    </Link>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 max-w-7x mt-15 mx-auto py-8 sm:px-6 lg:px-8">
                <!-- Wallet Balance Card -->
                <div
                    class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-2xl shadow-lg p-12 mb-8 flex flex-col md:flex-row justify-between items-center"
                >
                    <div>
                        <h2 class="text-2xl font-semibold mb-2">موجودی فعلی کیف پول</h2>
                        <p class="text-4xl font-bold">{{ formatCurrency(wallet.balance) }}</p>
                    </div>
                    <div class="mt-6 md:mt-0 space-x-2 space-x-reverse">
                        <button
                            @click="openDepositModal"
                            class="px-5 py-2 bg-green-500 mx-4 hover:bg-green-600 rounded-lg font-semibold text-black shadow-md transition"
                        >
                            واریز وجه
                        </button>
                        <button
                            @click="openWithdrawModal"
                            class="px-5 py-2 bg-red-500 hover:bg-red-600 rounded-lg font-semibold shadow-md transition"
                        >
                            برداشت وجه
                        </button>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">تاریخچه تراکنش‌ها</h3>
                        <div class="text-sm text-gray-500">{{ transactions.length }} تراکنش</div>
                    </div>

                    <div v-if="transactions.length" class="divide-y divide-gray-100">
                        <div
                            v-for="tx in transactions"
                            :key="tx.id"
                            class="flex justify-between items-center p-5 hover:bg-gray-50 transition"
                        >
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{
                                        tx.type === 'deposit'
                                            ? 'واریز وجه'
                                            : tx.type === 'withdrawal'
                                            ? 'برداشت وجه'
                                            : tx.type === 'subsidy'
                                            ? 'سوبسید'
                                            : tx.type === 'credit'
                                            ? 'اعتبار'
                                            : 'پرداخت'
                                    }}
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ new Date(tx.created_at).toLocaleString('fa-IR') }}

                                    <!-- Conditional from/to format -->
                                    <template v-if="tx.type === 'deposit' && tx.sender && tx.receiver">
                                        — به: {{ tx.sender.name }} — از: {{ tx.receiver.name }}
                                    </template>
                                    <template v-else-if="tx.type === 'payment' && tx.sender && tx.receiver">
                                        — از: {{ tx.sender.name }} — به: {{ tx.receiver.name }}
                                    </template>
                                </p>
                            </div>

                            <div
                                :class="[
                                    'text-lg font-semibold',
                                    tx.type === 'deposit' || tx.type === 'subsidy' || tx.type === 'credit'
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                ]"
                            >
                                {{
                                    (tx.type === 'deposit' || tx.type === 'subsidy' || tx.type === 'credit'
                                        ? ' + '
                                        : ' - ') + formatCurrency(tx.amount)
                                }}
                            </div>
                        </div>
                    </div>

                    <div v-else class="p-6 text-center text-gray-500">هیچ تراکنشی ثبت نشده است.</div>
                </div>
            </main>
        </div>
    </BusinessAppLayout>
</template>

<script setup>
import BusinessAppLayout from '@/Layouts/BusinessAppLayout.vue'
import { Link } from '@inertiajs/vue3'

// Props from Laravel
const { wallet, transactions } = defineProps({
    wallet: Object,
    transactions: Array,
})

// Format money nicely
function formatCurrency(value) {
    return new Intl.NumberFormat('fa-IR', {
        style: 'currency',
        currency: 'IRR',
    }).format(value)
}

// Button actions (placeholder)
function openDepositModal() {
    alert('واریز وجه در حال توسعه است...')
}

function openWithdrawModal() {
    alert('برداشت وجه در حال توسعه است...')
}
</script>

<style scoped>
body {
    background-color: #f9fafb;
}
</style>
