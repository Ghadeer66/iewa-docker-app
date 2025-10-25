<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-400">مدیریت تصاویر غذاها</h2>

            <!-- Add New Meal Image Form -->
            <form @submit.prevent="createMealImage" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <select v-model="form.meal_id" class="p-2 bg-gray-700 rounded text-white">
                        <option value="">انتخاب غذا</option>
                        <option v-for="meal in meals" :key="meal.id" :value="meal.id">{{ meal.name }}</option>
                    </select>
                    <input v-model="form.image_path" placeholder="مسیر تصویر"
                        class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <label class="flex items-center text-white mb-4">
                    <input v-model="form.is_primary" type="checkbox" class="ml-2" />
                    تصویر اصلی
                </label>
                <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن تصویر</button>
            </form>

            <!-- Meal Images List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">غذا</th>
                            <th class="p-2">تصویر</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="image in mealImages" :key="image.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ image.meal?.title }}</td>
                            <td class="p-2">
                                <img :src="image.image?.url" class="w-16 h-16 object-cover rounded" />
                            </td>

                            <td class="p-2">
                                <button @click="deleteMealImage(image.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
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

const props = defineProps({
    mealImages: Array,
    meals: Array
})

const form = ref({
    meal_id: '',
    image_path: '',
    is_primary: false
})

function createMealImage() {
    router.post(route('admin.meals-images.store'), form.value)
    form.value = {
        meal_id: '',
        image_path: '',
        is_primary: false
    }
}

function deleteMealImage(id) {
    if (confirm('آیا از حذف این تصویر مطمئن هستید؟')) {
        router.delete(route('admin.meals-images.destroy', id))
    }
}
</script>
