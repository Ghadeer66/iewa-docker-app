<template>
  <div
    class="meal-card bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col"
  >
    <!-- Image -->
    <div class="relative w-full bg-gray-100">
      <img
        :src="meal.image_url ?? (meal.image ? `/storage/${meal.image}` : '/images/placeholder.png')"
        :alt="meal.name || meal.title || 'meal'"
        class="w-full h-52 object-cover rounded-t-2xl"
      />
      <span
        v-if="meal.is_new"
        class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow"
      >
        جدید
      </span>
    </div>

    <!-- Content -->
    <div class="p-4 flex flex-col flex-grow">
      <h3 class="font-bold text-gray-800 text-lg mb-1 text-center">{{ meal.title }}</h3>
      <p class="text-gray-500 text-sm text-center mb-3 truncate">{{ meal.description }}</p>

      <div class="mt-auto">
        <!-- Price -->
        <div class="flex justify-center items-center gap-2 mb-3">
          <span class="text-sm text-gray-400">قیمت:</span>
          <span class="font-semibold text-green-600 text-base">{{ meal.price.toLocaleString() }} تومان</span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center gap-3">
          <button
            @click="$emit('view-details', meal)"
            class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-1 rounded-md text-sm hover:bg-yellow-200 transition"
          >
            جزئیات بیشتر
          </button>

          <button
            @click="$emit('add-to-cart', meal)"
            class="bg-green-500 text-white px-4 py-1 rounded-md text-sm hover:bg-green-600 transition"
          >
            سفارش
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ meal: Object });
</script>
