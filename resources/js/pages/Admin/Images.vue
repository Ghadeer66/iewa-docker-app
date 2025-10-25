<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-400">مدیریت تصاویر</h2>

            <!-- Add New Image Form -->
            <form @submit.prevent="createImage" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <input v-model="form.title" placeholder="عنوان تصویر" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.path" placeholder="مسیر تصویر" class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <textarea v-model="form.description" placeholder="توضیحات" class="w-full p-2 bg-gray-700 rounded text-white mb-4"></textarea>
                <label class="flex items-center text-white mb-4">
                    <input v-model="form.is_active" type="checkbox" class="ml-2" />
                    فعال
                </label>
                <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن تصویر</button>
            </form>

            <!-- Images List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">عنوان</th>
                            <th class="p-2">تصویر</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="image in images"
                            :key="image.id"
                            class="border-b border-gray-700 text-white"
                        >
                            <td class="p-2">{{ image.title }}</td>
                            <td class="p-2">
                                <img :src="image.url" class="w-16 h-16 object-cover rounded" />

                            </td>
                            <td class="p-2 flex space-x-2">
                                <button
                                    @click="editImage(image)"
                                    class="text-blue-400 hover:text-blue-600 "
                                >
                                    ✏️
                                </button>
                                <button
                                    @click="deleteImage(image.id)"
                                    class="text-red-400 hover:text-red-600 cursor-pointer"
                                >
                                    🗑️
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

// ✅ Safely define base URL
const baseUrl = window.location.origin

const props = defineProps({
    images: Array,
})

const form = ref({
    title: '',
    path: '',
    description: '',
    is_active: true,
})

// ✅ Utility function to clean and format image URLs
function getImageUrl(url) {
    if (!url) return ''
    return `${baseUrl}${url.replace(/^\/admin/, '')}`
}

function createImage() {
    router.post(route('admin.images.store'), form.value, {
        onSuccess: () => {
            form.value = { title: '', path: '', description: '', is_active: true }
        },
    })
}

function editImage(image) {
    alert('ویرایش تصویر: ' + image.title)
}

function deleteImage(id) {
    if (confirm('آیا از حذف این تصویر مطمئن هستید؟')) {
        router.delete(route('admin.images.destroy', id))
    }
}
</script>
