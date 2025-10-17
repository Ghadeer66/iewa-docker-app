<template>
    <AppLayout>
        <!-- Title -->
        <h1 class="text-3xl font-bold text-center text-gray-800 my-10">محصولات ایوا</h1>

        <!-- Filter Bar -->
        <div class="container mx-auto px-6 mb-8">
            <!-- Centered and scrollable row -->
            <div class="flex justify-center">
                <div class="flex gap-3 overflow-x-auto no-scrollbar py-2 justify-center">
                    <button v-for="filter in filters" :key="filter.title"
                        class="flex items-center gap-2 flex-shrink-0 px-4 py-2 rounded-full border border-gray-300 bg-white hover:bg-gray-100 text-sm text-gray-700 transition cursor-pointer">
                        <img class="w-5 h-5 object-contain" :src="filter.image" :alt="filter.title" />
                        <span>{{ filter.title }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Meal Cards -->
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Use openCalendar handler to capture emitted payload -->
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
            <div class="mt-10 flex justify-center gap-3">
                <button v-if="meals.prev_page_url" @click="fetchPage(meals.prev_page_url)"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    قبلی
                </button>
                <button v-if="meals.next_page_url" @click="fetchPage(meals.next_page_url)"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    بعدی
                </button>
            </div>
        </div>
    </AppLayout>

    <template v-if="user">
        <RulesButton />
        <!-- Pass the selectedBasePrice into Calender -->
        <Calender v-model:open="calendarOpen" :basePrice="selectedBasePrice" />
    </template>

</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import MealCard from '@/components/MealCard.vue'
import { router, usePage } from '@inertiajs/vue3'
import RulesButton from '@/components/RulesButton.vue'
import Calender from '@/components/Calender.vue'
import { ref } from 'vue'

const calendarOpen = ref(false)
const selectedBasePrice = ref(0) // <- store the emitted base price here

const page = usePage()
const user = page.props.auth?.user || null

const props = defineProps({ meals: Object })
const meals = props.meals

const filters = [
    { title: 'همه', image: '/storage/images/food-categories/eco.png' },
    { title: 'لاین غذای اقتصادی', image: '/storage/images/food-categories/eco.png' },
    { title: 'پک میانوعده', image: '/storage/images/food-types/package.png' },
    { title: 'سالاد', image: '/storage/images/food-types/salad.png' },
    { title: 'ساندویچ', image: '/storage/images/food-types/sandwich.png' },
    { title: 'کیک و نان', image: '/storage/images/food-types/cake.png' },
    { title: 'دمنوش و قهوه', image: '/storage/images/food-types/coffee.png' },
    { title: 'نوشیدنی', image: '/storage/images/food-types/drinks.png' },
    { title: 'اوتمیل', image: '/storage/images/food-types/ot-meal.png' },
    { title: 'صبحانه', image: '/storage/images/food-types/breakfast.png' },
    { title: 'دسیرت‌ها', image: '/storage/images/food-types/dessert.png' },
]

const addToCart = (meal) => {
    router.post('/cart', { meal_id: meal.id, quantity: 1 })
}

const viewDetails = (meal) => {
    router.get(`/meals/${meal.id}`)
}

const fetchPage = (url) => {
    router.get(url, {}, { preserveState: true, replace: true })
}

// Handler to accept the emitted payload from MealCard
function openCalendar(payload) {
    // payload is expected to be { basePrice: number } as emitted from MealCard
    // defensive: support either payload.basePrice or payload itself being a number
    const base = (payload && typeof payload === 'object' && 'basePrice' in payload)
        ? Number(payload.basePrice)
        : Number(payload)

    selectedBasePrice.value = isNaN(base) ? 0 : base
    calendarOpen.value = true
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
