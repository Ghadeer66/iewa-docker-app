<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت مشتریان</h2>

            <!-- Add New Client Form -->
            <form @submit.prevent="createClient" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-4 gap-4">
                    <input v-model="form.name" placeholder="نام" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.email" placeholder="ایمیل" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.phone" placeholder="تلفن" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.personal_code" placeholder="کد پرسنلی"
                        class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.position" placeholder="پوزیشن سازمان
" class="p-2 bg-gray-700 rounded text-white" />

                    <select v-model="form.belongs_to" class="p-2 bg-gray-700 rounded text-white">
                        <option value="">انتخاب شرکت</option>
                        <option v-for="company in companies" :key="company.id" :value="company.id">
                            {{ company.name }}
                        </option>
                    </select>
                </div>
                <button class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">
                    افزودن مشتری
                </button>
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
                                <button @click="viewClient(client)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button @click="deleteClient(client.id)" class="text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v0H8V5a2 2 0 012-2z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminAppLayout>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    clients: Array,
    companies: Array,
})

const form = ref({
    name: '',
    email: '',
    phone: '',
    belongs_to: '',
})

function createClient() {
    router.post('/admin/users/clients', form.value)
    form.value = { name: '', email: '', phone: '', belongs_to: '', personal_code: '', position: '',  }
}

function viewClient(client) {
    alert('جزئیات مشتری: ' + client.name)
}

function deleteClient(id) {
    if (confirm('آیا از حذف این مشتری مطمئن هستید؟')) {
        router.delete(route('admin.clients.destroy', id))
    }
}
</script>
