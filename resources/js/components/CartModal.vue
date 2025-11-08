<template>
  <div class="fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="emit('close')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-2 md:p-6">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md md:max-w-5xl overflow-hidden max-h-[95vh]">

        <!-- Header -->
        <div class="flex items-center justify-between px-3 md:px-5 py-3 md:py-4 border-b">
          <div class="text-base md:text-lg font-bold">سبد خرید</div>
          <button @click="emit('close')" class="text-gray-600 hover:text-black cursor-pointer text-xl md:text-2xl" aria-label="close">✕</button>
        </div>

        <!-- Cart Body -->
        <div class="max-h-[70vh] md:max-h-[80vh] overflow-y-auto p-4 md:p-6">
          <div v-if="items.length === 0" class="text-gray-600 text-center py-8 text-sm md:text-base">
            سبد خرید خالی است.
          </div>

          <div v-else class="space-y-3 md:space-y-4">
            <div
              v-for="item in items"
              :key="item.id"
              class="border rounded-xl p-3 md:p-5 flex flex-col md:flex-row gap-3 md:gap-5 items-center md:items-center"
            >
              <img
                :src="item.mealImage || '/images/default-meal.png'"
                alt="meal"
                class="w-34 h-24 md:w-30 md:h-20 rounded object-cover flex-shrink-0"
              />
              <div class="flex-1 w-full">
                <div class="font-semibold text-sm md:text-base mb-1">{{ item.mealTitle }}</div>
                <div class="text-xs md:text-sm text-gray-600 mb-1">تاریخ: {{ item.dateISO }}</div>
                <div class="text-xs md:text-sm text-gray-600 mb-1">تعداد: {{ item.quantity }}</div>
                <div class="text-xs md:text-sm text-gray-600 mb-1">قیمت واحد: {{ numberFormat(item.price) }} تومان</div>
                <div class="text-sm md:text-base font-bold">جمع: {{ numberFormat(item.price * item.quantity) }} تومان</div>
              </div>

              <div class="flex flex-col gap-1 md:gap-2 w-full md:w-auto">
                <button
                  @click="removeOne(item.id)"
                  :disabled="pending && pending.includes(item.id)"
                  :class="[
                    'px-2 py-1.5 md:px-3 md:py-1 rounded text-xs md:text-sm w-full md:w-auto',
                    pending && pending.includes(item.id) ? 'bg-gray-100 opacity-50 cursor-wait' : 'bg-gray-100 hover:bg-gray-200 cursor-pointer'
                  ]"
                >
                  <span v-if="pending && pending.includes(item.id)">در حال پردازش...</span>
                  <span v-else>کاهش یکی</span>
                </button>
                <button
                  @click="removeAll(item.id)"
                  class="px-2 py-1.5 md:px-3 md:py-1 rounded bg-red-100 hover:bg-red-200 text-xs md:text-sm text-red-700 cursor-pointer w-full md:w-auto"
                >
                  حذف همه
                </button>
              </div>
            </div>

            <div class="mt-2 text-right text-lg md:text-xl font-extrabold">
              مجموع کل: {{ numberFormat(grandTotal) }} تومان
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="px-3 md:px-5 py-3 md:py-4 border-t flex flex-col sm:flex-row justify-end gap-2 md:gap-3">
          <button
            @click="confirmClearAll"
            class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 cursor-pointer text-sm w-full sm:w-auto"
          >
            حذف همه
          </button>
          <button
            @click="emit('close')"
            class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-gray-200 hover:bg-gray-300 cursor-pointer text-sm w-full sm:w-auto"
          >
            بستن
          </button>
          <button
            class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-[#4e3356] text-white hover:opacity-90 cursor-pointer text-sm w-full sm:w-auto"
          >
            ادامه پرداخت
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { computed, onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'

const emit = defineEmits(['close'])

const cart = useCartStore()
const { items, pending } = storeToRefs(cart)

const numberFormat = (n) => n.toLocaleString('fa-IR')

const grandTotal = computed(() => {
  return items.value.reduce((sum, i) => sum + i.price * i.quantity, 0)
})

// Load cart on mount
onMounted(() => {
  cart.loadCart()
})

function removeOne(id) {
  if (pending && pending.value && pending.value.includes(id)) return
  cart.removeOne(id)
}

function removeAll(id) {
  cart.removeAll(id)
}

function confirmClearAll() {
  if (!items.value || items.value.length === 0) return
    if (confirm('آیا مطمئن هستید که می‌خواهید تمام سبد را خالی کنید؟')) {
      cart.clearAll()
      emit('close')
    }
}
</script>
