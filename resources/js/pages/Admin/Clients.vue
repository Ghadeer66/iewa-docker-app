<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    clients: Array,
    companies: Array,
})

const clients = ref([...props.clients])
const companies = ref([...props.companies])

const form = ref({
    name: '',
    email: '',
    phone: '',
    belongs_to: '',
    personal_code: '',
    position: ''
})

// Search filters
const filters = ref({ search: '' })

function createClient() {
    router.post('/admin/users/clients', form.value, {
        onSuccess: (page) => {
            clients.value = page.props.clients
            form.value = { name: '', email: '', phone: '', belongs_to: '', personal_code: '', position: '' }
        }
    })
}

function viewClient(client) {
    alert('جزئیات مشتری: ' + client.name)
}

function deleteClient(id) {
    if (confirm('آیا از حذف این مشتری مطمئن هستید؟')) {
        router.delete(`/admin/users/clients/${id}`, {
            onSuccess: (page) => {
                clients.value = page.props.clients
            }
        })
    }
}

// --- Real-time search ---
function searchClients() {
    router.get('/admin/users/clients', { search: filters.value.search }, {
        preserveState: true,
        replace: true,
        onSuccess: (page) => {
            clients.value = page.props.clients
        }
    })
}

function clearSearch() {
    filters.value.search = ''
    searchClients()
}
</script>

<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت مشتریان</h2>

            <!-- 🔍 Search Section -->
            <div class="bg-gray-800 p-4 rounded mb-6 flex items-center space-x-2">
                <input v-model="filters.search" type="text" placeholder="جستجو بر اساس نام، ایمیل یا تلفن..."
                    class="flex-1 p-2 bg-gray-700 rounded text-white" />
                <button @click="searchClients" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">
                    جستجو
                </button>
                <button v-if="filters.search" @click="clearSearch"
                    class="bg-gray-600 text-white px-4 py-2 rounded font-bold">
                    پاک کردن
                </button>
            </div>

            <!-- Add New Client Form -->
            <form @submit.prevent="createClient" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <input v-model="form.name" placeholder="نام" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.email" placeholder="ایمیل" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.phone" placeholder="تلفن" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.personal_code" placeholder="کد پرسنلی"
                        class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.position" placeholder="پوزیشن سازمان"
                        class="p-2 bg-gray-700 rounded text-white" />

                    <select v-model="form.belongs_to" class="p-2 bg-gray-700 rounded text-white">
                        <option value="">انتخاب شرکت</option>
                        <option v-for="company in companies" :key="company.id" :value="company.id">
                            {{ company.name }}
                        </option>
                    </select>
                </div>
                <button class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن مشتری</button>
            </form>

            <!-- Clients List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام</th>
                            <th class="p-2">ایمیل</th>
                            <th class="p-2">تلفن</th>
                            <th class="p-2">شرکت</th>
                            <th class="p-2">تاریخ ثبت</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="client in clients" :key="client.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ client.name }}</td>
                            <td class="p-2">{{ client.email }}</td>
                            <td class="p-2">{{ client.phone || '---' }}</td>
                            <td class="p-2">{{ client.parent_business?.name || '---' }}</td>
                            <td class="p-2">{{ new Date(client.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2 flex space-x-2">
                                <button @click="viewClient(client)"
                                    class="text-blue-400 hover:text-blue-600">👁️</button>
                                <button @click="deleteClient(client.id)"
                                    class="text-red-400 hover:text-red-600">🗑️</button>
                            </td>
                        </tr>
                        <tr v-if="clients.length === 0">
                            <td colspan="6" class="text-center text-gray-400 p-4">مشتری‌ای یافت نشد</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminAppLayout>
</template>
