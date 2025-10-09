<template>
  <AppLayout>
    <!-- Title -->
    <h1 class="text-3xl font-bold text-center text-gray-800 my-10">محصولات ایوا</h1>

    <!-- Filter Bar (optional placeholder) -->
    <div class="container mx-auto px-6 mb-8">
      <div class="flex flex-wrap justify-center gap-3">
        <button
          v-for="filter in filters"
          :key="filter"
          class="px-4 py-2 rounded-full border border-gray-300 bg-white hover:bg-gray-100 text-sm text-gray-700 transition"
        >
          {{ filter }}
        </button>
      </div>
    </div>

    <!-- Meal Cards -->
    <div class="container mx-auto px-6">
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8"
      >
        <MealCard
          v-for="meal in meals.data"
          :key="meal.id"
          :meal="meal"
          @add-to-cart="addToCart"
          @view-details="viewDetails"
        />
      </div>

      <!-- Pagination -->
      <div class="mt-10 flex justify-center gap-3">
        <button
          v-if="meals.prev_page_url"
          @click="fetchPage(meals.prev_page_url)"
          class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition"
        >
          قبلی
        </button>
        <button
          v-if="meals.next_page_url"
          @click="fetchPage(meals.next_page_url)"
          class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition"
        >
          بعدی
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import MealCard from '@/components/MealCard.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({ meals: Object })
const meals = props.meals

const filters = [
  'غذای گیاهی',
  'پک میان‌وعده',
  'نوشیدنی',
  'سالاد',
  'غذای سالم ایوا',
  'بسته سم‌زدایی'
]

const addToCart = (meal) => {
  router.post('/cart', { meal_id: meal.id, quantity: 1 })
}

const viewDetails = (meal) => {
  router.get(`/meals/${meal.id}`)
}

const fetchPage = (url) => {
  router.get(url, {}, { preserveState: true, replace: true })
}
</script>
