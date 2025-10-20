<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت ادمین‌ها</h2>

            <!-- Add New Admin Form -->
            <form @submit.prevent="createAdmin" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-3 gap-4">
                    <input v-model="form.name" placeholder="نام" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.email" placeholder="ایمیل" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.password" type="password" placeholder="رمز عبور"
                        class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.phone" type="number" placeholder="شماره تلفن"  class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <button class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن ادمین</button>
            </form>

            <!-- Admins List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام</th>
                            <th class="p-2">ایمیل</th>
                            <th class="p-2">تاریخ ایجاد</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="admin in admins" :key="admin.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ admin.name }}</td>
                            <td class="p-2">{{ admin.email }}</td>
                            <td class="p-2">{{ new Date(admin.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2 flex space-x-2">
                                <!-- Edit (Pencil) Icon -->
                                <button @click="editAdmin(admin)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536M9 11l6 6H6v-6l3-3z" />
                                    </svg>
                                </button>

                                <!-- Delete (Trash) Icon -->
                                <button @click="deleteAdmin(admin.id)" class="text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
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
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    admins: Array,
})

const form = ref({ name: '', email: '', password: '', phone: '' })

function createAdmin() {
    router.post('/admin/users/admins', form.value)
    form.value = { name: '', email: '', password: '', phone: '' }
}

function deleteAdmin(id) {
    if (confirm('آیا از حذف این ادمین مطمئن هستید؟')) {
        router.delete(route('admin.admins.destroy', id))
    }
}

function editAdmin(admin) {
    // Optional: show modal to edit and then send PUT request
    alert('ویرایش هنوز پیاده‌سازی نشده!')
}
</script>
