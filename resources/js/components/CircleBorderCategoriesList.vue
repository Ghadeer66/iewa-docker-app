<template>
  <section class="container mx-auto px-6 py-6">
    <div class="flex gap-6 flex-nowrap overflow-x-auto pb-2">
      <div
        v-for="cat in items"
        :key="cat.title"
        class="flex-1 min-w-[120px] flex-shrink-0"
      >
        <div
          class="w-full bg-gray-50 rounded-xl p-4 flex flex-col items-center text-center  transition"
        >
          <!-- Circle border around the image -->
          <div
            class="w-24 h-24 border-4 border-blue-300 rounded-full flex items-center justify-center bg-white overflow-hidden"
          >
            <img
              :src="cat.image"
              :alt="cat.title"
              class="w-20 h-20 object-contain"
            />
          </div>

          <div class="text-sm font-semibold text-gray-800 mt-4 leading-tight truncate">
            {{ cat.title }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => []
  }
})
</script>
