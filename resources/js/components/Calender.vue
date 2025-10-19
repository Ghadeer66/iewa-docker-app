<template>
  <div dir="rtl" class="relative">
    <!-- Floating Button -->
    <button
      @click="open = true"
      :class="[
        'fixed top-3/5 transform -translate-y-1/2 transition-all duration-700 z-50 cursor-pointer shadow-lg flex items-center justify-center font-bold text-white left-0',
        isAtTop
          ? 'px-6 py-3 rounded-r-xl text-base bg-[#4e3356]'
          : 'px-4 py-2 rounded-r-xl text-sm opacity-70 bg-[#4e3356] hover:px-6 hover:py-3 hover:text-base hover:opacity-100'
      ]"
    >
      <span>
        {{ isAtTop ? 'انتخاب روز در تقویم' : 'تقویم من' }}
      </span>
    </button>

    <!-- Back message -->
    <transition name="fade">
      <div
        v-if="backMessageVisible"
        class="fixed top-70 left-1/2 transform -translate-x-1/2 bg-orange-500 text-white px-6 py-4 rounded shadow-lg z-50"
      >
        خرید شما با موفقیت در تقویم رزرو شد
      </div>
    </transition>

    <!-- Modal -->
    <div
      v-if="open"
      class="fixed inset-0 flex items-center justify-center backdrop-blur-md bg-white/30 z-50"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl max-w-4xl w-11/12 p-6 relative overflow-y-auto max-h-[85vh] flex gap-6"
      >
        <!-- Back button -->
        <button
          @click="handleBackClick"
          class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl cursor-pointer"
          aria-label="Return"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 inline"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8l4 4-4 4m4-4H8" />
          </svg>
        </button>

        <!-- Left: Calendar -->
        <div class="flex-1">
          <h2 class="text-2xl font-bold mb-4 text-center">انتخاب روز در تقویم کاری</h2>
          <p class="mb-2 text-gray-700">
            انتخاب روز مشخص برای خرید محصولات در سایت ایوا.
          </p>

          <div class="max-w-lg mx-auto mb-4">
            <!-- Weekday labels -->
            <div
              class="grid grid-cols-5 gap-1 text-xs font-bold text-gray-600 mb-2 text-center"
            >
              <div v-for="label in weekdayLabels" :key="label">{{ label }}</div>
            </div>

            <!-- Weeks -->
            <div
              v-for="(week, wi) in monthDays"
              :key="wi"
              class="grid grid-cols-5 gap-2 mb-3"
            >
              <div
                v-for="day in week"
                :key="day.fullDate"
                @click="() => handleDayClick(day)"
                :class="cellClass(day)"
                class="w-14 h-14 rounded-sm relative transition-colors select-none cursor-pointer group"
              >
                <!-- Top-right filled cart icon on the corner line -->
                <div class="absolute -top-3 -right-2 flex flex-col items-center">
                  <span
                    class="text-center text-red-500 text-[12px] font-bold rounded-full leading-none"
                  >
                    5
                  </span>

                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-6 h-6 text-black drop-shadow-sm"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M2.25 2.25a.75.75 0 000 1.5h1.636l1.808 8.138a2.25 2.25 0 002.202 1.762h9.743a2.25 2.25 0 002.15-1.61l1.605-5.743A.75.75 0 0021 5.25H6.832l-.3-1.35A2.25 2.25 0 004.5 2.25H2.25zm16.5 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-9 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>

                <!-- Center number -->
                <div
                  class="absolute inset-0 flex items-center justify-end ml-1.5 text-sm font-bold text-gray-900"
                >
                  5
                </div>

                <!-- Footer -->
                <div
                  class="absolute bottom-0 left-0 w-full bg-gray-200 text-[10px] font-bold text-gray-800 text-center rounded-b-sm flex items-center justify-center"
                >
                  <span v-if="!day.isToday">{{ day.jDate }}</span>
                  <span v-else class="text-blue-500 text-[10px]">امروز</span>
                </div>
              </div>
            </div>
          </div>

          <div
            v-if="selectedDates.length > 0"
            class="text-center text-sm text-gray-600 mb-2"
          >
            روزهای انتخاب شده: {{ selectedDates.length }} روز
          </div>
        </div>

        <!-- Right: Summary Column -->
        <div class="w-64 flex flex-col items-stretch">
          <div
            class="h-[400px] rounded-xl p-4 text-white flex flex-col items-center justify-center text-center transition-all duration-500"
            :class="planColorClass"
          >
            <div>
              <div class="text-sm opacity-90">نوع خرید</div>
              <div class="font-bold text-lg mt-1">{{ planTitle }}</div>
              <div class="mt-4 text-xs leading-relaxed">
                <div>
                  قیمت پایه (هر روز): {{ numberFormat(props.basePrice) }} تومان
                </div>
                <div class="mt-4" v-if="plan !== 'daily'">
                  تخفیف: {{ discountPercentText }}
                </div>
                <div class="mt-4" v-if="plan === 'daily'">تخفیف: ۰٪</div>
                <div class="mt-4 text-xl font-black">
                  {{ numberFormat(perDayPrice) }} تومان در روز
                </div>
                <div class="mt-4 text-lg">
                  مجموع: {{ numberFormat(totalPrice) }} تومان
                </div>
                <div class="mt-4" v-if="subsidyApplied">
                  این خرید شامل x% سوبسید شرکت است
                </div>
                <div class="mt-4" v-if="!subsidyApplied">
                  این خرید شامل x% سوبسید شرکت نیست
                </div>
              </div>
            </div>
          </div>
          <button
            class="mt-5 h-12 bg-gray-200 text-black rounded-lg font-bold hover:bg-orange-300 transition-colors cursor-pointer"
            @click="$emit('continue')"
          >
            ادامه خرید
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { toJalaali } from 'jalaali-js';

