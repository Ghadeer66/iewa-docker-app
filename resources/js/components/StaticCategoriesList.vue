<template>
  <section class="container mx-auto px-6 py-6">
    <!-- single-line responsive row: items share available width and keep one row -->
    <div class="flex gap-6 flex-nowrap">
      <div
        v-for="cat in items"
        :key="cat.title"
        class="flex-1 min-w-0"
      >
        <!-- make the card keep an aspect ratio; width is controlled by flex -->
        <div
          class="w-full bg-gray-100 rounded-xl p-3 flex flex-col items-center text-center shadow-sm hover:shadow-md transition cursor-pointer"
          @click="handleCategoryClick(cat.title)"
        >
          <div class="w-15 h-15 mt-4 bg-white rounded-full flex items-center justify-center flex-shrink-0">
            <img :src="cat.image" :alt="cat.title" class="w-20 h-20 object-contain" />
          </div>
          <div class="text-sm font-medium text-gray-800 leading-tight truncate m-6">
            {{ cat.title }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['category-click'])

const handleCategoryClick = (categoryTitle) => {
  // Emit event to parent component
  emit('category-click', categoryTitle)

  // Also navigate directly to menu with filter
  router.get('/menu', { category: categoryTitle })
}
</script>

<style scoped>
/* subtle card hover lift */
div[role="presentation"] { /* noop to satisfy tooling if needed */ }
</style>
