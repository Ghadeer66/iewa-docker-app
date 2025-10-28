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
                    <p class="mt-2 text-sm text-gray-600">شما به عنوان نماینده {{ user.business_name }} وارد شده‌اید.
                    </p>
                </div>
            </div>

            <!-- Actions Grid: CSV Upload + Subsidy -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- CSV Upload Card -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M4 3a2 2 0 00-2 2v8a2 2 0 002 2h4l2 2 2-2h2a2 2 0 002-2V9l-5-6H4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">آپلود کارکنان (CSV)</h3>
                                <p class="text-xs text-gray-500">ستون‌های لازم: name, phone, personal code</p>
                            </div>
                        </div>
                        <form @submit.prevent="submitCsv" class="space-y-4">
                            <label class="block">
                                <span class="block text-sm text-gray-700 mb-2">فایل CSV</span>
                                <div
                                    class="relative border-2 border-dashed rounded-xl p-6 text-center hover:bg-gray-50 transition">
                                    <input type="file" accept=".csv,.txt" @change="onCsvChange"
                                        class="absolute inset-0 opacity-0 cursor-pointer" />
                                    <div class="text-gray-600">
                                        <span class="text-sm">فایل را اینجا رها کنید یا برای انتخاب کلیک کنید</span>
                                        <div v-if="csvFile" class="mt-2 text-xs text-gray-500 truncate">{{ csvFile.name
                                        }}</div>
                                    </div>
                                </div>
                            </label>
                            <div class="flex items-center gap-3">
                                <button :disabled="csvUploading" type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white disabled:opacity-50 cursor-pointer">
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
                <!-- Subsidy Card -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-10 w-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5H9v2H7v2h2v2h2v-2h2V7h-2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">تعریف سوبسید کارمند</h3>
                                <p class="text-xs text-gray-500">کد پرسنلی را وارد کنید و درصد را تنظیم کنید</p>
                            </div>
                        </div>

                        <form @submit.prevent="submitSubsidy"
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end text-black">

                            <!-- Personal Code -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">کد پرسنلی کاربر</label>
                                <input v-model="subsidy.personal_code" type="text"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="مثلاً XA123" />
                            </div>

                            <!-- Max Buying Price -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">سقف خرید نفر (تومان)</label>
                                <input v-model.number="subsidy.max_price" type="number" min="0" max="5000000"
                                    @input="subsidy.max_price = Math.min(subsidy.max_price || 0, 5000000)"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="0 - 5,000,000" />
                            </div>


                            <!-- Subsidy Percentage -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">درصد سوبسید</label>
                                <input v-model.number="subsidy.percentage" type="number" min="0" max="100"
                                    :disabled="!subsidy.max_price"
                                    @input="subsidy.percentage = Math.min(Math.max(subsidy.percentage || 0, 0), 100)"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="0-100" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">از تاریخ</label>
                                <input v-model="subsidy.starts_at" type="date"
                                    class="w-full border rounded-lg px-3 py-2" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">تا تاریخ</label>
                                <input v-model="subsidy.ends_at" type="date"
                                    class="w-full border rounded-lg px-3 py-2" />
                            </div>

                            <!-- Submit Button -->
                            <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                <button :disabled="subsidyLoading || !subsidy.max_price || !subsidy.percentage"
                                    type="submit"
                                    class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white disabled:opacity-50 cursor-pointer">
                                    {{ subsidyLoading ? 'در حال ذخیره...' : 'ذخیره سوبسید' }}
                                </button>
                                <div class="min-h-5">
                                    <span v-if="subsidyMessage" class="text-sm text-green-600">{{ subsidyMessage
                                    }}</span>
                                    <span v-if="subsidyError" class="text-sm text-red-600">{{ subsidyError }}</span>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>

            </div>

            <!-- Clients List -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM2 15a6 6 0 1112 0H2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">کاربران اختصاصی شما</h3>
                                    <p class="text-xs text-gray-500">لیست کاربران (مشتریان) مرتبط با شرکت شما</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <template v-if="user.clients && user.clients.length">
                                <div
                                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-black">
                                    <ul class="divide-y divide-gray-200">
                                        <li v-for="client in user.clients" :key="client.id"
                                            class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                                            <div class="flex-1">
                                                <div class="text-sm font-semibold text-gray-800">
                                                    {{ client.name }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    <span class="font-medium text-gray-600">کد پرسنلی:</span>
                                                    {{ client.personal_code }}
                                                    <span class="mx-2">•</span>
                                                    {{ client.phone }}
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button @click="startEdit(client)"
                                                    class="text-sm px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">ویرایش</button>

                                                <button @click="confirmDelete(client)"
                                                    class="text-sm px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 cursor-pointer">حذف</button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </template>

                            <template v-else>
                                <div
                                    class="text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-xl p-4 text-center">
                                    هیچ کاربری به شما اختصاص داده نشده است.
                                </div>
                            </template>

                            <!-- Inline edit modal -->
                            <div v-if="editingClient" class="fixed inset-0 flex items-center justify-center z-50">
                                <div class="absolute inset-0 bg-black/40" @click="cancelEdit"></div>
                                <div class="bg-white rounded-xl shadow-lg p-6 z-10 w-full max-w-md">
                                    <h4 class="text-lg font-semibold mb-3">ویرایش کاربر</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-gray-400">نام</label>
                                            <input v-model="editForm.name" type="text"
                                                class="w-full border text-black rounded-lg px-3 py-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">کد پرسنلی</label>
                                            <input v-model="editForm.personal_code" type="text"
                                                class="w-full text-black border rounded-lg px-3 py-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">تلفن</label>
                                            <input v-model="editForm.phone" type="text"
                                                class="w-full border text-black rounded-lg px-3 py-2" />
                                        </div>
                                        <div class="flex items-center gap-3 justify-end">
                                            <button @click="cancelEdit"
                                                class="px-4 py-2 text-white rounded-lg border cursor-pointer bg-red-400 hover:bg-red-500">انصراف</button>
                                            <button @click="submitEdit"
                                                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">ذخیره</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete confirmation modal -->
                            <div v-if="deletingClient" class="fixed inset-0 flex items-center justify-center z-50">
                                <div class="absolute inset-0 bg-black/40" @click="deletingClient = null"></div>
                                <div class="bg-white rounded-xl shadow-lg p-6 z-10 w-full max-w-sm">
                                    <h4 class="text-lg font-semibold mb-3">حذف کاربر</h4>
                                    <p class="text-sm text-gray-700 mb-4">آیا مطمئن هستید که می‌خواهید این کاربر را حذف
                                        کنید؟ این عمل برگشت‌ناپذیر
                                        است.</p>
                                    <div class="flex justify-end gap-3">
                                        <button @click="deletingClient = null"
                                            class="px-4 py-2 rounded-lg border">انصراف</button>
                                        <button @click="submitDelete"
                                            class="px-4 py-2 rounded-lg bg-red-600 text-white">حذف</button>
                                    </div>
                                </div>
                            </div>

                        </div>

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
const subsidy = reactive({
    personal_code: '',
    max_price: null,     // added max_price
    percentage: null,
    starts_at: '',
    ends_at: ''
})
const subsidyLoading = ref(false)
const subsidyMessage = ref('')
const subsidyError = ref('')

// Client edit/delete state
const editingClient = ref(null)
const deletingClient = ref(null)
const editForm = reactive({ id: null, name: '', personal_code: '', phone: '' })

const startEdit = (client) => {
    editingClient.value = client.id
    editForm.id = client.id
    editForm.name = client.name || ''
    editForm.personal_code = client.personal_code || ''
    editForm.phone = client.phone || ''
}

const cancelEdit = () => {
    editingClient.value = null
    editForm.id = null
}

const submitEdit = async () => {
    try {
        await router.put(`/business/employees/${editForm.id}`, {
            name: editForm.name,
            personal_code: editForm.personal_code,
            phone: editForm.phone,
        }, {
            onSuccess: (page) => {
                editingClient.value = null
            },
            onError: (err) => {
                // Simple error handling; you may map errors to fields
                console.error(err)
            }
        })
    } catch (e) {
        console.error(e)
    }
}

const confirmDelete = (client) => {
    deletingClient.value = client
}

const submitDelete = async () => {
    if (!deletingClient.value) return
    try {
        await router.delete(`/business/employees/${deletingClient.value.id}`, {
            onSuccess: () => {
                deletingClient.value = null
            },
            onError: (err) => {
                console.error(err)
            }
        })
    } catch (e) {
        console.error(e)
    }
}

const submitSubsidy = async () => {
    subsidyMessage.value = ''
    subsidyError.value = ''

    // Front-end validation
    if (!subsidy.personal_code || subsidy.max_price == null || subsidy.percentage == null) {
        subsidyError.value = 'کد پرسنلی، سقف خرید و درصد الزامی است'
        return
    }

    // Clamp values before sending
    subsidy.max_price = Math.min(Math.max(subsidy.max_price, 0), 5000000)
    subsidy.percentage = Math.min(Math.max(subsidy.percentage, 0), 100)

    subsidyLoading.value = true

    try {
        await router.post('/business/employees/subsidy-by-code', {
            personal_code: subsidy.personal_code,
            max_price: subsidy.max_price,         // included max_price
            percentage: subsidy.percentage,
            starts_at: subsidy.starts_at || null,
            ends_at: subsidy.ends_at || null,
        }, {
            onSuccess: (page) => {
                subsidyMessage.value = page?.props?.flash?.message || 'سوبسید ذخیره شد'
            },
            onError: (err) => {
                // err is the validation errors object from Laravel
                if (err?.personal_code?.[0]) {
                    subsidyError.value = 'کد پرسنلی پیدا نشد'
                } else if (err?.max_price?.[0]) {
                    subsidyError.value = 'سقف خرید مشخص نیست '
                } else if (err?.percentage?.[0]) {
                    subsidyError.value = 'درصد سوبسید مشخص نیست '
                } else if (err?.starts_at?.[0]) {
                    subsidyError.value = 'از تاریخ مشخص نیست '
                } else if (err?.ends_at?.[0]) {
                    subsidyError.value = 'تا تاریخ مشخص نیست '
                } else if (err?.message) {
                    subsidyError.value = err.message
                } else {
                    subsidyError.value = 'خطا در ذخیره'
                }
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
