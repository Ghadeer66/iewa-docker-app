<template>
    <div dir="rtl" class="relative">
        <!-- Floating Button -->
        <button @click="open = true" :class="[
            'fixed top-3/5 transform -translate-y-1/2 transition-all duration-700 z-50 cursor-pointer shadow-lg flex items-center justify-center font-bold text-white left-0',
            isAtTop
                ? 'px-6 py-3 rounded-r-xl text-base bg-[#4e3356]'
                : 'px-4 py-2 rounded-r-xl text-sm opacity-70 bg-[#4e3356] hover:px-6 hover:py-3 hover:text-base hover:opacity-100'
        ]">
            <span>
                {{ isAtTop ? 'انتخاب روز در تقویم' : 'تقویم من' }}
            </span>
        </button>

        <!-- Back message -->
        <transition name="fade">
            <div v-if="backMessageVisible"
                class="fixed top-70 left-1/2 transform -translate-x-1/2 bg-orange-500 text-white px-6 py-4 rounded shadow-lg z-50">
                خرید شما با موفقیت در تقویم رزرو شد
            </div>
        </transition>

        <!-- Modal -->
        <div v-if="open" class="fixed inset-0 flex items-center justify-center backdrop-blur-md bg-white/30 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl max-w-4xl w-11/12 p-6 relative overflow-y-auto max-h-[85vh] flex gap-6">
                <!-- Back button -->
                <button @click="handleBackClick"
                    class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl cursor-pointer"
                    aria-label="Return">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8l4 4-4 4m4-4H8" />
                    </svg>
                </button>

                <!-- Left: Calendar -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-4 text-black text-center">انتخاب روز این محصول در تقویم کاری</h2>


                    <div class="max-w-lg mx-auto mb-4">
                        <!-- Weekday labels -->
                        <div class="grid grid-cols-7 gap-1 text-xs font-bold text-gray-600 mb-2 text-center">
                            <div v-for="label in weekdayLabels" :key="label">{{ label }}</div>
                        </div>

                        <!-- Weeks -->
                        <div v-for="(week, wi) in monthDays" :key="wi" class="grid grid-cols-7 gap-2 mb-9">
                            <div v-for="day in week" :key="day.fullDate"
                                @click="() => !isThursdayOrFriday(day) && handleDayClick(day)" :class="cellClass(day)"
                                class="w-14 h-14 rounded-sm relative transition-colors select-none cursor-pointer group">
                                <!-- Top-right icon -->
                                <div v-if="!isThursdayOrFriday(day)" class="absolute -top-3 -right-2 flex flex-col items-center">
                                    <div class="text-[12px]">{{ dayCountFor(day.fullDate) }}</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 text-black drop-shadow-sm">
                                        <path fill-rule="evenodd"
                                            d="M2.25 2.25a.75.75 0 000 1.5h1.636l1.808 8.138a2.25 2.25 0 002.202 1.762h9.743a2.25 2.25 0 002.15-1.61l1.605-5.743A.75.75 0 0021 5.25H6.832l-.3-1.35A2.25 2.25 0 004.5 2.25H2.25zm16.5 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-9 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Center number -->
                                <div v-if="!isThursdayOrFriday(day)"
                                    class="absolute inset-0 flex items-center justify-end ml-1.5 text-sm font-bold text-gray-900">
                                    0 </div>

                                <!-- Footer -->
                                <div
                                    class="absolute bottom-0 left-0 w-full bg-gray-200 text-[10px] font-bold text-gray-800 text-center rounded-b-sm flex items-center justify-center">
                                    <span v-if="!day.isToday">{{ day.jDate }}</span>
                                    <span v-else class="text-blue-500 text-[10px]">امروز</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="selectedDates.length > 0" class="text-center text-sm text-gray-600 mb-2">
                        روزهای انتخاب شده: {{ selectedDates.length }} روز
                    </div>
                </div>

                <!-- Right: Summary Column -->
                <div class="w-75 flex flex-col py-16 items-stretch">
                    <div class="h-[350px] rounded-xl p-4 text-white flex flex-col items-center justify-center text-center transition-all duration-500"
                        :class="planColorClass">
                        <div class="flex flex-col gap-4 w-full"> <!-- Minimal vertical spacing -->

                            <!-- Plan Title -->
                            <div class="font-bold text-lg text-center mb-2">{{ planTitle }}</div>

                            <!-- Base Price -->
                            <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-cener mr-4">قیمت محصول:</div>
                                <div class="ml-6">{{ numberFormat(props.basePrice) }} تومان</div>
                            </div>

                            <!-- Subsidy -->
                            <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-center mr-4">سوبسید شرکت:</div>
                                <div class="ml-10">{{ subsidyPercentDisplay }}</div>
                            </div>

                            <!-- Discount -->
                            <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-center mr-4">تخفیف:</div>
                                <div class="ml-10">{{ plan === 'daily' ? '۰٪' : discountPercentText }}</div>
                            </div>


                            <!-- Taxes -->
                            <!-- <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-center mr-4">ماليات:</div>
                                <div class="ml-10">۱۰٪</div>
                            </div> -->

                            <!-- Shipping cost -->
                            <!-- <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-center mr-4">هزینه حمل:</div>
                                <div class="ml-6">۵۰.۰۰۰ تومان</div>
                            </div> -->



                            <!-- Total Price -->
                            <div class="flex justify-between w-full px-2">
                                <div class="font-medium text-center mr-4">جمع:</div>
                                <div class="ml-6">{{ numberFormat(priceToPay) }} تومان</div>
                            </div>



                            <!-- Payable Amount -->
                            <div class="flex justify-between  w-full px-2 mt-5">
                                <div class="font-medium text-right mr-4">قابل پرداخت:</div>
                                <div class="ml-6">{{ numberFormat(totalPrice) }} تومان</div>
                            </div>

                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button
                        class="mt-5 h-12 bg-gray-200 text-black rounded-lg font-bold hover:bg-orange-300 transition-colors cursor-pointer"
                        @click="$emit('continue')">
                        ادامه خرید
                    </button>
                </div>


            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';
