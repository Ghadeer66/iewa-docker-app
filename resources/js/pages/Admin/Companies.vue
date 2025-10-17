<template>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت شرکت‌ها</h2>

            <!-- Companies List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام شرکت</th>
                            <th class="p-2">نام مسئول</th>
                            <th class="p-2">ایمیل</th>
                            <th class="p-2">تاریخ ثبت</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="company in companies" :key="company.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ company.business_name || '---' }}</td>
                            <td class="p-2">{{ company.name }}</td>
                            <td class="p-2">{{ company.email }}</td>
                            <td class="p-2">{{ new Date(company.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2 flex space-x-2">
                                <button @click="viewCompany(company)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button @click="deleteCompany(company.id)" class="text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v0H8V5a2 2 0 012-2z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    companies: Array,
})

function viewCompany(company) {
    // Implement view company details
    alert('جزئیات شرکت: ' + company.name);
}

function deleteCompany(id) {
    if (confirm('آیا از حذف این شرکت مطمئن هستید؟')) {
        router.delete(route('admin.companies.destroy', id))
    }
}

defineOptions({ layout: AdminAppLayout })
</script>
