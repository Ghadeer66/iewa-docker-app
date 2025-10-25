<template>
  <div
    class="overflow-x-auto py-2 no-scrollbar"
    ref="scrollContainer"
    @mousedown="startDrag"
    @mouseup="stopDrag"
    @mouseleave="stopDrag"
    @mousemove="onDrag"
  >
    <div class="flex gap-3 w-max cursor-grab" :class="{ 'cursor-grabbing': isDragging }">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const isDragging = ref(false)
const startX = ref(0)
const scrollLeft = ref(0)
const scrollContainer = ref(null)

const startDrag = (e) => {
  isDragging.value = true
  startX.value = e.pageX - scrollContainer.value.offsetLeft
  scrollLeft.value = scrollContainer.value.scrollLeft
}

const stopDrag = () => (isDragging.value = false)

const onDrag = (e) => {
  if (!isDragging.value) return
  e.preventDefault()
  const x = e.pageX - scrollContainer.value.offsetLeft
  const walk = x - startX.value
  scrollContainer.value.scrollLeft = scrollLeft.value - walk
}
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
