<template>
    <section class="container mx-auto px-6 py-6">
        <!-- horizontally centered, scrollbar hidden -->
        <div class="flex items-center justify-start gap-4 overflow-x-auto no-scrollbar py-2">
  <div
    v-for="cat in items"
    :key="cat.title"
    class="flex-shrink-0 w-40 rounded-lg flex flex-col items-center justify-center text-center shadow-sm"
  >
    <div class="w-full bg-gray-100 rounded-xl p-3 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
      <div class="w-20 h-20 mt-4 flex items-center justify-center">
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
const props = defineProps({
    items: {
        type: Array,
        default: () => []
    }
})
</script>

<style scoped>
/* hide scrollbar for all browsers */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}
</style>
