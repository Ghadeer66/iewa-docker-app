<template>
  <section class="container mx-auto px-6 py-4">
    <div class="relative">
      <!-- scroll row (RTL) -->
      <div
        ref="row"
        dir="rtl"
        class="flex gap-4 overflow-x-auto no-scrollbar py-2"
        style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;"
      >
        <div
          v-for="cat in items"
          :key="cat.title"
          class="flex-shrink-0 bg-gray-100 rounded-xl p-3 flex flex-col items-center text-center shadow-sm transition"
          style="width: 170px; scroll-snap-align: center;"
        >
          <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-2">
            <img :src="cat.image" :alt="cat.title" class="w-10 h-10 object-contain" />
          </div>
          <div class="text-sm font-medium text-gray-800 leading-tight truncate">
            {{ cat.title }}
          </div>
        </div>
      </div>

      <!-- simple nav arrows -->
      <button
        type="button"
        @click="scroll('prev')"
        class="absolute left-1 top-1/2 -translate-y-1/2 bg-white/90 text-black rounded-full p-1 shadow hidden md:inline-flex"
        aria-label="prev"
      >‹</button>

      <button
        type="button"
        @click="scroll('next')"
        class="absolute right-1 top-1/2 -translate-y-1/2 bg-white/90 text-black rounded-full p-1 shadow hidden md:inline-flex"
        aria-label="next"
      >›</button>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  }
})

const row = ref(null)

const scroll = (dir) => {
  if (!row.value) return
  const el = row.value
  const step = el.clientWidth * 0.6 // scroll ~60% of visible width
  el.scrollBy({ left: dir === 'next' ? -step : step, behavior: 'smooth' }) // RTL: left negative moves right
}
</script>

<style scoped>
.no-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }
.no-scrollbar::-webkit-scrollbar { display: none; }
</style>
