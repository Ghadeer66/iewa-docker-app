<template>
  <div class="meal-card">
    <img
      :src="meal.image_url ?? (meal.image ? `/storage/${meal.image}` : '/images/placeholder.png')"
      :alt="meal.name || meal.title || 'meal'"
      class="w-full h-48 object-cover rounded"
    />
    <div class="p-4">
      <h3 class="font-bold text-lg mb-1">{{ meal.title }}</h3>
      <p class="text-gray-500 text-sm mb-2 truncate">{{ meal.description }}</p>
      <div class="flex justify-between items-center mt-2">
        <span class="font-semibold text-[#ffa800]">{{ meal.price }} تومان</span>
        <button
          @click="$emit('add-to-cart', meal)"
          class="bg-[#ffa800] text-white px-3 py-1 rounded-lg hover:bg-[#e08f00] text-sm"
        >
          افزودن
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ meal: Object });
</script>
