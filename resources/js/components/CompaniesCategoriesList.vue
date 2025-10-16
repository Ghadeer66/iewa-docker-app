<template>
  <section class="w-full overflow-hidden">
    <div
      class="flex justify-center"
    >
      <div
        class="flex gap-0 overflow-x-auto scrollbar-hide px-10 py-10 max-w-full"
      >
        <div
          v-for="cat in items"
          :key="cat.title"
          class="flex-shrink-0 flex flex-col items-center text-center transition"
        >
          <div class="w-30 h-30 flex items-center justify-center overflow-hidden">
            <img
              :src="cat.image"
              :alt="cat.title"
              class="w-20 h-20 object-contain transform transition-transform duration-300 ease-in-out hover:scale-110"
            />
          </div>
          <p class="mt-2 text-sm font-medium">{{ cat.title }}</p>
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

<style>
/* Hide scrollbar but keep scrolling functionality */
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;  /* for Internet Explorer, Edge */
  scrollbar-width: none;     /* for Firefox */
}
</style>
