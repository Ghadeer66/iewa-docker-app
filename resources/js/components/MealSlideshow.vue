<!-- src/components/MealSlideshow.vue -->
<template>
  <div class="relative rounded-xl overflow-hidden bg-gray-100">
    <transition name="fade" mode="out-in">
      <img
        :key="currentIndex"
        :src="currentImage"
        :alt="title"
        class="w-full h-64 object-cover"
      />
    </transition>

    <!-- Navigation Arrows -->
    <button
      v-if="images.length > 1"
      @click="prevImage"
      class="absolute top-1/2 left-3 -translate-y-1/2 bg-white/70 rounded-full px-2 py-1 shadow hover:bg-white transition"
    >
      ‹
    </button>

    <button
      v-if="images.length > 1"
      @click="nextImage"
      class="absolute top-1/2 right-3 -translate-y-1/2 bg-white/70 rounded-full px-2 py-1 shadow hover:bg-white transition"
    >
      ›
    </button>

    <!-- Dots -->
    <div
      v-if="images.length > 1"
      class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2"
    >
      <span
        v-for="(img, i) in images"
        :key="i"
        @click="currentIndex = i"
        :class="[
          'w-2.5 h-2.5 rounded-full cursor-pointer transition',
          currentIndex === i ? 'bg-green-600 scale-125' : 'bg-gray-300 hover:bg-gray-400'
        ]"
      ></span>
    </div>

    <!-- "New" Badge -->
    <span
      v-if="isNew"
      class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow"
    >
      جدید
    </span>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
  title: {
    type: String,
    default: ''
  },
  isNew: {
    type: Boolean,
    default: false
  }
})

const currentIndex = ref(0)

const currentImage = computed(() => props.images[currentIndex.value])

const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % props.images.length
}

const prevImage = () => {
  currentIndex.value =
    (currentIndex.value - 1 + props.images.length) % props.images.length
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.6s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
