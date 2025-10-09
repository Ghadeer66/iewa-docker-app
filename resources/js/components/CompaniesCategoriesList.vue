<template>
  <section class="container mx-auto px-6 py-6 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200">
    <div class="flex gap-6 flex-nowrap">
      <div
        v-for="cat in items"
        :key="cat.title"
        class="flex-1 min-w-0"
      >
        <div
          class="w-full rounded-xl p-3 flex flex-col items-center text-center transition"
        >
          <div
            class="w-30 h-30 bg-white rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden"
          >
            <img
              :src="cat.image"
              :alt="cat.title"
              class="w-20 h-20 object-contain transform transition-transform duration-300 ease-in-out hover:scale-110"
            />
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
