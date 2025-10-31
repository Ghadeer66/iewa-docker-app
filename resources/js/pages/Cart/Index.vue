<template>
    <Layout>
        <section class="container mx-auto px-6 py-10 text-right">
            <h1 class="text-2xl font-bold mb-6">سبد خرید</h1>
            <div v-if="items.length === 0" class="text-gray-600">سبد خرید خالی است.</div>
            <div v-else class="space-y-4">
                <div v-for="group in grouped" :key="group.key" class="border rounded-lg p-4">
                    <div class="font-semibold mb-2">{{ group.mealTitle }} — {{ group.dateISO }}</div>
                    <div class="text-sm text-gray-700">تعداد: {{ group.count }}</div>
                    <div class="text-sm text-gray-700">قیمت واحد: {{ numberFormat(group.price) }} تومان</div>
                    <div class="text-sm font-bold">جمع: {{ numberFormat(group.count * group.price) }} تومان</div>
                </div>
                <div class="mt-6 text-xl font-extrabold">مجموع کل: {{ numberFormat(grandTotal) }} تومان</div>
            </div>
        </section>
    </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import { storeToRefs } from 'pinia'
import { computed } from 'vue'
import { useCartStore } from '@/stores/cart'

const cart = useCartStore()
const { items } = storeToRefs(cart)

const numberFormat = (n) => n.toLocaleString('fa-IR')

const grouped = computed(() => {
    const map = new Map()
    for (const it of items.value) {
        const key = `${it.mealId}__${it.dateISO}__${it.price}`
        if (!map.has(key)) {
            map.set(key, { key, mealId: it.mealId, mealTitle: it.mealTitle, dateISO: it.dateISO, price: it.price, count: 0 })
        }
        map.get(key).count += 1
    }
    return Array.from(map.values())
})

const grandTotal = computed(() => grouped.value.reduce((sum, g) => sum + g.count * g.price, 0))
</script>