const props = defineProps({
  open: Boolean,
  basePrice: { type: Number, default: 200000 }
});

const emit = defineEmits(['update:open', 'continue']);

const open = computed({
  get: () => props.open,
  set: (val) => emit('update:open', val)
});

const isAtTop = ref(true);
const weekdayLabels = ['ش', 'ی', 'د', 'س', 'چ']; // Saturday–Wednesday

const selectedDates = ref([]);
const monthDays = ref([]);

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
function generateDaysFromToday(count = 30) {
  const days = [];
  let cur = new Date();

  for (let i = 0; i < count; i++) {
    const weekdaySatIndex = (cur.getDay() + 1) % 7; // 0=Sat
    if (weekdaySatIndex < 5) { // Only Sat–Wed
      const j = toJalaali(cur.getFullYear(), cur.getMonth() + 1, cur.getDate());
      days.push({
        gDate: new Date(cur),
        fullDate: cur.toISOString().split('T')[0],
        jDate: j.jd,
        jMonth: j.jm,
        jYear: j.jy,
        isToday: i === 0,
        isSelected: false,
        weekdaySatIndex
      });
    }
    cur.setDate(cur.getDate() + 1);
  }

  const weeks = [];
  for (let i = 0; i < days.length; i += 5) {
    weeks.push(days.slice(i, i + 5));
  }
  monthDays.value = weeks;
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

// Handle day click with mutual exclusion
function handleDayClick(day) {
  const iso = day.fullDate;
  const dayType = getDayType(day);

  if (dayType === 'afterTomorrow') {
    // deselect today/tomorrow
    selectedDates.value = selectedDates.value.filter(d => {
      const t = monthDays.value.flat().find(md => md.fullDate === d);
      const type = getDayType(t);
      return type !== 'today' && type !== 'tomorrow';
    });
  } else if (dayType === 'today' || dayType === 'tomorrow') {
    // cannot select if afterTomorrow selected
    const afterTomorrowSelected = selectedDates.value.some(d => {
      const t = monthDays.value.flat().find(md => md.fullDate === d);
      return getDayType(t) === 'afterTomorrow';
    });
    if (afterTomorrowSelected) return;
  }

  const idx = selectedDates.value.indexOf(iso);
  if (idx === -1) selectedDates.value.push(iso);
  else selectedDates.value.splice(idx, 1);

  monthDays.value.forEach((week) =>
    week.forEach((d) => (d.isSelected = selectedDates.value.includes(d.fullDate)))
  );

  evaluatePlanAndPricing();
}

// Evaluate plan and pricing
function evaluatePlanAndPricing() {
  perDayPrice.value = props.basePrice;
  totalPrice.value = 0;
  discountPercentText.value = '';
  subsidyApplied.value = false;

  if (selectedDates.value.length === 0) {
    plan.value = 'daily';
    planTitle.value = 'هیچ روزی انتخاب نشده';
    return;
  }

  const count = selectedDates.value.length;

  if (count >= 8) {
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

  let priceAfterDiscount = props.basePrice * (1 - discount);
  if (subsidyApplied.value) priceAfterDiscount *= (1 - subsidyPercent);

  perDayPrice.value = Math.round(priceAfterDiscount);
  const shipping = plan.value === 'daily' ? shippingDaily : shippingShared;
  totalPrice.value = perDayPrice.value * count + shipping;
}

// Cell class for highlighting
function cellClass(day) {
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

onMounted(() => {
  generateDaysFromToday();
  window.addEventListener('scroll', handleScroll);
});
onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

const backMessageVisible = ref(false);
function handleBackClick() {
  backMessageVisible.value = true;
  setTimeout(() => (backMessageVisible.value = false), 3000);
  open.value = false;
}
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
