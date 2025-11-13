<template>
    <BusinessAppLayout>
        <div class="flex" dir="rtl">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-lg h-screen p-6 border-l border-gray-200 sticky top-0">
                <nav class="space-y-4">
                    <Link
                        href="/business/dashboard"
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100 bg-indigo-50 text-indigo-700 font-semibold"
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
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium"
                    >
                        کیف پول
                    </Link>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Welcome Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-semibold text-gray-900">
                            خوش آمدید، {{ user.name }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            شما به عنوان نماینده {{ user.business_name }} وارد شده‌اید.
                        </p>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white shadow rounded-lg p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-700">تعداد کاربران</h3>
                        <p class="mt-2 text-3xl font-semibold text-indigo-600">{{ stats.users_count }}</p>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-700">موجودی کیف پول</h3>
                        <p class="mt-2 text-3xl font-semibold text-green-600">
                            {{ stats.wallet_balance }} تومان
                        </p>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-700">تعداد تراکنش‌ها</h3>
                        <p class="mt-2 text-3xl font-semibold text-blue-600">{{ stats.transactions_count }}</p>
                    </div>
                </div>

                <!-- Payments Chart -->
                <div class="bg-white shadow rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">نمودار پرداخت‌ها</h3>
                    <apexchart
                        width="100%"
                        height="300"
                        type="line"
                        :options="chartOptions"
                        :series="series"
                    />
                </div>
            </main>
        </div>
    </BusinessAppLayout>
</template>

<script setup>
import BusinessAppLayout from '@/Layouts/BusinessAppLayout.vue'
import { Link } from '@inertiajs/vue3'
import VueApexCharts from 'vue3-apexcharts'
import { ref } from 'vue'

// Register ApexCharts component
const apexchart = VueApexCharts

// Props from Laravel
const { user, stats } = defineProps({
    user: Object,
    stats: Object
})

// Payment data
const paymentData = [
    { month: 'فروردین', amount: 1200000 },
    { month: 'اردیبهشت', amount: 500000 },
    { month: 'خرداد', amount: 1450000 },
    { month: 'تیر', amount: 1100000 },
    { month: 'مرداد', amount: 1750000 },
    { month: 'شهریور', amount: 1300000 }
]

// Chart data setup
const series = ref([
    {
        name: 'مبلغ پرداختی',
        data: paymentData.map(item => item.amount)
    }
])

const chartOptions = ref({
    chart: {
        type: 'line',
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    dataLabels: { enabled: false },
    xaxis: {
        categories: paymentData.map(item => item.month),
        labels: {
            style: { fontFamily: 'IRANSans, sans-serif' }
        }
    },
    yaxis: {
        labels: {
            formatter: val => `${val.toLocaleString()} تومان`
        }
    },
    tooltip: {
        y: {
            formatter: val => `${val.toLocaleString()} تومان`
        }
    },
    colors: ['#4f46e5']
})
</script>

<style scoped>
body {
    background-color: #f9fafb;
}
</style>
