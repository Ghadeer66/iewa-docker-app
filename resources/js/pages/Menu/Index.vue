<template>
  <AppLayout>
    <!-- Title -->
    <h1 class="text-3xl font-bold text-center text-gray-800 my-10">محصولات ایوا</h1>

    <!-- Filter Bar -->
    <div class="container mx-auto px-6 mb-8">
      <div
        class="overflow-x-auto py-2 no-scrollbar"
        ref="scrollContainer"
        @mousedown="startDrag"
        @mouseup="stopDrag"
        @mouseleave="stopDrag"
        @mousemove="onDrag"
      >
        <div
          class="flex gap-3 w-max cursor-grab"
          :class="{ 'cursor-grabbing': isDragging }"
        >
          <button
            v-for="filter in filters"
            :key="filter.title"
            @click="applyFilter(filter)"
            :class="[
              'flex items-center gap-2 flex-shrink-0 px-4 py-2 rounded-full border text-sm transition',
              activeFilter === filter.title
                ? 'bg-blue-500 text-white border-blue-500'
                : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-100'
            ]"
          >
            <img
              v-if="filter.image"
              class="w-5 h-5 object-contain"
              :src="filter.image"
              :alt="filter.title"
            />
            <span>{{ filter.title }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-8">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
      <p class="mt-2 text-gray-600">در حال بارگذاری...</p>
    </div>

    <!-- Meal Cards -->
    <div v-else class="container mx-auto px-6">
      <!-- No Results -->
      <div v-if="meals.data.length === 0" class="text-center py-12">
        <p class="text-gray-500 text-lg">محصولی با فیلتر انتخاب شده یافت نشد.</p>
        <button
          @click="clearFilters"
          class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition cursor-pointer"
        >
          حذف فیلترها
        </button>
      </div>

      <!-- Meal Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-8">
        <MealCard
          v-for="meal in meals.data"
          :key="meal.id"
          :meal="meal"
          @add-to-cart="addToCart"
          @open-calendar="openCalendar"
          @view-details="viewDetails"
        />
      </div>

      <!-- Pagination -->
      <div
        v-if="meals.data.length > 0 && pagination.last_page > 1"
        class="mt-10 flex justify-center items-center gap-2 flex-wrap mb-8"
      >
        <!-- Previous Button -->
        <button
          v-if="pagination.current_page > 1"
          @click="goToPage(pagination.current_page - 1)"
          class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition cursor-pointer"
        >
          قبلی
        </button>

        <!-- First Page -->
        <button
          v-if="pagination.current_page > 3 && !visiblePages.includes(1)"
          @click="goToPage(1)"
          :class="[
            'px-3 py-1 rounded-lg border border-gray-300 cursor-pointer',
            1 === pagination.current_page ? 'bg-blue-500 text-white border-blue-500' : 'bg-white hover:bg-gray-100'
          ]"
        >
          1
        </button>

        <!-- Ellipsis -->
        <span v-if="pagination.current_page > 4" class="px-2 text-gray-500">...</span>

        <!-- Page Numbers -->
        <button
          v-for="page in visiblePages"
          :key="page"
          @click="goToPage(page)"
          :class="[
            'px-3 py-1 rounded-lg border border-gray-300 cursor-pointer',
            page === pagination.current_page ? 'bg-blue-500 text-white border-blue-500' : 'bg-white hover:bg-gray-100'
          ]"
        >
          {{ page }}
        </button>

        <!-- Ellipsis -->
        <span v-if="pagination.current_page < pagination.last_page - 3" class="px-2 text-gray-500">...</span>

        <!-- Last Page -->
        <button
          v-if="pagination.current_page < pagination.last_page - 2 && !visiblePages.includes(pagination.last_page)"
          @click="goToPage(pagination.last_page)"
          :class="[
            'px-3 py-1 rounded-lg border border-gray-300 cursor-pointer',
            pagination.last_page === pagination.current_page ? 'bg-blue-500 text-white border-blue-500' : 'bg-white hover:bg-gray-100'
          ]"
        >
          {{ pagination.last_page }}
        </button>

        <!-- Next Button -->
        <button
          v-if="pagination.current_page < pagination.last_page"
          @click="goToPage(pagination.current_page + 1)"
          class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition cursor-pointer"
        >
          بعدی
        </button>
      </div>
    </div>

    <!-- Conditional Components -->
    <RulesButton v-if="user" />
    <Calender v-if="user" v-model:open="calendarOpen" :basePrice="selectedBasePrice" />
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import MealCard from '@/components/MealCard.vue'
import RulesButton from '@/components/RulesButton.vue'
import Calender from '@/components/Calender.vue'
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const calendarOpen = ref(false)
const selectedBasePrice = ref(0)
const loading = ref(false)
const activeFilter = ref('همه')
const isDragging = ref(false)
const startX = ref(0)
const scrollLeft = ref(0)