import { useCartStore } from '@/stores/cart'
import { storeToRefs } from 'pinia'
import { toJalaali } from 'jalaali-js';

const props = defineProps({
    open: Boolean,
    basePrice: { type: Number, default: 200000 },
    mealId: { type: String, default: 'default' },
    mealTitle: { type: String, default: 'محصول' },
    mealImage: { type: String, default: '' },
    mealQuantity: { type: Number, default: 1 }
});

const emit = defineEmits(['update:open', 'continue']);

const open = computed({
    get: () => props.open,
    set: (val) => emit('update:open', val)
});

const isAtTop = ref(true);
const baseWeekdayLabels = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج']; // Saturday–Friday
const weekdayLabels = computed(() => {
    const today = new Date();
    const startIdx = (today.getDay() + 1) % 7; // 0=Sat .. 6=Fri
    const labels = [];
    for (let i = 0; i < 7; i++) {
        labels.push(baseWeekdayLabels[(startIdx + i) % 7]);
    }
    return labels;
});

const selectedDates = ref([]);
const monthDays = ref([]);
const afterTomorrowMode = ref(false);
const cart = useCartStore();
const { items } = storeToRefs(cart);

// Reactive counts per date for the current meal
const countsMap = computed(() => {
    const map = Object.create(null);
    // existing purchases in cart (for ALL meals)
    for (const it of items.value) {
        map[it.dateISO] = (map[it.dateISO] || 0) + 1;
    }
    // also reflect current selections (optimistic count before add)
    for (const d of selectedDates.value) {
        map[d] = (map[d] || 0) + 1;
    }
    return map;
});

const shippingDaily = 50000;
const shippingShared = 5000;
const subsidyRate = ref(0); // 0..1

const plan = ref('daily');
const planTitle = ref('---');
const discountPercentText = ref('');
const subsidyApplied = ref(false);
const subsidyPercentDisplay = computed(() => {
    const pct = Math.round((subsidyRate.value || 0) * 100);
    return (pct > 0 ? pct : 0).toLocaleString('fa-IR') + '٪';
});
const perDayPrice = ref(props.basePrice);
const priceToPay = ref(0);
const totalPrice = ref(0);

const numberFormat = (n) => n.toLocaleString('fa-IR');

