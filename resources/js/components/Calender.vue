<template>
    <div dir="rtl" class="relative">
        <!-- Floating Button -->
        <button @click="open = true" :class="[
            'fixed top-3/5 transform -translate-y-1/2 transition-all duration-700 z-50 cursor-pointer shadow-lg flex items-center justify-center font-bold text-white left-0',
            isAtTop
                ? 'px-6 py-3 rounded-r-xl text-base bg-[#4e3356]'
                : 'px-4 py-2 rounded-r-xl text-sm opacity-70 bg-[#4e3356] hover:px-6 hover:py-3 hover:rounded-r-xl hover:text-center hover:text-base hover:opacity-100'
        ]">
            <span>
                {{ isAtTop ? 'انتخاب روز در تقویم' : 'تقویم من' }}
            </span>
        </button>

        <!-- Modal -->
        <div v-if="open" class="fixed inset-0 flex items-center justify-center backdrop-blur-md bg-white/30 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl max-w-4xl w-11/12 p-6 relative overflow-y-auto max-h-[85vh] flex gap-6">
                <button @click="open = false"
                    class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl cursor-pointer">
                    ✕
                </button>

                <!-- Left: Calendar -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-4 text-center">انتخاب روز در تقویم کاری</h2>
                    <p class="mb-2 text-gray-700">انتخاب روز مشخص برای خرید محصولات در سایت ایوا.</p>

                    <div class="max-w-lg mx-auto mb-4">
                        <div class="grid grid-cols-7 gap-1 text-xs font-bold text-gray-600 mb-2 text-center">
                            <div v-for="label in weekdayLabels" :key="label">{{ label }}</div>
                        </div>

                        <div v-for="(week, wi) in monthDays" :key="wi" class="grid grid-cols-7 gap-1 mb-1">
                            <div v-for="day in week" :key="day.fullDate" @click="() => handleDayClick(day)"
                                :class="cellClass(day)"
                                class="w-12 h-12 rounded-sm flex items-center justify-center text-sm transition-colors relative select-none">
                                <div class="text-center">
                                    <div>{{ day.jDate }}</div>
                                    <div v-if="day.isToday" class="text-[10px] mt-0">امروز</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="selectedDates.length > 0" class="text-center text-sm text-gray-600 mb-2">
                        روزهای انتخاب شده: {{ selectedDates.length }} روز
                    </div>
                </div>

                <!-- Right: Summary Column -->
                <div class="w-64 flex flex-col items-stretch">
                    <div class="h-[340px] rounded-xl p-4 text-white flex flex-col items-center justify-center text-center transition-all duration-500"
                        :class="planColorClass">
                        <div>
                            <div class="text-sm opacity-90">نوع خرید</div>
                            <div class="font-bold text-lg mt-1">{{ planTitle }}</div>
                            <div class="mt-4 text-xs leading-relaxed">
                                <div>قیمت پایه (هر روز): {{ numberFormat(props.basePrice) }} تومان</div>
                                <div v-if="plan !== 'daily'">تخفیف: {{ discountPercentText }}</div>
                                <div v-if="subsidyApplied">سوبسید شرکت اعمال شد</div>
                                <div class="mt-3 text-xl font-black">{{ numberFormat(perDayPrice) }} تومان / روز</div>
                                <div class="mt-3 text-lg">مجموع: {{ numberFormat(totalPrice) }} تومان</div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="mt-3 h-12 bg-gray-200 text-black rounded-lg font-bold hover:bg-orange-300 transition-colors cursor-pointer"
                        @click="$emit('continue')">
                        ادامه خرید
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { toJalaali } from 'jalaali-js';

const props = defineProps({
    open: Boolean,
    basePrice: {
        type: Number,
        default: 200000
    }
})

watch(() => props.basePrice, (newPrice) => {
  if (props.open) {
    totalPrice.value = newPrice
  }
})
const emit = defineEmits(['update:open', 'continue'])

const open = computed({
    get: () => props.open,
    set: (val) => emit('update:open', val)
})
// const open = ref(false);
const isAtTop = ref(true);
const weekdayLabels = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'];

const selectedDates = ref([]);
const monthDays = ref([]);

// Pricing setup
const shippingDaily = 50000;
const shippingShared = 5000;
const subsidyPercent = 0.3;

const plan = ref('daily');
const planTitle = ref('---');
const discountPercentText = ref('');
const subsidyApplied = ref(false);
const perDayPrice = ref(props.basePrice);
const totalPrice = ref(0);

const numberFormat = (n) => n.toLocaleString('fa-IR');

// Dynamic background color for plan
const planColorClass = computed(() => {
    switch (plan.value) {
        case 'daily': return 'bg-red-600';
        case 'weekly': return 'bg-green-600';
        case 'monthly': return 'bg-purple-600';
        default: return 'bg-gray-500';
    }
});

// === Calendar: Start from today (Jalali) ===
const todayG = new Date();