const page = usePage()
const user = page.props.auth?.user || null

const props = defineProps({
  meals: Object,
  pagination: Object,
  filters: Object
})

// Filters
const filters = [
  { title: 'همه', type: 'category' },
  { title: 'لاین غذای اقتصادی', image: '/images/food-categories/eco.png', type: 'category' },
  { title: 'پک میانوعده', image: '/images/food-types/package.png', type: 'category' },
  { title: 'سالاد', image: '/images/food-types/salad.png', type: 'category' },
  { title: 'ساندویچ', image: '/images/food-types/sandwich.png', type: 'category' },
  { title: 'کیک و نان', image: '/images/food-types/cake.png', type: 'category' },
  { title: 'دمنوش و قهوه', image: '/images/food-types/coffee.png', type: 'category' },
  { title: 'نوشیدنی', image: '/images/food-types/drinks.png', type: 'category' },
  { title: 'اوتمیل', image: '/images/food-types/ot-meal.png', type: 'category' },
  { title: 'صبحانه', image: '/images/food-types/breakfast.png', type: 'category' },
  { title: 'دسیرت‌ها', image: '/images/food-types/dessert.png', type: 'category' },
]

// Pagination visible pages
const visiblePages = computed(() => {
  if (!props.pagination) return []
  const total = props.pagination.last_page
  const current = props.pagination.current_page
  let start = Math.max(current - 1, 1)
  let end = Math.min(current + 1, total)
  if (current <= 3) end = Math.min(5, total)
  if (current >= total - 2) start = Math.max(total - 4, 1)
  const pages = []
  for (let i = start; i <= end; i++) pages.push(i)
  return pages
})

// Filters logic
const applyFilter = (filter) => {
  loading.value = true
  activeFilter.value = filter.title
  const params = new URLSearchParams()
  if (filter.type === 'category' && filter.title !== 'همه') params.append('category', filter.title)
  router.get(`/menu?${params.toString()}`, {}, { preserveState: true, replace: true, onFinish: () => (loading.value = false) })
}

const clearFilters = () => {
  loading.value = true
  activeFilter.value = 'همه'
  router.get('/menu', {}, { preserveState: true, replace: true, onFinish: () => (loading.value = false) })
}

const goToPage = (pageNumber) => {
  loading.value = true
  const params = new URLSearchParams()
  if (props.filters?.category && props.filters.category !== 'همه') params.append('category', props.filters.category)
  if (props.filters?.type) params.append('type', props.filters.type)
  params.append('page', pageNumber)
  router.get(`/menu?${params.toString()}`, {}, { preserveState: true, replace: true, onFinish: () => (loading.value = false) })
}

const addToCart = (meal) => router.post('/cart', { meal_id: meal.id, quantity: 1 })
const viewDetails = (meal) => router.get(`/meals/${meal.id}`)
function openCalendar(payload) {
  const base = payload && typeof payload === 'object' && 'basePrice' in payload ? Number(payload.basePrice) : Number(payload)
  selectedBasePrice.value = isNaN(base) ? 0 : base
  calendarOpen.value = true
}

// Drag-to-scroll logic
const startDrag = (e) => {
  isDragging.value = true
  startX.value = e.pageX - e.currentTarget.offsetLeft
  scrollLeft.value = e.currentTarget.scrollLeft
}
const stopDrag = () => (isDragging.value = false)
const onDrag = (e) => {
  if (!isDragging.value) return
  e.preventDefault()
  const x = e.pageX - e.currentTarget.offsetLeft
  const walk = x - startX.value
  e.currentTarget.scrollLeft = scrollLeft.value - walk
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
