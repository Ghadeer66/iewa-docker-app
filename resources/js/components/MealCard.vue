<template>
    <div
        class="meal-card bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200 flex flex-col relative">

        <!-- Image -->
        <div class="relative w-full bg-gray-100">
            <img :src="meal.thumbnail_url ?? meal.image_url ?? (meal.image ? `/${meal.image}` : '/images/placeholder.png')"
                :alt="meal.title || 'meal'" class="w-full object-cover rounded-t-2xl" style="aspect-ratio: 3 / 2;" />
            <span v-if="meal.is_new"
                class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                جدید
            </span>
        </div>

        <!-- Content -->
        <div class="p-4 flex flex-col flex-grow">
            <div class="flex justify-between items-center gap-4 bg-orange-100 p-3 rounded-xl mb-3">
                <h3 class="font-bold text-gray-800 text-md">{{ meal.title }}</h3>
                <h3 class="font-bold text-orange-500 text-md">{{ meal.kcal }}  کالری </h3>
            </div>

            <!-- Price -->
            <div class="flex justify-center items-center gap-2 mb-3">
                <span class="text-sm text-gray-500">قیمت:</span>
                <span class="font-semibold text-green-600 text-base">{{ discountedPrice.toLocaleString() }} تومان</span>
            </div>

            <!-- Quantity Selector -->
            <div class="flex justify-center mb-3">
                <div class="flex items-center justify-center gap-4 p-1 border border-gray-200 rounded-2xl w-40">
                    <button @click="decreaseQuantity" :disabled="quantity <= 1"
                        :class="quantity > 1 ? 'bg-gray-200 text-gray-600 hover:bg-gray-300' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                        class="w-8 h-8 rounded-full transition flex items-center justify-center">-</button>
                    <span class="text-lg font-semibold">{{ quantity }}</span>
                    <button @click="increaseQuantity"
                        class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition flex items-center justify-center">+</button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-3">
                <button @click="openModal"
                    class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-1 rounded-md text-sm hover:bg-yellow-200 transition cursor-pointer">
                    جزئیات بیشتر
                </button>

                <button @click="emitOpenCalendar"
                    class="px-4 py-2 rounded-md text-sm transition bg-green-500 text-white hover:bg-green-600 cursor-pointer">
                    انتخاب روز
                </button>
            </div>
        </div>

        <!-- Modal: Classic Professional Style -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
            @click="closeModal">
            <div @click.stop
                class="bg-white rounded-xl shadow-xl w-full max-w-5xl max-h-[85vh] overflow-hidden border border-gray-200 flex">

                <!-- Left Column: Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <!-- Header -->
                    <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                        <button @click="closeModal"
                            class="text-gray-500 hover:text-gray-700 text-2xl font-bold cursor-pointer">
                            ×
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">{{ meal.title }}</h2>

                    </div>

                    <div v-if="galleryImages.length > 1" class="relative w-full">
                        <img :src="galleryImages[currentSlide]" :alt="meal.title || 'meal'"
                            class="w-full object-cover rounded-lg shadow-sm" style="aspect-ratio: 3 / 2;" />
                        <!-- Prev -->
                        <button @click="prevSlide" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white w-8 h-8 rounded-full flex items-center justify-center">‹</button>
                        <!-- Next -->
                        <button @click="nextSlide" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white w-8 h-8 rounded-full flex items-center justify-center">›</button>
                        <!-- Dots -->
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
                            <button v-for="(img, idx) in galleryImages" :key="idx" @click="goToSlide(idx)"
                                :class="idx === currentSlide ? 'bg-white' : 'bg-white/50'"
                                class="w-2.5 h-2.5 rounded-full"></button>
                        </div>
                    </div>
                    <img v-else :src="galleryImages[0] ?? (meal.image_url ?? (meal.image ? `/${meal.image}` : '/images/placeholder.png'))"
                        :alt="meal.title || 'meal'" class="w-full object-cover rounded-lg shadow-sm" style="aspect-ratio: 3 / 2;" />

                    <!-- Nutrition Information -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-2">اطلاعات تغذیه‌ای</h3>
                        <div class="space-y-1 text-gray-600 text-sm">
                            <div v-for="(value, key) in meal.nutritional_informations" :key="key"
                                class="flex justify-between">
                                <span>{{ key }}</span>
                                <span>{{ value }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="flex items-center justify-center gap-4 p-3 border border-gray-200 rounded-lg">
                        <button @click="decreaseQuantity" :disabled="quantity <= 1"
                            :class="quantity > 1 ? 'bg-gray-200 text-gray-600 hover:bg-gray-300' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                            class="w-8 h-8 rounded-full transition flex items-center justify-center">-</button>
                        <span class="text-lg font-semibold">{{ quantity }}</span>
                        <button @click="increaseQuantity"
                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition flex items-center justify-center">+</button>
                    </div>

                    <button @click="emitOpenCalendar" :disabled="isAuthenticated"
                        class="w-full bg-green-500 text-white py-3 rounded-md text-sm font-medium hover:bg-green-600 transition disabled:bg-gray-300 disabled:cursor-not-allowed">
                        انتخاب روز
                    </button>

                    <!-- Contraindications -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-2">موارد منع مصرف</h3>
                        <ul class="list-disc list-inside text-gray-600 text-sm">
                            <li v-for="item in meal.contraindications" :key="item">{{ item }}</li>
                        </ul>
                    </div>

                    <!-- Consumable Items -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-2">موارد مصرف</h3>
                        <ul class="list-disc list-inside text-gray-600 text-sm">
                            <li v-for="item in meal.consumable_items" :key="item">{{ item }}</li>
                        </ul>
                    </div>

                    <!-- Ingredients -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-2">محتویات</h3>
                        <ul class="list-disc list-inside text-gray-600 text-sm">
                            <li v-for="ingredient in meal.ingredients" :key="ingredient.id">{{ ingredient.title }}</li>
                        </ul>
                    </div>

                    <!-- Plans -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-2">💡 تخفیف پلن‌ها</h3>
                        <ul class="list-disc list-inside text-gray-600 text-sm">
                            <li v-for="item in plansWithPrices" :key="item.plan">
                                {{ item.plan }}: {{ item.discountPercent }}٪ قیمت پس از تخفیف: {{ item.priceAfterDiscount.toLocaleString() }} تومان
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Sticky Comments -->
                <div class="w-80 border-l border-gray-200 bg-gray-50 p-4 flex flex-col">
                    <h3 class="font-semibold text-gray-800 mb-3">نظرات شما</h3>

                    <!-- Comment Input -->
                    <div class="flex mb-4 gap-2">
                        <input type="text" placeholder="تو هم نظر خودت رو بزار..."
                            class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                        <button
                            class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">ارسال
                            نظر</button>
                    </div>

                    <!-- Comments List -->
                    <div class="flex-1 space-y-3 overflow-y-auto">
                        <div v-for="(comment, index) in comments" :key="index"
                            class="flex gap-3 bg-white p-3 rounded-lg border border-gray-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-full bg-lime-400 flex items-center justify-center text-white text-lg font-bold">
                                    {{ comment.user.charAt(0) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800">{{ comment.user }}</span>
                                <span class="text-gray-600 text-sm">{{ comment.text }}</span>
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

const props = defineProps({
    meal: Object,
    isAuthenticated: { type: Boolean, default: false }
})

const isModalOpen = ref(false)
const quantity = ref(1)

const planDiscounts = {
    'روزانه': 0,
    'هفتگی': 0.2,
    'ماهانه': 0.4
}

const discountedPrice = computed(() => {
    const price = props.meal.price || 0
    return Math.round(price * (1 - planDiscounts['روزانه']) * quantity.value)
})

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
    const image = (props.meal.thumbnail_url ?? props.meal.image_url ?? (props.meal.image ? `/${props.meal.image}` : '/images/placeholder.png'))
    emit('open-calendar', {
        basePrice: discountedPrice.value,
        mealId: props.meal.id,
        mealTitle: props.meal.title,
        mealImage: image,
        quantity: quantity.value,
    })
}

/*const comments = ref([
  { user: 'نیلوفر زمانی', text: 'کیفیت فوق العاده کاملا تازه' },
  { user: 'نیلوفر شکرانه اقدام', text: 'والا خوشمزه و عالی بود آدم ازش سیر نمیشه' },
  { user: 'شیما طوسی', text: 'واقعا عالی و بینظیر بود' },
  { user: 'آیدا طالبی', text: 'سالاد ها همیشه خیلی تازه و فرش هست لطفا همین جوری بمونید' },
  { user: 'نیلوفر حدادیان', text: 'دخترم از مشتری های شماست و واقعا از خوردن غذاهای شما لذت میبره' },
  { user: 'مرتضی پیروانی', text: 'تنوع غذاها خوبه این سالاد و من از بوتیک گرفته بودم' }
])
*/
// Build gallery images from related images if present
const galleryImages = computed(() => {
    const imgs = Array.isArray(props.meal?.images)
        ? props.meal.images
            .map((img) => {
                const u = img?.url
                if (!u) return null
                if (u.startsWith('http://') || u.startsWith('https://') || u.startsWith('/')) return u
                return `/${u}`
            })
            .filter(Boolean)
        : []
    // Fallback to single provided url if no images relation
    if (imgs.length === 0 && props.meal?.image_url) {
        return [props.meal.image_url]
    }
    return imgs
})

const currentSlide = ref(0)
const nextSlide = () => { if (galleryImages.value.length > 0) currentSlide.value = (currentSlide.value + 1) % galleryImages.value.length }
const prevSlide = () => { if (galleryImages.value.length > 0) currentSlide.value = (currentSlide.value - 1 + galleryImages.value.length) % galleryImages.value.length }
const goToSlide = (idx) => { if (idx >= 0 && idx < galleryImages.value.length) currentSlide.value = idx }
</script>
