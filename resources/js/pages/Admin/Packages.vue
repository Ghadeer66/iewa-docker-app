<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-400">مدیریت بسته‌ها</h2>

            <!-- Add New Package Form -->
            <form @submit.prevent="createPackage" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <input v-model="form.name" placeholder="نام بسته" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.price" type="number" placeholder="قیمت" class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <input v-model="form.duration_days" type="number" placeholder="مدت (روز)" class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <textarea v-model="form.description" placeholder="توضیحات" class="w-full p-2 bg-gray-700 rounded text-white mb-4"></textarea>
                <label class="flex items-center text-white mb-4">
                    <input v-model="form.is_active" type="checkbox" class="ml-2" />
                    فعال
                </label>
                <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن بسته</button>
            </form>

            <!-- Packages List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام</th>
                            <th class="p-2">قیمت</th>
                            <th class="p-2">مدت</th>
                            <th class="p-2">وضعیت</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="package in packages" :key="package.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ package.name }}</td>
                            <td class="p-2">{{ package.price.toLocaleString() }} تومان</td>
                            <td class="p-2">{{ package.duration_days }} روز</td>
                            <td class="p-2">
                                <span :class="package.is_active ? 'text-green-400' : 'text-red-400'">
                                    {{ package.is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td class="p-2 flex space-x-2">
                                <button @click="editPackage(package)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6H6v-6l3-3z" />
                                    </svg>
                                </button>
                                <button @click="deletePackage(package.id)" class="text-red-400 hover:text-red-600">
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
    </AdminAppLayout>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    packages: Array
})

const form = ref({
    name: '',
    description: '',
    price: '',
    duration_days: '',
    is_active: true
})

function createPackage() {
    router.post(route('admin.packages.store'), form.value)
    form.value = {
        name: '',
        description: '',
        price: '',
        duration_days: '',
        is_active: true
    }
}

function editPackage(pkg) {
    // Implement edit functionality
    alert('ویرایش بسته: ' + pkg.name)
}

function deletePackage(id) {
    if (confirm('آیا از حذف این بسته مطمئن هستید؟')) {
        router.delete(route('admin.packages.destroy', id))
    }
}
</script>
