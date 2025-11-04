```vue
<template>
    <div dir="rtl" class="relative">
        <!-- Floating Button -->
        <button @click="open = true" :class="[
            'fixed top-1/2 transform -translate-y-1/2 transition-all duration-700 z-50 cursor-pointer shadow-lg flex items-center justify-center font-bold text-white left-0 md:left-0 mt-20',
            isShrunk
                ? 'px-3 py-1.5 md:px-4 md:py-2 rounded-r-xl text-xs md:text-sm opacity-70 bg-[#4e3356] hover:px-4 hover:py-2 hover:text-sm hover:opacity-100 md:hover:px-6 md:hover:py-3 md:hover:text-base'
                : 'px-4 py-2 md:px-6 md:py-3 rounded-r-xl text-sm md:text-base bg-[#4e3356]'
        ]">
            <span>
                {{ isShrunk ? 'تقویم من' : 'انتخاب روز در تقویم' }}
            </span>
        </button>

        <!-- Back message -->
        <transition name="fade">
            <div v-if="backMessageVisible"
                class="fixed top-20 md:top-70 left-1/2 transform -translate-x-1/2 bg-orange-500 text-white px-4 py-3 md:px-6 md:py-4 rounded shadow-lg z-50 text-sm md:text-base">
                خرید شما با موفقیت در تقویم رزرو شد
            </div>
        </transition>

        <!-- Modal -->
        <div v-if="open" class="fixed inset-0 flex items-center justify-center backdrop-blur-md bg-white/30 z-50 p-4">
            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-4 md:p-6 relative overflow-y-auto max-h-[90vh] flex flex-col md:flex-row gap-4 md:gap-6">
                <!-- Back button -->
                <button @click="handleBackClick"
                    class="absolute top-2 right-2 md:right-3 text-gray-600 hover:text-black text-lg md:text-xl cursor-pointer z-10"
                    aria-label="Return">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 inline" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8l4 4-4 4m4-4H8" />
                    </svg>
                </button>

                <!-- Left: Calendar -->
                <div class="flex-1 w-full md:flex-1">
                    <h2 class="text-xl md:text-2xl font-bold mb-3 md:mb-4 text-black text-center">انتخاب روز این محصول در تقویم کاری</h2>

                    <div class="max-w-lg mx-auto mb-3 md:mb-4">
                        <!-- Weekday labels -->
                        <div class="grid grid-cols-7 gap-0.5 md:gap-1 text-xs font-bold text-gray-600 mb-1 md:mb-2 text-center">
                            <div v-for="label in weekdayLabels" :key="label" class="py-1">{{ label }}</div>
                        </div>

                        <!-- Weeks -->
                        <div v-for="(week, wi) in monthDays" :key="wi" class="grid grid-cols-7 gap-1 md:gap-2 mb-6 md:mb-9">
                            <div v-for="day in week" :key="day.fullDate"
                                @click="() => !isThursdayOrFriday(day) && handleDayClick(day)" :class="cellClass(day)"
                                class="w-10 h-10 md:w-14 md:h-14 rounded-sm relative transition-colors select-none cursor-pointer group">
                                <!-- Top-right icon -->
                                <div v-if="!isThursdayOrFriday(day)"
                                    class="absolute -top-1 md:-top-3 -right-0.5 md:-right-2 flex flex-col items-center">
                                    <div class="text-[10px] md:text-[12px]">{{ dayCountFor(day.fullDate) }}</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-4 h-4 md:w-6 md:h-6 text-black drop-shadow-sm">
                                        <path fill-rule="evenodd"
                                            d="M2.25 2.25a.75.75 0 000 1.5h1.636l1.808 8.138a2.25 2.25 0 002.202 1.762h9.743a2.25 2.25 0 002.15-1.61l1.605-5.743A.75.75 0 0021 5.25H6.832l-.3-1.35A2.25 2.25 0 004.5 2.25H2.25zm16.5 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-9 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Center number -->
                                <div v-if="!isThursdayOrFriday(day)" :class="[
                                    'absolute inset-0 flex items-center justify-end ml-1 text-xs md:text-sm font-bold transition-colors',
                                    day.isSelected ? 'text-white' : 'text-red-600'
                                ]">
                                    0
                                </div>

                                <!-- Footer -->
                                <div
                                    class="absolute bottom-0 left-0 w-full bg-gray-200 text-[8px] md:text-[10px] font-bold text-gray-800 text-center rounded-b-sm flex items-center justify-center h-3 md:h-auto py-0 md:py-0.5">
                                    <span v-if="!day.isToday" class="leading-none">{{ day.jDate }}</span>
                                    <span v-else class="text-blue-500 text-[8px] md:text-[10px] leading-none">امروز</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="selectedDates.length > 0" class="text-center text-xs md:text-sm text-gray-600 mb-2">
                        روزهای انتخاب شده: {{ selectedDates.length }} روز
                    </div>
                </div>

                <!-- Right: Summary Column -->
                <div class="w-full md:w-75 flex flex-col py-4 md:py-16 items-stretch">
                    <div class="h-64 md:h-[350px] rounded-xl p-3 md:p-4 text-white flex flex-col items-center justify-center text-center transition-all duration-500"
                        :class="planColorClass">
                        <div class="flex flex-col gap-2 md:gap-4 w-full"> <!-- Reduced vertical spacing on mobile -->

                            <!-- Plan Title -->
                            <div class="font-bold text-base md:text-lg text-center mb-1 md:mb-2">{{ planTitle }}</div>

                            <!-- Base Price -->
                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">قیمت محصول:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(props.basePrice) }} تومان</div>
                            </div>

                            <!-- Subsidy -->
                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">سوبسید شرکت:</div>
                                <div class="ml-4 md:ml-10">{{ subsidyPercentDisplay }}</div>
                            </div>

                            <!-- Discount -->
                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">تخفیف:</div>
                                <div class="ml-4 md:ml-10">{{ plan === 'daily' ? '۰٪' : discountPercentText }}</div>
                            </div>

                            <!-- Total Price -->
                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">جمع:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(priceToPay) }} تومان</div>
                            </div>

                            <!-- Payable Amount -->
                            <div class="flex justify-between w-full px-1 md:px-2 mt-3 md:mt-5 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">قابل پرداخت:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(totalPrice) }} تومان</div>
                            </div>

                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button
                        class="mt-4 md:mt-5 h-10 md:h-12 bg-gray-200 text-black rounded-lg font-bold hover:bg-orange-300 transition-colors cursor-pointer text-sm md:text-base">
                        ادامه خرید
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
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
const isMobile = ref(false);

const isShrunk = computed(() => !isAtTop.value || isMobile.value);

const baseWeekdayLabels = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج']; // Saturday–Friday
const weekdayLabels = computed(() => {
    const today = new Date();
    const startIdx = (today.getDay() + 1) % 7;
    const labels = [];
    for (let i = 0; i < 7; i++) {
        labels.push(baseWeekdayLabels[(startIdx + i) % 7]);
    }
    return labels;
});

const selectedDates = ref([]);
const monthDays = ref([]);
const afterTomorrowMode = ref(false);
const todayLocked = ref(false);
const tomorrowLocked = ref(false);
const cart = useCartStore();
const { items } = storeToRefs(cart);

const countsMap = computed(() => {
    const map = Object.create(null);
    for (const it of items.value) {
        map[it.dateISO] = (map[it.dateISO] || 0) + 1;
    }
    for (const d of selectedDates.value) {
        map[d] = (map[d] || 0) + 1;
    }
    return map;
});

const shippingDaily = 50000;
const shippingShared = 5000;
const subsidyRate = ref(0);

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
        case 'daily': return 'bg-red-600';
        case 'weekly': return 'bg-green-600';
        case 'monthly': return 'bg-purple-600';
        default: return 'bg-gray-500';
    }
});

function generateDaysFromToday() {
    const days = [];
    const today = new Date();
    const start = new Date(today);
    let cur = start;

    while (days.length < 28) {
        const weekdaySatIndex = (cur.getDay() + 1) % 7;
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

    const weeks = [];
    for (let i = 0; i < 28; i += 7) {
        weeks.push(days.slice(i, i + 7));
    }
    monthDays.value = weeks;
}

function isThursdayOrFriday(day) {
    const weekdaySatIndex = day.weekdaySatIndex;
    return weekdaySatIndex === 5 || weekdaySatIndex === 6;
}

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

function handleDayClick(day) {
    const iso = day.fullDate;
    const dayType = getDayType(day);

    if (dayType === 'today' && todayLocked.value) return;
    if (dayType === 'tomorrow' && tomorrowLocked.value) return;

    const idx = selectedDates.value.indexOf(iso);
    if (idx === -1) selectedDates.value.push(iso);
    else selectedDates.value.splice(idx, 1);

    monthDays.value.forEach((week) =>
        week.forEach((d) => (d.isSelected = selectedDates.value.includes(d.fullDate)))
    );

    let hasToday = false, hasTomorrow = false, hasAfterTomorrow = false, todayIso = '';
    for (const dIso of selectedDates.value) {
        const t = monthDays.value.flat().find(md => md.fullDate === dIso);
        if (!t) continue;
        const tType = getDayType(t);
        if (tType === 'today') { hasToday = true; todayIso = dIso; }
        if (tType === 'tomorrow') hasTomorrow = true;
        if (tType === 'afterTomorrow') hasAfterTomorrow = true;
    }
    if (hasTomorrow && hasAfterTomorrow) {
        todayLocked.value = true;
        if (hasToday && todayIso) {
            selectedDates.value = selectedDates.value.filter(d => d !== todayIso);
        }
    } else {
        todayLocked.value = false;
    }

    const startOfToday = new Date(); startOfToday.setHours(0, 0, 0, 0);
    const daysFromToday = (d) => {
        const sd = new Date(d.gDate); sd.setHours(0, 0, 0, 0);
        return Math.round((sd.getTime() - startOfToday.getTime()) / (24 * 60 * 60 * 1000));
    };
    let hasTomorrowSel = false, hasPlus2 = false, hasGte3 = false, tomorrowIso = '';
    for (const dIso of selectedDates.value) {
        const t = monthDays.value.flat().find(md => md.fullDate === dIso);
        if (!t) continue;
        const delta = daysFromToday(t);
        if (delta === 1) { hasTomorrowSel = true; tomorrowIso = dIso; }
        if (delta === 2) hasPlus2 = true;
        if (delta >= 3) hasGte3 = true;
    }
    if (hasPlus2 && hasGte3) {
        tomorrowLocked.value = true;
        if (hasTomorrowSel && tomorrowIso) {
            selectedDates.value = selectedDates.value.filter(d => d !== tomorrowIso);
        }
    } else {
        tomorrowLocked.value = false;
    }

    if (selectedDates.value.length === 1) {
        const onlyIso = selectedDates.value[0];
        const onlyDay = monthDays.value.flat().find(md => md.fullDate === onlyIso);
        afterTomorrowMode.value = !!onlyDay && getDayType(onlyDay) === 'afterTomorrow';
    } else {
        afterTomorrowMode.value = false;
    }

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

    // Simplified rule: single-day selection → daily plan
    if (selectedDates.value.length === 1) {
        plan.value = 'daily';
        planTitle.value = 'خرید روزانه';
        discountPercentText.value = 'بدون تخفیف';
        subsidyApplied.value = false;
        const count = selectedDates.value.length;
        const priceAfterSubsidy = props.basePrice * (1 - (subsidyRate.value || 0));
        perDayPrice.value = Math.round(priceAfterSubsidy);
        priceToPay.value = perDayPrice.value;
        totalPrice.value = perDayPrice.value * count;
        return;
    }

    const count = selectedDates.value.length;
    const weeksWithAtLeastOne = new Set();
    monthDays.value.forEach((week, wi) => {
        const selInWeek = week.filter(d => selectedDates.value.includes(d.fullDate));
        if (selInWeek.length >= 1) weeksWithAtLeastOne.add(wi);
    });

    if (count >= 8 && weeksWithAtLeastOne.size === monthDays.value.length) {
        plan.value = 'monthly';
        planTitle.value = 'خرید ماهانه';
        discountPercentText.value = '۴۰٪';
        subsidyApplied.value = true;
    } else if (count >= 3) {
        plan.value = 'weekly';
        planTitle.value = 'خرید هفتگی';
        discountPercentText.value = '۲۰٪';
        subsidyApplied.value = true;
    } else {
        plan.value = 'daily';
        planTitle.value = 'خرید روزانه';
        discountPercentText.value = 'بدون تخفیف';
        subsidyApplied.value = false;
    }

    let discount = 0;
    if (plan.value === 'weekly') discount = 0.2;
    if (plan.value === 'monthly') discount = 0.4;

    const priceAfterSubsidy = props.basePrice * (1 - (subsidyRate.value || 0));
    const priceAfterDiscount = priceAfterSubsidy * (1 - discount);
    perDayPrice.value = Math.round(priceAfterDiscount);
    priceToPay.value = perDayPrice.value;
    totalPrice.value = perDayPrice.value * count;
}

function dayCountFor(dateISO) {
    const n = countsMap.value[dateISO] || 0;
    return n.toLocaleString('fa-IR');
}

function cellClass(day) {
    const dayType = getDayType(day);
    if (isThursdayOrFriday(day)) return 'bg-gray-200 text-gray-400 border border-gray-300';
    if (todayLocked.value && dayType === 'today') return 'bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed';
    if (tomorrowLocked.value && dayType === 'tomorrow') return 'bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed';

    if (day.isSelected) {
        switch (plan.value) {
            case 'daily': return 'bg-red-500 text-white border-2 border-red-700';
            case 'weekly': return 'bg-green-500 text-white border-2 border-green-700';
            case 'monthly': return 'bg-purple-500 text-white border-2 border-purple-700';
            default: return 'bg-blue-200 text-black border-2 border-blue-400';
        }
    }
    if (day.isToday) return 'border-2 border-blue-500 bg-blue-50 text-gray-800';
    return 'bg-white text-gray-800 cursor-pointer border border-gray-300 hover:bg-blue-100';
}

const handleScroll = () => (isAtTop.value = window.scrollY < 50);

const checkMobile = () => {
  isMobile.value = window.innerWidth < 768;
};

onMounted(async () => {
    generateDaysFromToday();
    window.addEventListener('scroll', handleScroll);
    checkMobile();
    window.addEventListener('resize', checkMobile);
    try {
        const { data } = await axios.get('/api/me/subsidy');
        const pct = Number(data?.percentage ?? 0);
        subsidyRate.value = !Number.isNaN(pct) && pct > 0 ? Math.min(Math.max(pct, 0), 100) / 100 : 0;
    } catch (e) {
        subsidyRate.value = 0;
    }
    evaluatePlanAndPricing();
});
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', checkMobile);
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
        );
    }
    selectedDates.value = [];
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)));
    evaluatePlanAndPricing();

    backMessageVisible.value = true;
    setTimeout(() => (backMessageVisible.value = false), 3000);
    open.value = false;
}

watch(() => props.mealId, () => {
    selectedDates.value = [];
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)));
    evaluatePlanAndPricing();
});
watch(items, () => evaluatePlanAndPricing());
</script>
```