function generateDaysFromToday(count = 30) {
    const days = [];
    let cur = new Date(todayG);
    for (let i = 0; i < count; i++) {
        const j = toJalaali(cur.getFullYear(), cur.getMonth() + 1, cur.getDate());
        days.push({
            gDate: new Date(cur),
            fullDate: cur.toISOString().split('T')[0],
            jDate: j.jd,
            jMonth: j.jm,
            jYear: j.jy,
            isToday: i === 0,
            isSelected: false,
            weekdaySatIndex: (cur.getDay() + 1) % 7, // 0=Sat, 6=Fri
        });
        cur.setDate(cur.getDate() + 1);
    }

    const weeks = [];
    for (let i = 0; i < days.length; i += 7) {
        weeks.push(days.slice(i, i + 7));
    }
    monthDays.value = weeks;
}

function handleDayClick(day) {
    // Disable Thu (2) and Fri (3)
    if (day.weekdaySatIndex === 4 || day.weekdaySatIndex === 5) return;

    const iso = day.fullDate;
    const idx = selectedDates.value.indexOf(iso);
    if (idx === -1) selectedDates.value.push(iso);
    else selectedDates.value.splice(idx, 1);

    monthDays.value.forEach((week) =>
        week.forEach((d) => (d.isSelected = selectedDates.value.includes(d.fullDate)))
    );

    evaluatePlanAndPricing();
}

function evaluatePlanAndPricing() {
    // Determine plan based on current selection, but persist weekly if achieved
    perDayPrice.value = props.basePrice;
    totalPrice.value = 0;
    discountPercentText.value = '';
    subsidyApplied.value = false;

    if (selectedDates.value.length === 0) {
        planTitle.value = 'هیچ روزی انتخاب نشده';
        return;
    }

    // Determine plan type
    const byWeek = {};
    const allDates = selectedDates.value.map((iso) => new Date(iso));
    allDates.forEach((d) => {
        const weekdaySatIndex = (d.getDay() + 1) % 7;
        const sat = new Date(d);
        sat.setDate(sat.getDate() - weekdaySatIndex);
        const j = toJalaali(sat.getFullYear(), sat.getMonth() + 1, sat.getDate());
        const key = `${j.jy}-${j.jm}-${j.jd}`;
        if (!byWeek[key]) byWeek[key] = [];
        byWeek[key].push(d);
    });

    const weekKeys = Object.keys(byWeek).sort();
    const weekCounts = weekKeys.map((k) => byWeek[k].length);

    // Conditions
    const meetsDaily = selectedDates.value.length <= 2 && weekKeys.length === 1;
    const meetsWeekly = weekKeys.length >= 1 && weekKeys.length <= 3 && weekCounts.every((c) => c >= 3);
    const meetsMonthly = weekKeys.length >= 4 && weekCounts.every((c) => c >= 2);

    // Persist monthly once achieved
    if (plan.value === 'monthly' || meetsMonthly) {
        plan.value = 'monthly';
        planTitle.value = 'خرید ماهانه';
        discountPercentText.value = '۴۰٪';
        subsidyApplied.value = true;
    } else if ((meetsWeekly || plan.value === 'weekly') && !meetsMonthly) {
        // Stay weekly once achieved unless user drops below weekly to daily
        if (meetsDaily) {
            plan.value = 'daily';
            planTitle.value = 'خرید روزانه';
            discountPercentText.value = 'بدون تخفیف';
            subsidyApplied.value = false;
            return;
        }
        plan.value = 'weekly';
        planTitle.value = 'خرید هفتگی';
        discountPercentText.value = '۲۰٪';
        subsidyApplied.value = true;
    } else if (meetsDaily) {
        plan.value = 'daily';
        planTitle.value = 'خرید روزانه';
        discountPercentText.value = 'بدون تخفیف';
    } else {
        plan.value = 'custom';
        planTitle.value = 'طرح سفارشی';
    }

    let discount = 0;
    if (plan.value === 'weekly') discount = 0.2;
    if (plan.value === 'monthly') discount = 0.4;

    let priceAfterDiscount = props.basePrice * (1 - discount);
    if (subsidyApplied.value) priceAfterDiscount *= (1 - subsidyPercent);

    perDayPrice.value = Math.round(priceAfterDiscount);
    let shipping = plan.value === 'daily' ? shippingDaily : shippingShared;
    totalPrice.value = perDayPrice.value * selectedDates.value.length + shipping;
}

// Cell styles (including Thu/Fri disable)
function cellClass(day) {
    const disabled = day.weekdaySatIndex === 4 || day.weekdaySatIndex === 5;
    if (disabled) return 'bg-gray-100 text-gray-400 cursor-not-allowed border border-gray-200';
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

onMounted(() => {
    generateDaysFromToday();
    window.addEventListener('scroll', handleScroll);
});
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});



</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity .25s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
