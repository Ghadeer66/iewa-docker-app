<template>
  <section class="container mx-auto px-6 py-6">
    <div
      class="rounded-xl p-4"
      :style="{ background: gradient }"
      dir="rtl"
    >
      <div class="flex items-center gap-4 overflow-x-auto no-scrollbar py-2">
        <div v-if="cta" class="flex-shrink-0 rounded-lg p-4 w-44 h-36 flex flex-col items-center justify-center text-center ">
          <div class="text-3xl mb-1">🤔</div>
          <div class="text-sm font-medium text-gray-800">
            {{ cta }}
          </div>
        </div>
        <div
          v-for="(item, i) in items"
          :key="i"
          class="flex-shrink-0 bg-white rounded-lg p-4 w-58 h-36 flex flex-col items-center justify-center text-center shadow-sm"
        >
          <div class="w-12 h-12 mb-2">
            <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-contain" />
            <div v-else class="text-2xl">❓</div>
          </div>
          <div class="text-sm font-medium text-gray-800 leading-tight">
            {{ item.title }}
          </div>
        </div>

        <!-- optional CTA / last card style -->

      </div>
    </div>
  </section>
</template>

<script setup>
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
</script>

<style scoped>
.no-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }
.no-scrollbar::-webkit-scrollbar { display: none; }
</style>
