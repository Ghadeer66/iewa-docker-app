<template>
  <section class="container mx-auto px-6 py-6">
    <div
      class="rounded-xl p-4"
      :style="{ background: gradient }"
      dir="rtl"
    >
      <div
        ref="scrollContainer"
        class="flex items-center gap-4 overflow-x-auto no-scrollbar py-2"
      >
        <div v-if="cta" class="flex-shrink-0 rounded-lg p-4 w-44 h-36 flex flex-col items-center justify-center text-center ">
          <div class="text-l font-large text-gray-800">
            {{ cta }}
          </div>
        </div>
        <div
          v-for="(item, i) in items"
          :key="i"
          class="flex-shrink-0 bg-white rounded-lg p-4 w-58 h-36 flex flex-col items-center justify-center text-center shadow-sm"
        >
          <!-- <div class="w-12 h-12 mb-2">
            <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-contain" />
            <div v-else class="text-2xl">❓</div>
          </div> -->
          <div class="text-xl font-medium text-gray-800 leading-tight">
            {{ item.title }}
          </div>
        </div>

        <!-- optional CTA / last card style -->

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    default: () => [
      { title: 'بهبود متابولیسم', image: '/storage/images/cat-1.png' },
      { title: 'بهبود گوارش', image: '/storage/images/cat-2.png' },
      { title: 'رژیم افزایش وزن', image: '/storage/images/cat-3.png' },
      { title: 'رژیم کاهش وزن', image: '/storage/images/cat-4.png' },
      { title: 'غذاهای سالم', image: '/storage/images/cat-5.png' },
    ]
  },
  cta: { type: String, default: ' چی مشکل داری؟ ' },
  gradientFrom: { type: String, default: '#e9f1ff' },
  gradientTo: { type: String, default: '#f6f8e9' },
})

const gradient = `linear-gradient(90deg, ${props.gradientFrom} 0%, ${props.gradientTo} 100%)`

const scrollContainer = ref(null)
const isDragging = ref(false)
const startX = ref(0)
const scrollLeft = ref(0)

const handleMouseDown = (e) => {
  isDragging.value = true
  startX.value = e.pageX - scrollContainer.value.offsetLeft
  scrollLeft.value = scrollContainer.value.scrollLeft
  scrollContainer.value.style.cursor = 'grabbing'
  document.body.style.userSelect = 'none'
}

const handleMouseLeave = () => {
  if (isDragging.value) {
    isDragging.value = false
    scrollContainer.value.style.cursor = 'grab'
    document.body.style.userSelect = ''
  }
}

const handleMouseUp = () => {
  if (isDragging.value) {
    isDragging.value = false
    scrollContainer.value.style.cursor = 'grab'
    document.body.style.userSelect = ''
  }
}

const handleMouseMove = (e) => {
  if (!isDragging.value) return
  e.preventDefault()
  const x = e.pageX - scrollContainer.value.offsetLeft
  const walk = (x - startX.value) * 2 // Adjust multiplier for scroll speed
  scrollContainer.value.scrollLeft = scrollLeft.value - walk
}

onMounted(() => {
  const container = scrollContainer.value
  if (container) {
    container.addEventListener('mousedown', handleMouseDown)
    container.addEventListener('mouseleave', handleMouseLeave)
  }
  document.addEventListener('mouseup', handleMouseUp)
  document.addEventListener('mousemove', handleMouseMove)
})

onUnmounted(() => {
  const container = scrollContainer.value
  if (container) {
    container.removeEventListener('mousedown', handleMouseDown)
    container.removeEventListener('mouseleave', handleMouseLeave)
  }
  document.removeEventListener('mouseup', handleMouseUp)
  document.removeEventListener('mousemove', handleMouseMove)
})
</script>

<style scoped>
.no-scrollbar {
  scrollbar-width: none;
  -ms-overflow-style: none;
  cursor: grab;
}
.no-scrollbar::-webkit-scrollbar { display: none; }
</style>
