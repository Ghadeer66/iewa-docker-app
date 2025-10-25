<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت مجوزها</h2>

            <!-- Add New Permission -->
            <form @submit.prevent="createPermission" class="bg-gray-800 p-4 rounded mb-6">
                <div class="flex gap-4">
                    <input v-model="form.name" placeholder="نام مجوز (مثال: view-posts)" class="flex-1 p-2 bg-gray-700 rounded text-white" />
                    <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن مجوز</button>
                </div>
            </form>

            <div class="grid grid-cols-2 gap-6">
                <!-- Permissions List -->
                <div class="bg-gray-800 p-4 rounded">
                    <h3 class="text-lg font-bold mb-4 text-white">مجوزها</h3>
                    <div class="space-y-2">
                        <div v-for="permission in permissions" :key="permission.id"
                            class="flex items-center justify-between p-2 bg-gray-700 rounded text-white">
                            <span>{{ permission.name }}</span>
                            <button @click="deletePermission(permission.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Roles List -->
                <div class="bg-gray-800 p-4 rounded">
                    <h3 class="text-lg font-bold mb-4 text-white">نقش‌ها</h3>
                    <div class="space-y-4">
                        <div v-for="role in roles" :key="role.id" class="p-3 bg-gray-700 rounded">
                            <h4 class="font-bold text-white mb-2">{{ role.name }}</h4>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="perm in role.permissions" :key="perm.id"
                                    class="flex items-center gap-1 px-2 py-1 bg-green-600 text-white text-xs rounded">
                                    {{ perm.name }}
                                    <button @click="revokePermissionFromRole(role.id, perm.id, perm.name)"
                                        class="hover:text-red-300 transition-colors" title="حذف مجوز">
                                        ✕
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Permission to Role -->
            <div class="mt-6 bg-gray-800 p-4 rounded">
                <h3 class="text-lg font-bold mb-4 text-white">اختصاص مجوز به نقش</h3>
                <form @submit.prevent="assignPermissionToRole" class="flex gap-4">
                    <select v-model="assignForm.permission_id" class="flex-1 p-2 bg-gray-700 rounded text-white">
                        <option value="" disabled>انتخاب مجوز</option>
                        <option v-for="perm in permissions" :key="perm.id" :value="perm.id">
                            {{ perm.name }}
                        </option>
                    </select>
                    <select v-model="assignForm.role_id" class="flex-1 p-2 bg-gray-700 rounded text-white">
                        <option value="" disabled>انتخاب نقش</option>
                        <option v-for="role in roles" :key="role.id" :value="role.id">
                            {{ role.name }}
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
    permissions: Array,
    roles: Array,
})

const form = ref({ name: '' })
const assignForm = ref({ permission_id: '', role_id: '' })

function createPermission() {
    router.post('/admin/users/permissions', form.value, {
        onSuccess: () => form.value = { name: '' }
    })
}

function assignPermissionToRole() {
    router.post('/admin/users/permissions/assign-to-role', assignForm.value, {
        onSuccess: () => assignForm.value = { permission_id: '', role_id: '' }
    })
}

function revokePermissionFromRole(roleId, permissionId, permissionName) {
    if (confirm(`آیا می‌خواهید مجوز "${permissionName}" را از این نقش حذف کنید؟`)) {
        router.post('/admin/users/permissions/revoke-from-role', {
            role_id: roleId,
            permission_id: permissionId
        })
    }
}

function deletePermission(id) {
    if (confirm('آیا از حذف این مجوز مطمئن هستید؟')) {
        router.delete(`/admin/users/permissions/${id}`)
    }
}
</script>
