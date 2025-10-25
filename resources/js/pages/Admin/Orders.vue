<template>
    <AdminAppLayout>
        <div>
            <h2 class="text-xl font-bold mb-6 text-yellow-400">مدیریت سفارش‌ها</h2>

            <!-- Orders List -->
            <div class="bg-gray-800 p-4 rounded">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b text-white border-gray-700">
                            <th class="p-2">کاربر</th>
                            <th class="p-2">غذا</th>
                            <th class="p-2">قیمت</th>
                            <th class="p-2">وضعیت</th>
                            <th class="p-2">تاریخ</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id" class="border-b border-gray-700 text-white">
                            <td class="p-2">{{ order.user?.name }}</td>
                            <td class="p-2">{{ order.meal?.name }}</td>
                            <td class="p-2">{{ order.total_price?.toLocaleString() }} تومان</td>
                            <td class="p-2">
                                <select :value="order.status" @change="updateOrderStatus(order.id, $event.target.value)"
                                    class="bg-gray-700 rounded text-white p-1 text-sm">
                                    <option value="pending">در انتظار</option>
                                    <option value="confirmed">تأیید شده</option>
                                    <option value="preparing">در حال آماده‌سازی</option>
                                    <option value="delivered">تحویل شده</option>
                                    <option value="cancelled">لغو شده</option>
                                </select>
                            </td>
                            <td class="p-2">{{ new Date(order.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td class="p-2">
                                <button @click="deleteOrder(order.id)" class="text-red-400 hover:text-red-600 cursor-pointer">
                                     🗑️
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminAppLayout>
</template>

<script setup>
import AdminAppLayout from '@/Layouts/AdminAppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    orders: Array
})

function updateOrderStatus(orderId, status) {
    router.patch(route('admin.orders.update', orderId), { status })
}

function deleteOrder(id) {
    if (confirm('آیا از حذف این سفارش مطمئن هستید؟')) {
        router.delete(route('admin.orders.destroy', id))
    }
}
</script>
