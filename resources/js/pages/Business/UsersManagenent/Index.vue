<template>
    <BusinessAppLayout>
        <div class="flex" dir="rtl">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-lg h-screen p-6 border-l border-gray-200 sticky top-0">
                <nav class="space-y-4 text-right">
                    <a href="/business/dashboard"
                       class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">داشبورد</a>
                    <a href="/business/users"
                       class="block px-4 py-2 rounded-lg hover:bg-gray-100 bg-indigo-50 text-indigo-700 font-semibold">مدیریت کاربران</a>
                    <a href="/business/wallet"
                       class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">کیف پول</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-8">

                <!-- Clients List -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM2 15a6 6 0 1112 0H2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">کاربران اختصاصی شما</h3>
                                <p class="text-xs text-gray-500">لیست کاربران (مشتریان) مرتبط با شرکت شما</p>
                            </div>
                        </div>

                        <div>
                            <template v-if="user.clients && user.clients.length">
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-black">
                                    <ul class="divide-y divide-gray-200">
                                        <li v-for="client in user.clients" :key="client.id"
                                            class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                                            <div class="flex-1">
                                                <div class="text-sm font-semibold text-gray-800">{{ client.name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    <span class="font-medium text-gray-600">کد پرسنلی:</span> {{ client.personal_code }}
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
                                <div class="text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-xl p-4 text-center">
                                    هیچ کاربری به شما اختصاص داده نشده است.
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- CSV Upload -->
                <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                    <div class="px-6 py-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 3a2 2 0 00-2 2v8a2 2 0 002 2h4l2 2 2-2h2a2 2 0 002-2V9l-5-6H4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">آپلود کارکنان (CSV)</h3>
                                <p class="text-xs text-gray-500">ستون‌های لازم: name, personal_code</p>
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

                <!-- Actions Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Subsidy Form -->
                    <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                        <div class="px-6 py-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5H9v2H7v2h2v2h2v-2h2V7h-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">تعریف سوبسید برای کاربران انتخابی</h3>
                                    <p class="text-xs text-gray-500">کاربران موردنظر را انتخاب کرده و مقدار سوبسید را تعیین کنید</p>
                                </div>
                            </div>

                            <!-- Select Clients -->
                            <div class="border rounded-lg p-3 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">انتخاب کاربران</span>
                                    <button @click="toggleSelectAll('subsidy')" type="button" class="text-xs text-emerald-600 hover:text-emerald-800">
                                        {{ allSelectedSubsidy ? 'لغو انتخاب همه' : 'انتخاب همه' }}
                                    </button>
                                </div>
                                <div class="max-h-40 overflow-y-auto pr-2">
                                    <template v-if="user.clients && user.clients.length">
                                        <div v-for="client in user.clients" :key="client.id"
                                             class="flex items-center gap-2 py-1 border-b border-gray-100 last:border-none">
                                            <input type="checkbox" :value="client.id" v-model="selectedSubsidyClients"
                                                   class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-sm text-gray-700">{{ client.name }} — {{ client.personal_code }}</span>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="text-sm text-gray-500 text-center py-2">هیچ کاربری وجود ندارد.</div>
                                    </template>
                                </div>
                            </div>

                            <!-- Subsidy Form Inputs -->
                            <form @submit.prevent="submitSubsidy" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end text-black">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">سوبسید روزانه (تومان)</label>
                                    <input type="text" :value="formattedSubsidy" @input="onSubsidyInput($event.target.value)"
                                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="0" />
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">از تاریخ</label>
                                    <input v-model="subsidy.starts_at" type="date" class="w-full border rounded-lg px-3 py-2" />
                                </div>
                                <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                    <button :disabled="subsidyLoading || selectedSubsidyClients.length === 0 || !subsidy.max_price" type="submit"
                                            class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white disabled:opacity-50 cursor-pointer">
                                        {{ subsidyLoading ? 'در حال ذخیره...' : 'اعمال سوبسید' }}
                                    </button>
                                    <div class="min-h-5">
                                        <span v-if="subsidyMessage" class="text-sm text-green-600">{{ subsidyMessage }}</span>
                                        <span v-if="subsidyError" class="text-sm text-red-600" v-html="subsidyError"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Purchase Credit Form -->
                    <div class="bg-white overflow-hidden shadow rounded-2xl border border-gray-100">
                        <div class="px-6 py-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5H9v2H7v2h2v2h2v-2h2V7h-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">تعریف اعتبار برای کاربران انتخابی</h3>
                                    <p class="text-xs text-gray-500">شرکت می‌تواند اعتبار خرید ارائه دهد</p>
                                </div>
                            </div>

                            <!-- Select Clients -->
                            <div class="border rounded-lg p-3 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">انتخاب کاربران</span>
                                    <button @click="toggleSelectAll('credit')" type="button" class="text-xs text-blue-600 hover:text-blue-800">
                                        {{ allSelectedCredit ? 'لغو انتخاب همه' : 'انتخاب همه' }}
                                    </button>
                                </div>
                                <div class="max-h-40 overflow-y-auto pr-2">
                                    <template v-if="user.clients && user.clients.length">
                                        <div v-for="client in user.clients" :key="client.id"
                                             class="flex items-center gap-2 py-1 border-b border-gray-100 last:border-none">
                                            <input type="checkbox" :value="client.id" v-model="selectedCreditClients"
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm text-gray-700">{{ client.name }} — {{ client.personal_code }}</span>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="text-sm text-gray-500 text-center py-2">هیچ کاربری وجود ندارد.</div>
                                    </template>
                                </div>
                            </div>

                            <!-- Purchase Credit Form Inputs -->
                            <form @submit.prevent="submitCredit" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end text-black">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">اعتبار خرید (تومان)</label>
                                    <input type="text" :value="formattedCredit" @input="onCreditInput($event.target.value)"
                                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0" />
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">از تاریخ</label>
                                    <input v-model="credit.starts_at" type="date" class="w-full border rounded-lg px-3 py-2" />
                                </div>
                                <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                    <button :disabled="creditLoading || selectedCreditClients.length === 0 || !credit.amount" type="submit"
                                            class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white disabled:opacity-50 cursor-pointer">
                                        {{ creditLoading ? 'در حال ذخیره...' : 'اعمال اعتبار' }}
                                    </button>
                                    <div class="min-h-5">
                                        <span v-if="creditMessage" class="text-sm text-green-600">{{ creditMessage }}</span>
                                        <span v-if="creditError" class="text-sm text-red-600" v-html="creditError"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </BusinessAppLayout>
</template>

<script setup>
import BusinessAppLayout from '@/Layouts/BusinessAppLayout.vue'
import { ref, reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const { user } = defineProps({ user: Object })

/* ------------------ Subsidy ------------------ */
const subsidy = reactive({ max_price: null, starts_at: '' })
const selectedSubsidyClients = ref([])
const allSelectedSubsidy = ref(false)
const subsidyLoading = ref(false)
const subsidyMessage = ref('')
const subsidyError = ref('')

/* ------------------ Purchase Credit ------------------ */
const credit = reactive({ amount: null, starts_at: '' })
const selectedCreditClients = ref([])
const allSelectedCredit = ref(false)
const creditLoading = ref(false)
const creditMessage = ref('')
const creditError = ref('')

/* ------------------ CSV Upload ------------------ */
const csvFile = ref(null)
const csvUploading = ref(false)
const csvMessage = ref('')
const csvError = ref('')

const onCsvChange = (event) => {
    csvFile.value = event.target.files[0]
}

const submitCsv = async () => {
    if (!csvFile.value) {
        csvError.value = 'لطفاً یک فایل CSV انتخاب کنید'
        return
    }

    csvUploading.value = true
    csvMessage.value = csvError.value = ''

    const formData = new FormData()
    formData.append('file', csvFile.value) // <- make sure field name matches Laravel validation

    try {
        await router.post('/business/employees/upload', formData, {
            forceFormData: true, // Important for sending FormData
            onSuccess: page => {
                csvMessage.value = page?.props?.flash?.message || 'CSV با موفقیت آپلود شد'
                csvFile.value = null
            },
            onError: errors => {
                csvError.value = errors?.file ? errors.file : 'خطا در آپلود CSV'
            },
            onFinish: () => { csvUploading.value = false }
        })
    } catch (e) {
        csvError.value = 'خطای غیرمنتظره'
        csvUploading.value = false
    }
}

/* ------------------ Methods ------------------ */
const toggleSelectAll = (type) => {
    if (type === 'subsidy') {
        selectedSubsidyClients.value = allSelectedSubsidy.value ? [] : user.clients.map(c => c.id)
        allSelectedSubsidy.value = !allSelectedSubsidy.value
    } else if (type === 'credit') {
        selectedCreditClients.value = allSelectedCredit.value ? [] : user.clients.map(c => c.id)
        allSelectedCredit.value = !allSelectedCredit.value
    }
}

/* ------------------ Number Formatting ------------------ */
const formattedSubsidy = computed(() => {
    if (!subsidy.max_price && subsidy.max_price !== 0) return ''
    return subsidy.max_price.toLocaleString('en-US')
})
const onSubsidyInput = (val) => {
    const numeric = val.replace(/,/g, '')
    subsidy.max_price = numeric ? parseInt(numeric) : null
}

const formattedCredit = computed(() => {
    if (!credit.amount && credit.amount !== 0) return ''
    return credit.amount.toLocaleString('en-US')
})
const onCreditInput = (val) => {
    const numeric = val.replace(/,/g, '')
    credit.amount = numeric ? parseInt(numeric) : null
}

/* ------------------ Submit Functions ------------------ */
const submitSubsidy = async () => {
    subsidyMessage.value = subsidyError.value = ''
    if (!selectedSubsidyClients.value.length) return subsidyError.value = 'هیچ کاربری انتخاب نشده است'
    if (!subsidy.max_price) return subsidyError.value = 'مقدار سوبسید الزامی است'

    subsidyLoading.value = true
    try {
        await router.post('/business/employees/subsidy-multiple', {
            client_ids: selectedSubsidyClients.value,
            max_price: subsidy.max_price,
            starts_at: subsidy.starts_at || null
        }, {
            onSuccess: page => {
                subsidyMessage.value = page?.props?.flash?.message || 'سوبسید ذخیره شد'
                selectedSubsidyClients.value = []
                allSelectedSubsidy.value = false
            },
            onError: errors => {
                if (errors && typeof errors === 'object') {
                    const firstKey = Object.keys(errors)[0]
                    subsidyError.value = Array.isArray(errors[firstKey]) ? errors[firstKey][0] : errors[firstKey]
                } else subsidyError.value = errors || 'خطا در ذخیره سوبسید'
            },
            onFinish: () => { subsidyLoading.value = false }
        })
    } catch (e) {
        subsidyError.value = 'خطای غیرمنتظره'
        subsidyLoading.value = false
    }
}

const submitCredit = async () => {
    creditMessage.value = creditError.value = ''
    if (!selectedCreditClients.value.length) return creditError.value = 'هیچ کاربری انتخاب نشده است'
    if (!credit.amount) return creditError.value = 'مقدار اعتبار الزامی است'

    creditLoading.value = true
    try {
        await router.post('/business/employees/credit-multiple', {
            client_ids: selectedCreditClients.value,
            purchase_credit: credit.amount,
            starts_at: credit.starts_at || null
        }, {
            onSuccess: page => {
                creditMessage.value = page?.props?.flash?.message || 'اعتبار ذخیره شد'
                selectedCreditClients.value = []
                allSelectedCredit.value = false
            },
            onError: errors => {
                if (errors && typeof errors === 'object') {
                    const firstKey = Object.keys(errors)[0]
                    creditError.value = Array.isArray(errors[firstKey]) ? errors[firstKey][0] : errors[firstKey]
                } else creditError.value = errors || 'خطا در ذخیره اعتبار'
            },
            onFinish: () => { creditLoading.value = false }
        })
    } catch (e) {
        creditError.value = 'خطای غیرمنتظره'
        creditLoading.value = false
    }
}
</script>