const planColorClass = computed(() => {
    switch (plan.value) {
        case 'daily':
            return 'bg-red-600';
        case 'weekly':
            return 'bg-green-600';
        case 'monthly':
            return 'bg-purple-600';
        default:
            return 'bg-gray-500';
    }
});

// Generate only Saturday–Wednesday days
function generateDaysFromToday() {
    const days = [];
    const today = new Date();
    const start = new Date(today);
    let cur = start;

    // Collect exactly 28 consecutive days starting from today
    while (days.length < 28) {
        const weekdaySatIndex = (cur.getDay() + 1) % 7; // 0=Sat .. 6=Fri
        const j = toJalaali(cur.getFullYear(), cur.getMonth() + 1, cur.getDate());
        const isToday = cur.toDateString() === today.toDateString();
        days.push({
            gDate: new Date(cur),
            fullDate: cur.toISOString().split('T')[0],
            jDate: j.jd,
            jMonth: j.jm,
            jYear: j.jy,
            isToday,
            isSelected: false,
            weekdaySatIndex
        });
        cur.setDate(cur.getDate() + 1);
    }

    // Group into 4 rows of 7 days starting from today
    const weeks = [];
    for (let i = 0; i < 28; i += 7) {
        weeks.push(days.slice(i, i + 7));
    }
    monthDays.value = weeks;
}

// Check if day is Thursday or Friday
function isThursdayOrFriday(day) {
    const weekdaySatIndex = day.weekdaySatIndex; // 0=Sat .. 6=Fri
    return weekdaySatIndex === 5 || weekdaySatIndex === 6; // Thursday=5, Friday=6
}

// Determine day type
function getDayType(day) {
    const today = new Date();
    const tomorrow = new Date(); tomorrow.setDate(today.getDate() + 1);
    const afterTomorrow = new Date(); afterTomorrow.setDate(today.getDate() + 2);
    const d = new Date(day.gDate);

    if (d.toDateString() === today.toDateString()) return 'today';
    if (d.toDateString() === tomorrow.toDateString()) return 'tomorrow';
    if (d.toDateString() === afterTomorrow.toDateString()) return 'afterTomorrow';
    return 'other';
}

// Handle day click with new logic
function handleDayClick(day) {
    const iso = day.fullDate;
    const dayType = getDayType(day);

    if (dayType === 'afterTomorrow') {
        const idx = selectedDates.value.indexOf(iso);
        if (idx === -1) {
            // Remove all afterTomorrow dates first
            selectedDates.value = selectedDates.value.filter(d => {
                const t = monthDays.value.flat().find(md => md.fullDate === d);
                const type = getDayType(t);
                return type !== 'afterTomorrow';
            });
            selectedDates.value.push(iso);
            afterTomorrowMode.value = true;
        } else {
            selectedDates.value.splice(idx, 1);
            afterTomorrowMode.value = false;
        }
    }
    // Only block selection of TODAY if afterTomorrowMode is active
    else if (dayType === 'today' && afterTomorrowMode.value) {
        return; // today is locked
    }
    else {
        const idx = selectedDates.value.indexOf(iso);
        if (idx === -1) selectedDates.value.push(iso);
        else selectedDates.value.splice(idx, 1);
    }

    monthDays.value.forEach((week) =>
        week.forEach((d) => (d.isSelected = selectedDates.value.includes(d.fullDate)))
    );

    evaluatePlanAndPricing();
}


