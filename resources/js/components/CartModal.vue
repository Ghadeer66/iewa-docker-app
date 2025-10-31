<template>
    <div class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="emit('close')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b">
                    <div class="text-lg font-bold">سبد خرید</div>
                    <button @click="emit('close')" class="text-gray-600 hover:text-black" aria-label="close">✕</button>
                </div>
                <div class="max-h-[80vh] overflow-y-auto p-6">
                    <div v-if="items.length === 0" class="text-gray-600">سبد خرید خالی است.</div>
                    <div v-else class="space-y-4">
                        <div v-for="group in grouped" :key="group.key" class="border rounded-xl p-5 flex gap-5 items-center">
                            <img :src="group.mealImage || '/images/default-meal.png'" alt="meal" class="w-20 h-20 rounded object-cover" />
                            <div class="flex-1">
                                <div class="font-semibold">{{ group.mealTitle }}</div>
                                <div class="text-sm text-gray-600">تاریخ: {{ group.dateISO }}</div>
                                <div class="text-sm text-gray-600">تعداد: {{ group.count }}</div>
                                <div class="text-sm text-gray-600">قیمت واحد: {{ numberFormat(group.price) }} تومان</div>
                                <div class="text-sm font-bold">جمع: {{ numberFormat(group.count * group.price) }} تومان</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button @click="removeOne(group)" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200 text-sm">کاهش یکی</button>
                                <button @click="removeAll(group)" class="px-3 py-1 rounded bg-red-100 hover:bg-red-200 text-sm text-red-700">حذف همه</button>
                            </div>
                        </div>
                        <div class="mt-2 text-right text-xl font-extrabold">مجموع کل: {{ numberFormat(grandTotal) }} تومان</div>
                    </div>
                </div>
                <div class="px-5 py-4 border-t flex justify-end gap-3">
                    <button @click="emit('close')" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">بستن</button>
                    <button class="px-4 py-2 rounded-lg bg-[#4e3356] text-white hover:opacity-90">ادامه پرداخت</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { storeToRefs } from 'pinia'
import { computed } from 'vue'
import { useCartStore } from '@/stores/cart'

const emit = defineEmits(['close'])

const cart = useCartStore()
const { items } = storeToRefs(cart)

const numberFormat = (n) => n.toLocaleString('fa-IR')

const grouped = computed(() => {
    const map = new Map()
    for (const it of items.value) {
        const key = `${it.mealId}__${it.dateISO}__${it.price}`
        if (!map.has(key)) {
            map.set(key, { key, mealId: it.mealId, mealTitle: it.mealTitle, mealImage: it.mealImage, dateISO: it.dateISO, price: it.price, count: 0 })
        }
        map.get(key).count += 1
    }
    return Array.from(map.values())
})

const grandTotal = computed(() => grouped.value.reduce((sum, g) => sum + g.count * g.price, 0))

function removeOne(g) {
    cart.removeOne(g.mealId, g.dateISO, g.price)
}
function removeAll(g) {
    cart.removeGroup(g.mealId, g.dateISO, g.price)
}
</script>


