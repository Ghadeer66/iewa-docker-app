```vue
<template>
    <Transition name="modal">
        <div v-if="showModal"
            class="fixed inset-0 flex items-center justify-center z-[100] backdrop-blur-md bg-black/30"
            @click.self="closeModal">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-11/12 max-h-[90vh] overflow-y-auto p-4 md:p-8 relative transform transition-all"
                dir="rtl">
                <!-- Close Button -->
                <button @click="closeModal"
                    class="absolute top-2 left-2 md:left-4 text-gray-500 hover:text-gray-700 text-xl md:text-2xl font-bold cursor-pointer z-10"
                    aria-label="بستن">
                    ×
                </button>

                <!-- Header -->
                <div class="text-center mb-4 md:mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">خوش آمدید!</h2>
                    <p class="text-gray-600 text-sm md:text-base">راهنمای استفاده از سیستم</p>
                </div>

                <!-- Content -->
                <div class="space-y-4 md:space-y-6">
                    <!-- Section 1: Filter Groups -->
                    <div class="bg-blue-50 rounded-lg p-4 md:p-6 border-r-4 border-blue-500">
                        <h3 class="text-lg md:text-xl font-bold text-blue-700 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            منوی تغذیه ایوا
                        </h3>
                        <p class="text-gray-700 leading-relaxed text-sm md:text-base">
                            در صفحه محصولات، می‌توانید از دکمه‌های منو برای دسته‌بندی محصولات استفاده کنید:
                        </p>
                        <ul class="mt-3 space-y-2 text-gray-700 list-disc list-inside text-sm md:text-base">
                            <li><strong>همه:</strong> نمایش تمام محصولات.</li>
                            <li><strong>لاین غذای اقتصادی:</strong> غذاهای اقتصادی سلامت محور.</li>
                            <li><strong>پک میانوعده:</strong> پکیج‌های تغذیه سالم میانوعده.</li>
                            <li><strong>سالاد:</strong> انواع سالادها</li>
                            <li><strong>ساندویچ:</strong> ساندویچ‌ها</li>
                            <li><strong>کیک و نان:</strong> محصولات کیک و نان</li>
                            <li><strong>دمنوش و قهوه:</strong> نوشیدنی‌های گرم</li>
                            <li><strong>نوشیدنی:</strong> سایر نوشیدنی‌ها</li>
                            <li><strong>اوتمیل:</strong> محصولات اوتمیل</li>
                            <li><strong>صبحانه:</strong> وعده‌های صبحانه</li>
                            <li><strong>دسر‌ها:</strong> انواع دسر</li>
                        </ul>
                        <p class="mt-3 text-sm text-gray-600 text-xs md:text-sm">
                            با کلیک روی هر گروه فیلتر، فقط محصولات مربوط به آن دسته نمایش داده می‌شوند.
                        </p>
                    </div>

                    <!-- Section 2: Calendar Numbers -->
                    <div class="bg-green-50 rounded-lg p-4 md:p-6 border-r-4 border-green-500">
                        <h3 class="text-lg md:text-xl font-bold text-green-700 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            اعداد روی تقویم
                        </h3>
                        <p class="text-gray-700 leading-relaxed text-sm md:text-base mb-3 md:mb-4">
                            روی هر روز در تقویم، یک عدد در بالای آیکون سبد خرید نمایش داده می‌شود.
                        </p>
                        <div class="mt-3 bg-white rounded p-3 md:p-4 border border-green-200">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                <div class="flex-1 text-right">
                                    <p class="text-gray-700 font-medium mb-2 text-sm md:text-base">این عدد نشانگر:</p>
                                    <p class="text-gray-700 text-sm md:text-base">
                                        <strong>تعداد محصولاتی که قبلاً برای آن روز در سبد خرید شما ثبت شده‌اند.</strong>
                                    </p>
                                    <i><p class="text-sm text-gray-900 mt-2 text-xs md:text-sm">
                                        برای مثال، اگر عدد ۲ نمایش داده شود، یعنی شما قبلاً ۲ محصول برای آن روز انتخاب کرده‌اید.
                                    </p></i>
                                </div>
                                <div class="shrink-0 mt-2 md:mt-0">
                                    <img src="/images/day.png" alt="روز" class="w-32 md:w-38 h-auto" />
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-sm md:text-base mt-4 md:mt-6">
                            وسط هر روز در تقویم، یک عدد نمایش داده می‌شود.
                        </p>
                        <div class="mt-3 bg-white rounded p-3 md:p-4 border border-green-200">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                <div class="flex-1 text-right">
                                    <p class="text-gray-700 font-medium mb-2 text-sm md:text-base">این عدد نشانگر:</p>
                                    <p class="text-gray-700 text-sm md:text-base">
                                        <strong>تعداد همکاران شرکت شما که در این روز محصولی را خریداری کرده‌اند.</strong>
                                    </p>
                                    <i><p class="text-sm text-gray-900 mt-2 text-xs md:text-sm">
                                        برای مثال، اگر عدد ۲۵ نمایش داده شود، یعنی ۲۵ کاربر از شرکت شما در این روز محصولی را خریداری کرده‌اند.
                                    </p></i>
                                </div>
                                <div class="shrink-0 mt-2 md:mt-0">
                                    <img src="/images/day-center.png" alt="روز - مرکز" class="w-32 md:w-38 h-auto" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Price Calculation -->
                    <div class="bg-purple-50 rounded-lg p-4 md:p-6 border-r-4 border-purple-500">
                        <h3 class="text-lg md:text-xl font-bold text-purple-700 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            محاسبه قیمت کل
                        </h3>
                        <p class="text-gray-700 leading-relaxed mb-3 md:mb-4 text-sm md:text-base">
                            قیمت کل بر اساس تعداد روزهای انتخابی و نوع پلن محاسبه می‌شود:
                        </p>

                        <div class="space-y-3">
                            <!-- Daily Plan -->
                            <div class="bg-white rounded p-3 md:p-4 border border-purple-200">
                                <h4 class="font-bold text-red-600 mb-2 text-sm md:text-base">خرید روزانه (انتخاب ۱ یا ۲ روز)</h4>
                                <p class="text-sm text-gray-700 text-xs md:text-sm">
                                    با انتخاب ۱ یا ۲ روز،  تخفیف و سوبسید  به خرید شما تعلق نمی‌گیرد.
                                </p>
                            </div>

                            <!-- Weekly Plan -->
                            <div class="bg-white rounded p-3 md:p-4 border border-purple-200">
                                <h4 class="font-bold text-green-600 mb-2 text-sm md:text-base">خرید هفتگی (۳ روز یا بیشتر)</h4>
                                <p class="text-sm text-gray-700 text-xs md:text-sm">
                                    با انتخاب ۳ روز یا بیشتر، <strong>۲۰٪ تخفیف</strong> و <strong>سوبسید شرکت</strong>  به خرید شما تعلق می‌گیرد.
                                </p>
                            </div>

                            <!-- Monthly Plan -->
                            <div class="bg-white rounded p-3 md:p-4 border border-purple-200">
                                <h4 class="font-bold text-purple-600 mb-2 text-sm md:text-base">
                                    خرید ماهانه (حداقل ۸ روز در ۴ هفته متوالی)
                                </h4>
                                <p class="text-sm text-gray-700 text-xs md:text-sm">
                                    با انتخاب ۸ روز یا بیشتر،  <strong>۴۰٪ تخفیف</strong> و <strong>سوبسید شرکت</strong>  به خرید شما تعلق می‌گیرد.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 bg-white rounded p-3 md:p-4 border border-purple-200">
                            <p class="text-gray-700 font-medium mb-2 text-sm md:text-base">فرمول محاسبه:</p>
                            <p class="text-sm md:text-base">قیمت مصرف‌کننده - سوبسید شرکت - تخفیف پلن (هفتگی/ ماهانه) + هزینه ارسال</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 md:mt-8 flex justify-center">
                    <button @click="closeModal"
                        class="px-6 md:px-8 py-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600 transition-colors cursor-pointer shadow-md hover:shadow-lg text-sm md:text-base">
                        فهمیدم، متشکرم
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth?.user || null

const showModal = ref(false)

const STORAGE_KEY = `menu_intro_seen_${user?.id}`

onMounted(() => {
    // Only show for registered users
    if (!user) {
        return
    }

    // Check if user has seen the introduction
    const hasSeen = localStorage.getItem(STORAGE_KEY)
    if (!hasSeen) {
        // Show modal after a short delay for better UX
        setTimeout(() => {
            showModal.value = true
        }, 500)
    }
})

const closeModal = () => {
    showModal.value = false
    // Mark as seen in localStorage
    localStorage.setItem(STORAGE_KEY, 'true')
}
</script>

<style scoped>
/* Backdrop blur */
.backdrop-blur-md {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Modal transition animations */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-active > div,
.modal-leave-active > div {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from > div,
.modal-leave-to > div {
    transform: scale(0.9) translateY(-20px);
    opacity: 0;
}

.modal-enter-to > div,
.modal-leave-from > div {
    transform: scale(1) translateY(0);
    opacity: 1;
}
</style>

