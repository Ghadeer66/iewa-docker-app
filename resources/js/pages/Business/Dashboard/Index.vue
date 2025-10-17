<template>
    <BusinessAppLayout>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Stats
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">کل سفارشات</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.total_orders }}</dd>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">سفارشات در انتظار</dt>
                        <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ stats.pending_orders }}</dd>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">سفارشات تکمیل شده</dt>
                        <dd class="mt-1 text-3xl font-semibold text-green-600">{{ stats.completed_orders }}</dd>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">درآمد کل</dt>
                        <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ stats.revenue }} تومان</dd>
                    </div>
                </div>
            </div> -->

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900">خوش آمدید، {{ user.name }}</h2>
                    <p class="mt-2 text-sm text-gray-600">شما به عنوان نماینده {{ user.business_name }} وارد شده‌اید.</p>
                </div>
            </div>

            <!-- Actions Grid: CSV Upload + Subsidy -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- CSV Upload Card -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v8a2 2 0 002 2h4l2 2 2-2h2a2 2 0 002-2V9l-5-6H4z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">آپلود کارکنان (CSV)</h3>
                                <p class="text-xs text-gray-500">ستون‌های لازم: name, phone, personal code</p>
                            </div>
                        </div>
                        <form @submit.prevent="submitCsv" class="space-y-4">
                            <label class="block">
                                <span class="block text-sm text-gray-700 mb-2">فایل CSV</span>
                                <div class="relative border-2 border-dashed rounded-xl p-6 text-center hover:bg-gray-50 transition">
                                    <input type="file" accept=".csv,.txt" @change="onCsvChange" class="absolute inset-0 opacity-0 cursor-pointer" />
                                    <div class="text-gray-600">
                                        <span class="text-sm">فایل را اینجا رها کنید یا برای انتخاب کلیک کنید</span>
                                        <div v-if="csvFile" class="mt-2 text-xs text-gray-500 truncate">{{ csvFile.name }}</div>
                                    </div>
                                </div>
                            </label>
                            <div class="flex items-center gap-3">
                                <button :disabled="csvUploading" type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white disabled:opacity-50">
                                    {{ csvUploading ? 'در حال آپلود...' : 'آپلود' }}
                                </button>
                            </div>
                            <div class="min-h-5">
                                <span v-if="csvMessage" class="text-sm text-green-600">{{ csvMessage }}</span>
                                <span v-if="csvError" class="text-sm text-red-600">{{ csvError }}</span>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Subsidy Card -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5H9v2H7v2h2v2h2v-2h2V7h-2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">تعریف سوبسید کارمند</h3>
                                <p class="text-xs text-gray-500">کد پرسنلی را وارد کنید و درصد را تنظیم کنید</p>
                            </div>
                        </div>
                        <form @submit.prevent="submitSubsidy" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end text-black">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">کد پرسنلی کاربر</label>
                                <input v-model="subsidy.personal_code" type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="مثلاً XA123" />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">درصد</label>
                                <input v-model.number="subsidy.percentage" type="number" min="1" max="100" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="1-100" />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">از تاریخ</label>
                                <input v-model="subsidy.starts_at" type="date" class="w-full border rounded-lg px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">تا تاریخ</label>
                                <input v-model="subsidy.ends_at" type="date" class="w-full border rounded-lg px-3 py-2" />
                            </div>
                            <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                <button :disabled="subsidyLoading" type="submit" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white disabled:opacity-50">
                                    {{ subsidyLoading ? 'در حال ذخیره...' : 'ذخیره سوبسید' }}
                                </button>
                                <div class="min-h-5">
                                    <span v-if="subsidyMessage" class="text-sm text-green-600">{{ subsidyMessage }}</span>
                                    <span v-if="subsidyError" class="text-sm text-red-600">{{ subsidyError }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BusinessAppLayout>
</template>

<script setup>
import BusinessAppLayout from '@/Layouts/BusinessAppLayout.vue'
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

defineProps({
    user: Object,
    stats: Object
})

// CSV upload state
const csvFile = ref(null)
const csvUploading = ref(false)
const csvMessage = ref('')
const csvError = ref('')

const onCsvChange = (e) => {
    csvFile.value = e.target.files?.[0] || null
}

const submitCsv = async () => {
    csvMessage.value = ''
    csvError.value = ''
    if (!csvFile.value) {
        csvError.value = 'لطفاً فایل CSV را انتخاب کنید'
        return
    }
    const fd = new FormData()
    fd.append('file', csvFile.value)
    csvUploading.value = true
    try {
        await router.post('/business/employees/upload', fd, {
            forceFormData: true,
            onSuccess: (page) => {
                csvMessage.value = page?.props?.flash?.message || 'آپلود انجام شد'
                csvFile.value = null
            },
            onError: (err) => {
                csvError.value = err?.file?.[0] || err?.message || 'خطا در آپلود'
            },
            onFinish: () => {
                csvUploading.value = false
            },
        })
    } catch (e) {
        csvError.value = 'خطای غیرمنتظره در آپلود'
        csvUploading.value = false
    }
}

// Subsidy form state
const subsidy = reactive({ personal_code: '', percentage: null, starts_at: '', ends_at: '' })
const subsidyLoading = ref(false)
const subsidyMessage = ref('')
const subsidyError = ref('')

const submitSubsidy = async () => {
    subsidyMessage.value = ''
    subsidyError.value = ''
    if (!subsidy.personal_code || !subsidy.percentage) {
        subsidyError.value = 'کد پرسنلی و درصد الزامی است'
        return
    }
    subsidyLoading.value = true
    try {
        await router.post('/business/employees/subsidy-by-code', {
            personal_code: subsidy.personal_code,
            percentage: subsidy.percentage,
            starts_at: subsidy.starts_at || null,
            ends_at: subsidy.ends_at || null,
        }, {
            onSuccess: (page) => {
                subsidyMessage.value = page?.props?.flash?.message || 'سوبسید ذخیره شد'
            },
            onError: (err) => {
                subsidyError.value = err?.personal_code?.[0] || err?.percentage?.[0] || err?.message || 'خطا در ذخیره'
            },
            onFinish: () => {
                subsidyLoading.value = false
            },
        })
    } catch (e) {
        subsidyError.value = 'خطای غیرمنتظره'
        subsidyLoading.value = false
    }
}
</script>
