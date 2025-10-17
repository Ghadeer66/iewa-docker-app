<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-400">مدیریت غذاها</h2>

            <!-- Add New Meal Form -->
            <form @submit.prevent="createMeal" class="bg-gray-800 p-4 rounded mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <input v-model="form.title" placeholder="نام غذا" class="p-2 bg-gray-700 rounded text-white" />
                    <input v-model="form.price" type="number" placeholder="قیمت" class="p-2 bg-gray-700 rounded text-white" />
                </div>
                <textarea v-model="form.description" placeholder="توضیحات" class="w-full p-2 bg-gray-700 rounded text-white mb-4"></textarea>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <select v-model="form.type_id" class="p-2 bg-gray-700 rounded text-white">
                        <option value="">انتخاب نوع</option>
                        <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
                    </select>
                </div>
                <button class="bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold">افزودن غذا</button>
            </form>

            <!-- Meals List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">نام</th>
                            <th class="p-2">قیمت</th>
                            <!-- <th class="p-2">نوع</th> -->
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="meal in meals" :key="meal.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ meal.title }}</td>
                            <td class="p-2">{{ meal.price.toLocaleString() }} تومان</td>
                            <!-- <td class="p-2">{{ meal.type?.title }}</td> -->

                            <td class="p-2 flex space-x-2">
                                <button @click="editMeal(meal)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6H6v-6l3-3z" />
                                    </svg>
                                </button>
                                <button @click="deleteMeal(meal.id)" class="text-red-400 hover:text-red-600">
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
    meals: Array,
    types: Array,
    packages: Array
})

const form = ref({
    name: '',
    description: '',
    price: '',
    type_id: '',
    package_id: '',
    is_active: true
})

function createMeal() {
    router.post(route('admin.meals.store'), form.value)
    form.value = {
        name: '',
        description: '',
        price: '',
        type_id: '',
        package_id: '',
        is_active: true
    }
}

function editMeal(meal) {
    // Implement edit functionality
    alert('ویرایش غذا: ' + meal.name)
}

function deleteMeal(id) {
    if (confirm('آیا از حذف این غذا مطمئن هستید؟')) {
        router.delete(route('admin.meals.destroy', id))
    }
}
</script>
