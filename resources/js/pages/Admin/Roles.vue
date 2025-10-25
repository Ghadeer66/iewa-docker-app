<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت نقش‌ها</h2>

            <!-- Add New Role -->
            <form @submit.prevent="createRole" class="bg-gray-800 p-4 rounded mb-6">
                <div class="flex gap-4">
                    <input v-model="form.name" placeholder="نام نقش (مثال: editor)" class="flex-1 p-2 bg-gray-700 rounded text-white" />
                    <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن نقش</button>
                </div>
            </form>

            <div class="grid grid-cols-2 gap-6">
                <!-- Roles List -->
                <div class="bg-gray-800 p-4 rounded">
                    <h3 class="text-lg font-bold mb-4 text-white">نقش‌ها</h3>
                    <div class="space-y-2">
                        <div v-for="role in roles" :key="role.id"
                            class="flex items-center justify-between p-2 bg-gray-700 rounded text-white">
                            <span>{{ role.translated_name }}</span>
                            <button @click="deleteRole(role.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Admins List -->
                <div class="bg-gray-800 p-4 rounded">
                    <h3 class="text-lg font-bold mb-4 text-white">ادمین‌ها</h3>
                    <div class="space-y-3">
                        <div v-for="admin in admins" :key="admin.id" class="p-3 bg-gray-700 rounded">
                            <h4 class="font-bold text-white mb-2">{{ admin.name }}</h4>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="role in admin.roles" :key="role.id"
                                    class="flex items-center gap-1 px-2 py-1 bg-blue-600 text-white text-xs rounded">
                                    {{ role.translated_name }}
                                    <button @click="revokeRoleFromAdmin(admin.id, role.id, role.translated_name)"
                                        class="hover:text-red-300 transition-colors" title="حذف نقش">
                                        ✕
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Role to Admin -->
            <div class="mt-6 bg-gray-800 p-4 rounded">
                <h3 class="text-lg font-bold mb-4 text-white">اختصاص نقش به ادمین</h3>
                <form @submit.prevent="assignRoleToAdmin" class="flex gap-4">
                    <select v-model="assignForm.role_id" class="flex-1 p-2 bg-gray-700 rounded text-white">
                        <option value="" disabled>انتخاب نقش</option>
                        <option v-for="role in roles" :key="role.id" :value="role.id">
                            {{ role.translated_name }}
                        </option>
                    </select>
                    <select v-model="assignForm.user_id" class="flex-1 p-2 bg-gray-700 rounded text-white">
                        <option value="" disabled>انتخاب ادمین</option>
                        <option v-for="admin in admins" :key="admin.id" :value="admin.id">
                            {{ admin.name }}
                        </option>
                    </select>
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded font-bold">اختصاص</button>
                </form>
            </div>
        </div>
    </AdminAppLayout>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    roles: Array,
    admins: Array,
})

const form = ref({ name: '' })
const assignForm = ref({ role_id: '', user_id: '' })

function createRole() {
    router.post('/admin/users/roles', form.value, {
        onSuccess: () => form.value = { name: '' }
    })
}

function assignRoleToAdmin() {
    router.post('/admin/users/roles/assign-to-admin', assignForm.value, {
        onSuccess: () => assignForm.value = { role_id: '', user_id: '' }
    })
}

function revokeRoleFromAdmin(adminId, roleId, roleName) {
    if (confirm(`آیا می‌خواهید نقش "${roleName}" را از این ادمین حذف کنید؟`)) {
        router.post('/admin/users/roles/revoke-from-admin', {
            user_id: adminId,
            role_id: roleId
        })
    }
}

function deleteRole(id) {
    if (confirm('آیا از حذف این نقش مطمئن هستید؟')) {
        router.delete(`/admin/users/roles/${id}`)
    }
}
</script>
