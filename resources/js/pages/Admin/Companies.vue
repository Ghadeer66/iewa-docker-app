<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت شرکت‌ها</h2>

            <!-- 🔍 Search -->
            <div class="bg-gray-800 p-4 rounded mb-6 flex items-center space-x-2">
                <input v-model="filters.search" type="text" placeholder="جستجو بر اساس نام، ایمیل یا نام شرکت..."
                    class="flex-1 p-2 bg-gray-700 rounded text-white" />
                <button @click="searchCompanies" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">
                    جستجو
                </button>
                <button v-if="filters.search" @click="clearSearch"
                    class="bg-gray-600 text-white px-4 py-2 rounded font-bold">
                    پاک کردن
                </button>
            </div>

            <!-- Add Company -->
            <form @submit.prevent="createCompany" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <input v-model="form.business_name" placeholder="نام شرکت"
                        class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.name" placeholder="نام مسئول" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.email" placeholder="ایمیل" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.phone" placeholder="تلفن" class="p-2 bg-gray-700 rounded text-white" />
                    <select v-model="form.admin_id" class="p-2 bg-gray-700 rounded text-white">
                        <option value="" disabled>انتخاب ادمین</option>
                        <option v-for="admin in admins" :key="admin.id" :value="admin.id">{{ admin.name }}</option>
                    </select>
                </div>
                <button class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن شرکت</button>
            </form>

            <!-- Companies Table -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام شرکت</th>
                            <th class="p-2">نام مسئول</th>
                            <th class="p-2">ایمیل</th>
                            <th class="p-2">ادمین</th>
                            <th class="p-2">تاریخ ثبت</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="company in companies.data" :key="company.id"
                            class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ company.business_name || '---' }}</td>
                            <td class="p-2">{{ company.name }}</td>
                            <td class="p-2">{{ company.email }}</td>
                            <td class="p-2">{{ company.admin?.name || '---' }}</td>
                            <td class="p-2">{{ new Date(company.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2 flex space-x-2">
                                <button @click="viewCompany(company)"
                                    class="text-blue-400 hover:text-blue-600 cursor-pointer">✏️</button>
                                <button @click="deleteCompany(company.id)"
                                    class="text-red-400 hover:text-red-600 cursor-pointer">🗑️</button>
                            </td>
                        </tr>
                        <tr v-if="companies.data.length === 0">
                            <td colspan="6" class="text-center text-gray-400 p-4">شرکتی یافت نشد</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminAppLayout>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    companies: Object, // paginated result
    admins: Array,
    filters: Object
})

const form = ref({
    business_name: '',
    name: '',
    email: '',
    phone: '',
    admin_id: ''
})

const filters = reactive({
    search: props.filters?.search ?? ''
})

function createCompany() {
    router.post('/admin/companies', form.value, {
        onSuccess: () => form.value = { business_name: '', name: '', email: '', phone: '', admin_id: '' }
    })
}

function searchCompanies() {
    router.get('/admin/companies', { search: filters.search }, { preserveState: true, replace: true })
}

function clearSearch() {
    filters.search = ''
    searchCompanies()
}

function viewCompany(company) {
    alert('جزئیات شرکت: ' + company.name)
}

function deleteCompany(id) {
    if (confirm('آیا از حذف این شرکت مطمئن هستید؟')) {
        router.delete(route('admin.companies.destroy', id))
    }
}

// defineOptions({ layout: AdminAppLayout })
</script>
