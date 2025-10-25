<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-600">مدیریت انبار مواد اولیه</h2>

            <!-- Add New Ingredient Form -->
            <form @submit.prevent="createIngredient" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-3 gap-4">
                    <input
                        v-model="form.title"
                        placeholder="نام ماده اولیه"
                        class="p-2 bg-gray-700 rounded text-white"
                    />
                    <input
                        v-model.number="form.amount"
                        type="number"
                        placeholder="مقدار"
                        class="p-2 bg-gray-700 rounded text-white"
                    />
                    <input
                        v-model="form.unit"
                        placeholder="واحد (مثلاً کیلوگرم)"
                        class="p-2 bg-gray-700 rounded text-white"
                    />
                </div>
                <button
                    class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold"
                    :disabled="loading"
                >
                    <span v-if="loading">در حال افزودن...</span>
                    <span v-else>افزودن ماده اولیه</span>
                </button>
            </form>

            <!-- Ingredients List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام ماده</th>
                            <th class="p-2">مقدار</th>
                            <th class="p-2">واحد</th>
                            <th class="p-2">تاریخ ایجاد</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="ingredient in ingredients"
                            :key="ingredient.id"
                            class="border-b border-gray-700 text-white"
                        >
                            <td class="p-2">{{ ingredient.title }}</td>
                            <td class="p-2">{{ ingredient.amount }}</td>
                            <td class="p-2">{{ ingredient.unit || '-' }}</td>
                            <td class="p-2">
                                {{ new Date(ingredient.created_at).toLocaleDateString('fa-IR') }}
                            </td>
                            <td class="p-2 flex space-x-2">
                                <!-- Edit Icon -->
                                <button @click="editIngredient(ingredient)" class="text-blue-400 hover:text-blue-600 cursor-pointer">
                                     ✏️
                                </button>

                                <!-- Delete Icon -->
                                <button @click="deleteIngredient(ingredient.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
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
    ingredients: Array,
})

const form = ref({ title: '', amount: '', unit: '' })
const loading = ref(false)

function createIngredient() {
    loading.value = true
    router.post(route('admin.ingredients.store'), form.value, {
        onSuccess: () => {
            form.value = { title: '', amount: '', unit: '' }
        },
        onFinish: () => (loading.value = false),
    })
}

function deleteIngredient(id) {
    if (confirm('آیا از حذف این ماده اولیه مطمئن هستید؟')) {
        router.delete(route('admin.ingredients.destroy', id))
    }
}

function editIngredient(ingredient) {
    // Optional future feature: open modal to edit ingredient
    alert(`ویرایش '${ingredient.title}' هنوز پیاده‌سازی نشده است!`)
}
</script>
