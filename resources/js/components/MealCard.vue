<template>
  <div
    class="meal-card bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col relative"
  >
    <!-- Image -->
    <div class="relative w-full bg-gray-100">
      <img
        :src="meal.image_url ?? (meal.image ? `/storage/${meal.image}` : '/images/placeholder.png')"
        :alt="meal.name || meal.title || 'meal'"
        class="w-full h-52 object-cover rounded-t-2xl"
      />
      <span
        v-if="meal.is_new"
        class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow"
      >
        جدید
      </span>
    </div>

    <!-- Content -->
    <div class="p-4 flex flex-col flex-grow">
      <h3 class="font-bold text-gray-800 text-lg mb-1 text-center">{{ meal.title }}</h3>
      <p class="text-gray-500 text-sm text-center mb-3 truncate">{{ meal.description }}</p>

      <div class="mt-auto">
        <!-- Price -->
        <div class="flex justify-center items-center gap-2 mb-3">
          <span class="text-sm text-gray-400">قیمت:</span>
          <span class="font-semibold text-green-600 text-base">{{ meal.price.toLocaleString() }} تومان</span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center gap-3">
          <button
            @click="openModal"
            class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-1 rounded-md text-sm hover:bg-yellow-200 transition cursor-pointer"
          >
            جزئیات بیشتر
          </button>

          <button
            @click="$emit('add-to-cart', meal)"
            :disabled="!isAuthenticated"
            :class="[
              'px-4 py-1 rounded-md text-sm transition',
              isAuthenticated
                ? 'bg-green-500 text-white hover:bg-green-600'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            ]"
          >
            سفارش
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Popup -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 flex items-center justify-center z-50 p-4 backdrop-blur-sm bg-white/30"
      @click="closeModal"
    >
      <div
        class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative"
        @click.stop
      >
        <!-- Close Button -->
        <button
          @click="closeModal"
          class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold z-10"
        >
          ×
        </button>

        <!-- Modal Content -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Left Column: Details -->
          <div class="space-y-4">
            <!-- Packaged Image -->
            <div class="relative rounded-xl overflow-hidden bg-gray-100">
              <img
                :src="meal.image_url ?? (meal.image ? `/storage/${meal.image}` : '/images/placeholder.png')"
                :alt="meal.title"
                class="w-full h-64 object-cover"
              />
              <span
                v-if="meal.is_new"
                class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow"
              >
                جدید
              </span>
            </div>

            <!-- Nutrition Label -->
            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="flex justify-between items-start mb-2">
                <span class="text-sm font-medium text-gray-700">اطلاعات تغذیه‌ای</span>
              </div>
              <div class="space-y-1 text-xs text-gray-600">
                <div class="flex justify-between">
                  <span>کالری</span>
                  <span>۶۰۰</span>
                </div>
                <div class="flex justify-between">
                  <span>پروتئین</span>
                  <span>۱۸.۲g</span>
                </div>
                <div class="flex justify-between">
                  <span>کربوهیدرات</span>
                  <span>۲۲.۹g</span>
                </div>
                <div class="flex justify-between">
                  <span>چربی</span>
                  <span>۴.۵g</span>
                </div>
              </div>
            </div>

            <!-- Quantity Selector -->
            <div class="flex items-center justify-center gap-4 p-3 border border-gray-200 rounded-lg">
              <button
                @click="decreaseQuantity"
                :disabled="quantity <= 1"
                :class="[
                  'w-8 h-8 rounded-full transition',
                  quantity > 1
                    ? 'bg-gray-200 text-gray-600 hover:bg-gray-300'
                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                ]"
              >
                -
              </button>
              <span class="text-lg font-semibold">{{ quantity }}</span>
              <button
                @click="increaseQuantity"
                class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition"
              >
                +
              </button>
            </div>

            <!-- Price -->
            <div class="flex justify-center items-center gap-2 text-center">
              <span class="text-sm text-gray-400">قیمت:</span>
              <span class="font-bold text-green-600 text-xl">{{ (meal.price * quantity).toLocaleString() }} تومان</span>
            </div>

            <!-- Actions -->
            <div class="flex justify-center">
              <button
                @click="$emit('add-to-cart', { ...meal, quantity }); closeModal()"
                :disabled="!isAuthenticated"
                class="w-full bg-green-500 text-white py-3 rounded-md text-sm font-medium hover:bg-green-600 transition disabled:bg-gray-300 disabled:cursor-not-allowed"
              >
                افزودن به سبد
              </button>
            </div>
          </div>

          <!-- Right Column: Full Meal Image and Nutrition Table -->
          <div class="space-y-4">

            <!-- Nutrition Table -->
            <div class="bg-gray-50 p-4 rounded-lg overflow-x-auto">
              <h4 class="text-sm font-semibold text-gray-800 mb-3 text-center">ارزش غذایی (در هر وعده)</h4>
              <table class="w-full text-xs text-gray-600">
                <thead>
                  <tr class="border-b border-gray-200">
                    <th class="text-right py-1 pr-2">مواد مغذی</th>
                    <th class="text-left py-1">مقدار</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-right py-1 pr-2">چربی</td>
                    <td class="text-left py-1">۱۳.۶g</td>
                  </tr>
                  <tr>
                    <td class="text-right py-1 pr-2">کربوهیدرات</td>
                    <td class="text-left py-1">۲۱.۴g</td>
                  </tr>
                  <tr>
                    <td class="text-right py-1 pr-2">پروتئین</td>
                    <td class="text-left py-1">۱۵.۸g</td>
                  </tr>
                  <tr>
                    <td class="text-right py-1 pr-2">فیبر</td>
                    <td class="text-left py-1">۴.۲g</td>
                  </tr>
                  <tr class="border-t border-gray-200 font-semibold">
                    <td class="text-right py-1 pr-2">کل کالری</td>
                    <td class="text-left py-1">۴۴۷ kcal</td>
                  </tr>
                </tbody>
              </table>
              <p class="text-xs text-gray-500 mt-2 text-right leading-relaxed">
                شامل: نمک، شکر، سس سویا، روغن کنجد، سس تند، برنج، سبزیجات، و غیره. ممکن است حاوی بادام زمینی باشد.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  meal: {
    type: Object,
    default: () => ({})
  },
  isAuthenticated: {
    type: Boolean,
    default: false
  }
})

const isModalOpen = ref(false)
const quantity = ref(1)

const openModal = () => {
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const increaseQuantity = () => {
  quantity.value++
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}
</script>
