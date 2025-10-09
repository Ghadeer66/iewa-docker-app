<template>
  <AppLayout>
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-center text-green-600 my-8">منوی غذایی</h1>

    <!-- Meal Cards Grid -->
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <MealCard
          v-for="meal in meals.data"
          :key="meal.id"
          :meal="meal"
          @add-to-cart="addToCart"
        />
      </div>

      <!-- Pagination -->
      <div class="mt-8 flex justify-center">
        <button
          v-if="meals.prev_page_url"
          @click="fetchPage(meals.prev_page_url)"
          class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mx-1"
        >
          قبلی
        </button>
        <button
          v-if="meals.next_page_url"
          @click="fetchPage(meals.next_page_url)"
          class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mx-1"
        >
          بعدی
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import MealCard from '@/components/MealCard.vue';
import { router } from '@inertiajs/vue3';

// Props from Laravel/Inertia
const props = defineProps({
  meals: Object
});

// Access meals from props
const meals = props.meals;

// Add to cart
const addToCart = (meal) => {
  router.post('/cart', { meal_id: meal.id, quantity: 1 });
};

// Pagination
const fetchPage = (url) => {
  router.get(url, {}, { preserveState: true, replace: true });
};
</script>
