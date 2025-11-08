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
                        روزهای انتخاب شده: {{ totalSelectedDaysCount }}  روز
                    </div>
                </div>

                <!-- Right: Summary Column -->
                <div class="w-full md:w-75 flex flex-col py-4 md:py-16 items-stretch">
                    <div class="h-64 md:h-[350px] rounded-xl p-3 md:p-4 text-white flex flex-col items-center justify-center text-center transition-all duration-500"
                        :class="planColorClass">
                        <div class="flex flex-col gap-2 md:gap-4 w-full">

                            <div class="font-bold text-base md:text-lg text-center mb-1 md:mb-2">{{ planTitle }}</div>

                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">قیمت محصول:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(props.basePrice) }} تومان</div>
                            </div>

                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">سوبسید شرکت:</div>
                                <div class="ml-4 md:ml-10">{{ subsidyPercentDisplay }}</div>
                            </div>

                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">تخفیف:</div>
                                <div class="ml-4 md:ml-10">{{ plan === 'daily' ? '۰٪' : discountPercentText }}</div>
                            </div>

                            <div class="flex justify-between w-full px-1 md:px-2 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">جمع:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(priceToPay) }} تومان</div>
                            </div>

                            <div class="flex justify-between w-full px-1 md:px-2 mt-3 md:mt-5 text-xs md:text-sm">
                                <div class="font-medium text-right mr-2 md:mr-4">قابل پرداخت:</div>
                                <div class="ml-2 md:ml-6">{{ numberFormat(totalPrice) }} تومان</div>
                            </div>

                        </div>
                    </div>

                    <button
                        class="mt-4 md:mt-5 h-10 md:h-12 bg-gray-200 text-black rounded-lg font-bold hover:bg-orange-300 transition-colors cursor-pointer text-sm md:text-base"
                        @click="applySelections">
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

const baseWeekdayLabels = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'];
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

const existingDatesForMeal = computed(() => {
    const s = new Set();
    for (const it of items.value) {
        if (it.mealId === props.mealId) s.add(it.dateISO);
    }
    return s;
});

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
    const cur = start;

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

const totalSelectedDaysCount = computed(() => {
  if (!items.value) return selectedDates.value.length
  return Array.from(new Set([
    ...items.value.map(it => it.dateISO),
    ...selectedDates.value
  ])).length
})

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
  const iso = day.fullDate
  const idx = selectedDates.value.indexOf(iso)

  // Toggle clicked date
  if (idx === -1) {
    selectedDates.value.push(iso)
  } else {
    selectedDates.value.splice(idx, 1)
  }

  // Sync UI
  monthDays.value.forEach((week) =>
    week.forEach((d) => (d.isSelected = selectedDates.value.includes(d.fullDate)))
  )

  // Sort chronologically
  selectedDates.value.sort((a, b) => new Date(a) - new Date(b))

  // ---- Today+Tomorrow & Tomorrow+DayAfter Rule ----
  if (selectedDates.value.length >= 3) {
    const firstDay = new Date(selectedDates.value[0])
    const secondDay = new Date(selectedDates.value[1])
    const today = new Date()
    const tomorrow = new Date()
    tomorrow.setDate(today.getDate() + 1)
    const dayAfter = new Date()
    dayAfter.setDate(today.getDate() + 2)

    const oneDay = 24 * 60 * 60 * 1000

    let removeEarliest = false

    // Check Today + Tomorrow
    if (firstDay.toDateString() === today.toDateString() &&
        secondDay - firstDay === oneDay) {
      removeEarliest = true
    }

    // Check Tomorrow + DayAfter
    if (firstDay.toDateString() === tomorrow.toDateString() &&
        secondDay - firstDay === oneDay) {
      removeEarliest = true
    }

    if (removeEarliest) {
      const removedDate = selectedDates.value[0]
      selectedDates.value.splice(0, 1)

      // Update UI
      monthDays.value.forEach((week) =>
        week.forEach((d) => {
          if (d.fullDate === removedDate) d.isSelected = false
        })
      )

      // Remove from cart if exists
      const existingItem = items.value.find(
        it => it.mealId === props.mealId && it.dateISO === removedDate
      )
      if (existingItem) {
        cart.removeGroup(props.mealId, removedDate, existingItem.price)
      }
    }
  }

  evaluatePlanAndPricing()
}



