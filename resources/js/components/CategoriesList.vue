<template>
    <section class="container mx-auto px-6 py-6">
        <!-- horizontally centered, scrollbar hidden -->
        <div
            ref="scrollContainer"
            class="flex items-center justify-start gap-4 overflow-x-auto no-scrollbar py-2"
        >
            <div
                v-for="cat in items"
                :key="cat.title"
                class="flex-shrink-0 w-40 rounded-lg flex flex-col items-center justify-center text-center shadow-sm"
            >
                <div
                    class="w-full bg-gray-100 rounded-xl p-3 flex flex-col items-center text-center shadow-sm hover:shadow-md transition cursor-pointer"
                    @click="handleCategoryClick(cat.title)"
                >
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
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    items: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['category-click'])

const scrollContainer = ref(null)
const isDragging = ref(false)
const shouldPreventClick = ref(false)
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

const handleMouseUp = (e) => {
    if (isDragging.value) {
        const endX = e.pageX - scrollContainer.value.offsetLeft
        const distance = Math.abs(endX - startX.value)
        shouldPreventClick.value = distance > 5
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

const handleCategoryClick = (categoryTitle) => {
    if (shouldPreventClick.value) {
        shouldPreventClick.value = false
        return
    }
    // Emit event to parent component
    emit('category-click', categoryTitle)

    // Also navigate directly to menu with filter
    router.get('/menu', { category: categoryTitle })
}

onMounted(() => {
    const container = scrollContainer.value
    if (container) {
        container.addEventListener('mousedown', handleMouseDown)
        container.addEventListener('mouseleave', handleMouseLeave)
        container.style.cursor = 'grab'
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

.no-scrollbar {
    cursor: grab;
}
</style>
