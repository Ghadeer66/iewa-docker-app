<template>
  <div class="relative w-full overflow-hidden rounded-lg">
    <div class="w-full h-64 md:h-96 bg-gray-100 flex items-center justify-center">
      <img
        v-if="currentItem"
        :src="resolveImage(currentItem)"
        :alt="currentItem[titleKey] ?? 'slide'"
        class="w-full h-full object-cover"
        loading="lazy"
      />
      <div v-else class="text-gray-500">No slides</div>
    </div>

    <!-- Prev / Next -->
    <button
      @click="prev"
      class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white px-3 py-2 rounded-full shadow"
      aria-label="Previous"
    >‹</button>

    <button
      @click="next"
      class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white px-3 py-2 rounded-full shadow"
      aria-label="Next"
    >›</button>

    <!-- Dots -->
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
      <button
        v-for="(item, i) in items"
        :key="i"
        @click="goTo(i)"
        :class="['w-2 h-2 rounded-full', i === index ? 'bg-white' : 'bg-white/50']"
        aria-label="'Go to slide '+(i+1)"
      />
    </div>

    <!-- Optional caption -->
    <div v-if="currentItem && showCaption" class="absolute bottom-12 left-4 bg-black/50 text-white px-3 py-1 rounded">
      {{ currentItem[titleKey] }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
  imageKey: {
    type: String,
    default: 'image'
  },
  titleKey: {
    type: String,
    default: 'title'
  },
  interval: {
    type: Number,
    default: 4000
  },
  showCaption: {
    type: Boolean,
    default: true
  },
  storagePrefix: {
    type: String,
    default: '/storage/'
  }
});

const index = ref(0);
let timer = null;

const items = props.items;
const imageKey = props.imageKey;
const titleKey = props.titleKey;

const currentItem = computed(() => items?.[index.value] ?? null);

const next = () => {
  if (!items || items.length === 0) return;
  index.value = (index.value + 1) % items.length;
};

const prev = () => {
  if (!items || items.length === 0) return;
  index.value = (index.value - 1 + items.length) % items.length;
};

const goTo = (i) => {
  index.value = i;
};

const resolveImage = (item) => {
  const val = item?.[imageKey];
  if (!val) return '/images/placeholder.png';
  // if already absolute url
  if (/^(https?:)?\/\//.test(val)) return val;
  // otherwise assume stored in storage
  return props.storagePrefix + val;
};

onMounted(() => {
  if (props.interval > 0 && items && items.length > 1) {
    timer = setInterval(next, props.interval);
  }
});

onUnmounted(() => {
  if (timer) clearInterval(timer);
});

// restart timer when items change
watch(() => props.items, (n) => {
  index.value = 0;
  if (timer) {
    clearInterval(timer);
    timer = null;
  }
  if (props.interval > 0 && n && n.length > 1) {
    timer = setInterval(next, props.interval);
  }
});
</script>

<style scoped>
/* small visual tweak for dot buttons */
button[aria-label^="Go to slide"] { border: none; }
</style>