/**
 * evaluatePlanAndPricing
 *
 * New approach:
 * - Build a projected cart state that reflects applying the modal's current selections:
 *   * existing items (items.value)
 *   * remove any existing item-dates for current meal that the user deselected in this modal
 *   * add new selections for current meal that are not already in cart
 * - Count the number of meal–date items in projected cart (each meal+date is a separate line)
 * - Build a set of unique dates that have >= 1 meal in projected cart (for monthly week coverage)
 * - Apply thresholds:
 *    - monthly: projectedItemsCount >= 8 && every week has at least one date selected
 *    - weekly: projectedItemsCount >= 3
 *    - otherwise daily
 */
function evaluatePlanAndPricing() {
    perDayPrice.value = props.basePrice;
    priceToPay.value = 0;
    totalPrice.value = 0;
    discountPercentText.value = '';
    subsidyApplied.value = subsidyRate.value > 0;

    // --- Build projected cart state (items after applying current modal selections) ---
    // 1) Map existing items to an array copy
    const existingItems = items.value.slice(); // shallow copy

    // 2) Get set of dates currently in cart for this meal
    const existingMealDates = new Set();
    for (const it of existingItems) {
        if (it.mealId === props.mealId) existingMealDates.add(it.dateISO);
    }

    // 3) Determine deselections: dates that are currently in cart for this meal but NOT in selectedDates
    let deselectedExistingCount = 0;
    for (const d of existingMealDates) {
        if (!selectedDates.value.includes(d)) {
            // user has removed this date for this meal in the modal
            deselectedExistingCount++;
        }
    }

    // 4) Determine additions: selected dates that are not already in the cart for this meal
    let incrementalAdditions = 0;
    for (const d of selectedDates.value) {
        if (!existingMealDates.has(d)) incrementalAdditions++;
    }

    // 5) Projected total meal–date items after applying changes:
    //    current cart size minus removed existing items plus newly added items
    const projectedItemsCount = existingItems.length - deselectedExistingCount + incrementalAdditions;

    // 6) Build projected set of unique dates that will have at least one meal
    const projectedDatesSet = new Set();
    // start with all existing item dates
    for (const it of existingItems) {
        projectedDatesSet.add(it.dateISO);
    }
    // remove dates that belong to existing meal and were deselected
    for (const d of existingMealDates) {
        if (!selectedDates.value.includes(d)) {
            // remove that date occurrence only for that meal: if other meals exist on that date,
            // projectedDatesSet should remain containing that date. So check if any remaining item (not removed)
            // would still carry that date — simpler approach: rebuild projectedDatesSet from projected items:
            // we'll instead rebuild explicitly below.
        }
    }
    // Instead of trying to surgically remove, rebuild projectedDatesSet from projected items:
    const projectedItems = [];
    // add all existing items except those that belong to this meal and were deselected
    for (const it of existingItems) {
        if (it.mealId === props.mealId) {
            // keep only if the date is still selected in modal
            if (selectedDates.value.includes(it.dateISO)) {
                projectedItems.push(it);
            }
        } else {
            // other meals remain unchanged
            projectedItems.push(it);
        }
    }
    // add newly selected dates for this meal (that weren't already present)
    for (const d of selectedDates.value) {
        if (!existingMealDates.has(d)) {
            // create a lightweight projected item (mealId + date) so dates get counted for week coverage
            projectedItems.push({
                mealId: props.mealId,
                dateISO: d
            });
        }
    }
    // now build set of unique dates
    for (const it of projectedItems) projectedDatesSet.add(it.dateISO);

    // --- Determine weeks coverage using projectedDatesSet ---
    const weeksWithAtLeastOne = new Set();
    monthDays.value.forEach((week, wi) => {
        const selInWeek = week.filter(d => projectedDatesSet.has(d.fullDate));
        if (selInWeek.length >= 1) weeksWithAtLeastOne.add(wi);
    });

    // --- Decide plan using projectedItemsCount and weeks coverage (keeps your original thresholds) ---
    let computedPlan = 'daily';
    if (projectedItemsCount >= 8 && weeksWithAtLeastOne.size === monthDays.value.length) {
        computedPlan = 'monthly';
    } else if (projectedItemsCount >= 3) {
        computedPlan = 'weekly';
    } else {
        computedPlan = 'daily';
    }

    // Apply plan UI & discounts
    plan.value = computedPlan;
    if (computedPlan === 'monthly') {
        planTitle.value = 'خرید ماهانه';
        discountPercentText.value = '۴۰٪';
        subsidyApplied.value = true;
    } else if (computedPlan === 'weekly') {
        planTitle.value = 'خرید هفتگی';
        discountPercentText.value = '۲۰٪';
        subsidyApplied.value = true;
    } else {
        planTitle.value = 'خرید روزانه';
        discountPercentText.value = 'بدون تخفیف';
        subsidyApplied.value = false;
    }

    let discount = 0;
    if (computedPlan === 'weekly') discount = 0.2;
    if (computedPlan === 'monthly') discount = 0.4;

    const priceAfterSubsidy = props.basePrice * (1 - (subsidyRate.value || 0));
    const priceAfterDiscount = priceAfterSubsidy * (1 - discount);
    perDayPrice.value = Math.round(priceAfterDiscount);

    // Show per-day payable and total for the current selection only (unchanged behavior)
    priceToPay.value = perDayPrice.value;
    totalPrice.value = perDayPrice.value * selectedDates.value.length;
}

