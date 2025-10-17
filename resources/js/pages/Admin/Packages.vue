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