function evaluatePlanAndPricing() {
    perDayPrice.value = props.basePrice;
    priceToPay.value = 0;
    totalPrice.value = 0;
    discountPercentText.value = '';
    subsidyApplied.value = subsidyRate.value > 0;

    if (selectedDates.value.length === 0) {
        plan.value = 'daily';
        planTitle.value = 'هیچ روزی انتخاب نشده';
        return;
    }

    const count = selectedDates.value.length;

    // Determine how many weeks have at least 1 selected day
    const weeksWithAtLeastOne = new Set();
    monthDays.value.forEach((week, wi) => {
        const selInWeek = week.filter(d => selectedDates.value.includes(d.fullDate));
        if (selInWeek.length >= 1) weeksWithAtLeastOne.add(wi);
    });

    // Monthly plan: at least 8 days AND at least 1 day in each week
    if (count >= 8 && weeksWithAtLeastOne.size === monthDays.value.length) {
        plan.value = 'monthly';
        planTitle.value = 'خرید ماهانه';
        discountPercentText.value = '۴۰٪';
        subsidyApplied.value = true;
    }
    // Weekly plan: at least 3 days
    else if (count >= 3) {
        plan.value = 'weekly';
        planTitle.value = 'خرید هفتگی';
        discountPercentText.value = '۲۰٪';
        subsidyApplied.value = true;
    }
    // Daily plan
    else {
        plan.value = 'daily';
        planTitle.value = 'خرید روزانه';
        discountPercentText.value = 'بدون تخفیف';
        subsidyApplied.value = false;
    }

    // Pricing according to requested formula:
    // priceAfterSubsidy = basePrice - basePrice * subsidy
    // priceAfterDiscount = priceAfterSubsidy - priceAfterSubsidy * discount
    let discount = 0;
    if (plan.value === 'weekly') discount = 0.2;
    if (plan.value === 'monthly') discount = 0.4;

    const priceAfterSubsidy = props.basePrice * (1 - (subsidyRate.value || 0));
    const priceAfterDiscount = priceAfterSubsidy * (1 - discount);

    perDayPrice.value = Math.round(priceAfterDiscount);
    // const shipping = plan.value === 'daily' ? shippingDaily : shippingShared;
    priceToPay.value = perDayPrice.value;
    totalPrice.value = perDayPrice.value * count ;//+ shipping;
}


function dayCountFor(dateISO) {
    const n = countsMap.value[dateISO] || 0
    return n.toLocaleString('fa-IR')
}

// Cell class for highlighting and lock style
function cellClass(day) {
    const dayType = getDayType(day);

    // Lock Thursday and Friday
    if (isThursdayOrFriday(day)) {
        return 'bg-gray-200 text-gray-400 border border-gray-300';
    }

    // Only lock TODAY when afterTomorrowMode is active
    if (afterTomorrowMode.value && dayType === 'today') {
        return 'bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed';
    }

    if (day.isSelected) {
        switch (plan.value) {
            case 'daily':
                return 'bg-red-500 text-white border-2 border-red-700';
            case 'weekly':
                return 'bg-green-500 text-white border-2 border-green-700';
            case 'monthly':
                return 'bg-purple-500 text-white border-2 border-purple-700';
            default:
                return 'bg-blue-200 text-black border-2 border-blue-400';
        }
    }
    if (day.isToday) return 'border-2 border-blue-500 bg-blue-50 text-gray-800';
    return 'bg-white text-gray-800 cursor-pointer border border-gray-300 hover:bg-blue-100';
}


const handleScroll = () => (isAtTop.value = window.scrollY < 50);

onMounted(async () => {
    generateDaysFromToday();
    window.addEventListener('scroll', handleScroll);
    // Fetch user's subsidy
    try {
        const { data } = await axios.get('/api/me/subsidy');
        const pct = Number(data?.percentage ?? 0);
        if (!Number.isNaN(pct) && pct > 0) {
            subsidyRate.value = Math.min(Math.max(pct, 0), 100) / 100;
        } else {
            subsidyRate.value = 0;
        }
    } catch (e) {
        subsidyRate.value = 0;
    }
    // Re-evaluate prices in case open with preselected state later
    evaluatePlanAndPricing();
});
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const backMessageVisible = ref(false);
function handleBackClick() {
    if (selectedDates.value.length > 0) {
        cart.addSelections(
            props.mealId,
            props.mealTitle,
            selectedDates.value.slice(),
            perDayPrice.value,
            props.mealImage,
            props.mealQuantity || 1,
        )
    }
    selectedDates.value = []
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)))
    evaluatePlanAndPricing()

    backMessageVisible.value = true;
    setTimeout(() => (backMessageVisible.value = false), 3000);
    open.value = false;
}
import { watch } from 'vue'
watch(() => props.mealId, () => {
    selectedDates.value = []
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)))
    evaluatePlanAndPricing()
})
watch(items, () => {
    // re-evaluate to refresh amounts if needed
    evaluatePlanAndPricing()
})

</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