/**
 * dayCountFor(dateISO)
 * returns number of meal selections on that date in the projected view (cart + current modal)
 */
function dayCountFor(dateISO) {
    const n = countsMap.value[dateISO] || 0;
    return n.toLocaleString('fa-IR');
}

function cellClass(day) {
    if (isThursdayOrFriday(day)) return 'bg-gray-200 text-gray-400 border border-gray-300';
    if (todayLocked.value && getDayType(day) === 'today') return 'bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed';
    if (tomorrowLocked.value && getDayType(day) === 'tomorrow') return 'bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed';

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
const checkMobile = () => { isMobile.value = window.innerWidth < 768; };

onMounted(async () => {
    generateDaysFromToday();
    window.addEventListener('scroll', handleScroll);
    checkMobile();
    window.addEventListener('resize', checkMobile);
    try {
        const { data } = await axios.get('/api/me/subsidy');
        const pct = Number(data?.percentage ?? 0);
        subsidyRate.value = !Number.isNaN(pct) && pct > 0 ? Math.min(Math.max(pct, 0), 100) / 100 : 0;
    } catch {
        subsidyRate.value = 0;
    }
    // clear visual selections initially
    selectedDates.value = [];
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)));
    evaluatePlanAndPricing();
});
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', checkMobile);
});

const backMessageVisible = ref(false);

function applySelections() {
    // Persist selections into cart store (this was your original handleBackClick behaviour)
    if (selectedDates.value.length > 0) {
        cart.addSelections(
            props.mealId,
            selectedDates.value.slice(),
            props.mealQuantity || 1,
        );
    }
    // reset modal selection UI
    selectedDates.value = [];
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)));
    evaluatePlanAndPricing();

    backMessageVisible.value = true;
    setTimeout(() => (backMessageVisible.value = false), 3000);
    open.value = false;
}

const handleBackClick = () => {
    if (selectedDates.value.length > 0) {
        // Use the correct per-day price (after subsidy/discounts)
        const finalPrice = perDayPrice.value

        // Add all selected dates for this meal to the cart
        cart.addSelections(
            props.mealId,
            selectedDates.value,
            props.mealQuantity || 1,
        )
    }

    // Close the calendar
    open.value = false

    // Show confirmation message
    backMessageVisible.value = true
    setTimeout(() => (backMessageVisible.value = false), 4000)
}



watch(() => props.mealId, () => {
    selectedDates.value = [];
    monthDays.value.forEach((week) => week.forEach((d) => (d.isSelected = false)));
    evaluatePlanAndPricing();
});
watch(items, () => evaluatePlanAndPricing());
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.6s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
