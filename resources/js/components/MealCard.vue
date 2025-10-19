<template>
    <div
        class="meal-card bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col relative">

        <!-- Image -->
        <div class="relative w-full bg-gray-100">
            <img :src="meal.image_url ?? (meal.image ? `/storage/${meal.image}` : '/images/placeholder.png')"
                :alt="meal.title || 'meal'" class="w-full h-90 object-cover rounded-t-2xl" />
            <span v-if="meal.is_new"
                class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                جدید
            </span>
        </div>

        <!-- Content -->
        <div class="p-4 flex flex-col flex-grow">
            <div
                class="container w-auto gap-5 flex flex-nowrap justify-between items-center rounded-2xl bg-orange-100 py-2 px-3 mx-auto sm:scale-100 scale-90">
                <h3 class="font-bold text-gray-800 text-md text-right">{{ meal.title }}</h3>
                <h3 class="font-bold text-orange-500 text-md text-left">{{ meal.kcal }} کالری</h3>
            </div>

            <div class="mt-auto">
                <!-- Price in card -->
                <div class="flex justify-center items-center gap-2 mb-3 mt-2">
                    <span class="text-sm text-gray-400">قیمت:</span>
                    <span class="font-semibold text-green-600 text-base">{{ discountedPrice.toLocaleString() }}
                        تومان</span>
                </div>

                <!-- Quantity Selector -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-center justify-center gap-4 p-1 border border-gray-200 rounded-2xl w-40">
                        <button @click="decreaseQuantity" :disabled="quantity <= 1" :class="[
                            'w-8 h-8 rounded-full transition flex items-center justify-center',
                            quantity > 1
                                ? 'bg-gray-200 text-gray-600 hover:bg-gray-300 cursor-pointer'
                                : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                        ]">-</button>
                        <span class="text-lg font-semibold">{{ quantity }}</span>
                        <button @click="increaseQuantity"
                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition flex items-center justify-center cursor-pointer">+</button>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center gap-3">
                    <button @click="openModal"
                        class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-1 rounded-md text-sm hover:bg-yellow-200 transition cursor-pointer">
                        جزئیات بیشتر
                    </button>

                    <button @click="emitOpenCalendar"
                        class="px-4 py-1 rounded-md text-sm transition bg-green-500 text-white hover:bg-green-600 cursor-pointer">
                        انتخاب روز
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Popup -->
        <div v-if="isModalOpen"
            class="fixed inset-0 flex items-center justify-center z-50 p-4 backdrop-blur-sm bg-white/30"
            @click="closeModal">
            <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative"
                @click.stop>

                <!-- Close Button -->
                <button @click="closeModal"
                    class="absolute top-1 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold z-10 cursor-pointer">
                    ×
                </button>

                <!-- Modal Content -->
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column: Details -->
                    <div class="space-y-4">
                        <MealSlideshow :images="[
                            'https://images.unsplash.com/photo-1606755962773-0a92177135b9',
                            'https://images.unsplash.com/photo-1551218808-94e220e084d2'
                        ]" :title="meal.title" :is-new="meal.is_new" />

                        <!-- Nutrition Label -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-700">اطلاعات تغذیه‌ای</span>
                            </div>
                            <div class="space-y-1 text-xs text-gray-600">
                                <div class="flex justify-between"><span>کالری</span><span>۶۰۰</span></div>
                                <div class="flex justify-between"><span>پروتئین</span><span>۱۸.۲g</span></div>
                                <div class="flex justify-between"><span>کربوهیدرات</span><span>۲۲.۹g</span></div>
                                <div class="flex justify-between"><span>چربی</span><span>۴.۵g</span></div>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="flex items-center justify-center gap-4 p-3 border border-gray-200 rounded-lg">
                            <button @click="decreaseQuantity" :disabled="quantity <= 1" :class="[
                                'w-8 h-8 rounded-full transition',
                                quantity > 1
                                    ? 'bg-gray-200 text-gray-600 hover:bg-gray-300 cursor-pointer'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                            ]">-</button>
                            <span class="text-lg font-semibold">{{ quantity }}</span>
                            <button @click="increaseQuantity"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition cursor-pointer">+</button>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center mt-4">
                            <button @click="emitOpenCalendar" :disabled="isAuthenticated"
                                class="w-full bg-green-500 text-white py-3 rounded-md text-sm font-medium hover:bg-green-600 transition disabled:bg-gray-300 disabled:cursor-not-allowed">
                                انتخاب روز
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Full Meal Image and Nutrition Table -->
                    <div class="space-y-4">
                        <!-- Nutrition Table -->
                        <div class="bg-gray-50 p-4 rounded-lg overflow-x-auto">
                            <h4 class="text-sm font-semibold text-gray-800 text-right"> موارد منع مصرف </h4>
                            <table class="w-full text-xs text-gray-600">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-right py-1 pr-2"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right py-1 pr-2">چربی</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="text-sm font-semibold text-gray-800 mt-4 text-right"> موارد مصرف </h4>
                            <table class="w-full text-xs text-gray-600">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-right py-1 pr-2"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right py-1 pr-2">چربی</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="text-sm font-semibold text-gray-800 text-right mt-6"> محتویات </h4>
                            <table class="w-full text-xs text-gray-600">
                                <tbody>
                                    <tr>
                                        <td class="text-right py-1 pr-2">
                                            <p class="text-xs text-gray-500 text-right leading-relaxed">
                                                شامل: نمک، شکر، سس سویا، روغن کنجد، سس تند، برنج، سبزیجات، و غیره.
                                                ممکن است حاوی بادام زمینی باشد.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Discount hints with price after discount -->

                            <div class="mt-8 text-right text-sm text-gray-500 space-y-1">

                                <p class="font-semibold text-gray-800">💡 تخفیف پلن‌ها:</p>
                                <ul class="list-disc list-inside">
                                    <li class="mt-3" v-for="item in plansWithPrices" :key="item.plan">
                                        {{ item.plan }}: {{ item.discountPercent }}٪ قیمت پس از تخفیف: {{
                                            item.priceAfterDiscount.toLocaleString() }} تومان
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import MealSlideshow from '@/components/MealSlideshow.vue'

const props = defineProps({
    meal: { type: Object, default: () => ({}) },
    isAuthenticated: { type: Boolean, default: false }
})

const isModalOpen = ref(false)
const quantity = ref(1)

const planDiscounts = {
    'روزانه': 0,
    'هفتگی': 0.2,
    'ماهانه': 0.4
}

// Price for selected plan (used in card header)
const discountedPrice = computed(() => {
    const price = props.meal.price || 0
    return Math.round(price * (1 - (planDiscounts['روزانه'])) * quantity.value) // default plan for card display
})

// Price for all plans (displayed under محتویات)
const plansWithPrices = computed(() => {
    const basePrice = props.meal.price || 0
    return Object.entries(planDiscounts).map(([plan, discount]) => ({
        plan,
        discountPercent: discount * 100,
        priceAfterDiscount: Math.round(basePrice * (1 - discount) * quantity.value)
    }))
})

const openModal = () => { isModalOpen.value = true }
const closeModal = () => { isModalOpen.value = false }
const increaseQuantity = () => { quantity.value++ }
const decreaseQuantity = () => { if (quantity.value > 1) quantity.value-- }

const emit = defineEmits(['open-calendar'])
const emitOpenCalendar = () => {
    emit('open-calendar', { basePrice: discountedPrice.value })
}
</script>
