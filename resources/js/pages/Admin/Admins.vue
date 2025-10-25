<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت ادمین‌ها</h2>

            <!-- 🔍 Search Section -->
            <div class="bg-gray-800 p-4 rounded mb-6 flex items-center space-x-2">
                <input
                    v-model="filters.search"
                    type="text"
                    placeholder="جستجو بر اساس نام، ایمیل یا تلفن..."
                    class="flex-1 p-2 bg-gray-700 rounded text-white"
                />
                <button
                    @click="searchAdmins"
                    class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold cursor-pointer"
                >
                    جستجو
                </button>
                <button
                    v-if="filters.search"
                    @click="clearSearch"
                    class="bg-gray-600 text-white px-4 py-2 rounded font-bold cursor-pointer"
                >
                    پاک کردن
                </button>
            </div>

            <!-- Add New Admin Form -->
            <form @submit.prevent="createAdmin" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <input v-model="form.name" placeholder="نام" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.email" placeholder="ایمیل" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.password" type="password" placeholder="رمز عبور" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.phone" type="number" placeholder="شماره تلفن" class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <button class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold cursor-pointer">افزودن ادمین</button>
            </form>

            <!-- Admins List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام</th>
                            <th class="p-2">ایمیل</th>
                            <th class="p-2">تلفن</th>
                            <th class="p-2">تاریخ ایجاد</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="admin in adminsArray" :key="admin.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ admin.name }}</td>
                            <td class="p-2">{{ admin.email }}</td>
                            <td class="p-2">{{ admin.phone ?? '---' }}</td>
                            <td class="p-2">{{ new Date(admin.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2 flex space-x-2">
                                <button @click="editAdmin(admin)" class="text-blue-400 hover:text-blue-600 cursor-pointer">
                                    ✏️
                                </button>
                                <button @click="deleteAdmin(admin.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
                                    🗑️
                                </button>
                            </td>
                        </tr>
                        <tr v-if="admins.length === 0">
                            <td colspan="5" class="text-center text-gray-400 p-4">ادمینی یافت نشد</td>
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
import { ref, computed } from 'vue'

const props = defineProps({
    admins: Object,   // <-- use Object, not Array
    filters: Object,
})

// form for adding new admin
const form = ref({ name: '', email: '', password: '', phone: '' })
const filters = ref({ search: props.filters?.search ?? '' })

function createAdmin() {
    router.post('/admin/users/admins', form.value)
    form.value = { name: '', email: '', password: '', phone: '' }
}

// Use computed to get the actual array of admins for v-for
const adminsArray = computed(() => props.admins.data ?? [])

// Search function using filters.search
function searchAdmins() {
    router.get('/admin/users/admins', { search: filters.value.search }, {
        preserveState: true,
        replace: true,
    })
}

function clearSearch() {
    filters.value.search = ''
    searchAdmins()
}

function deleteAdmin(id) {
    if (confirm('آیا از حذف این ادمین مطمئن هستید؟')) {
        router.delete(`/admin/users/admins/${id}`)
    }
}

function editAdmin(admin) {
    alert('ویرایش هنوز پیاده‌سازی نشده!')
}
</script>

