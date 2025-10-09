<template>
    <footer class="relative bg-gray-300 text-black">
        <!-- Back to top arrow -->
        <button @click="scrollToTop"
            class="absolute -top-5 left-1/2 -translate-x-1/2 bg-black text-white rounded-full p-4 shadow-md hover:bg-gray-800 hover:-translate-y-1 transition cursor-pointer">
            ▲
        </button>


        <div class="container mx-auto px-4 py-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="/storage/images/icone.png" alt="اوا" class="h-15 w-15 object-contain" />
                <div>
                    <p class="text-mid text-gray-900">تغذیه سالم برای زندگی بهتر</p>
                </div>
            </div>

            <ul class="flex justify-center items-center gap-6 my-6 text-sm text-black text-center">
                <li>
                    <Link href="/" class="text-black hover:underline">خانه</Link>
                </li>
                <li>
                    <Link href="/menu" class="text-black hover:underline">محصولات</Link>
                </li>
                <li>
                    <Link href="/packages" class="text-black hover:underline">درباره ما</Link>
                </li>
                <li>
                    <Link href="/about" class="text-black hover:underline">وبلاگ</Link>
                </li>
                <li>
                    <Link href="/contact" class="text-black hover:underline">تماس با ما</Link>
                </li>
            </ul>


            <div class="text-sm text-black text-center">
                <p>تماس: <a href="tel:+98XXXXXXXXXX" class="hover:underline">+98XXXXXXXXXX</a></p>
                <p class="mt-1">آدرس: اصفهان، ایران</p>
            </div>
        </div>

        <div class="border-t border-white/10 text-center py-4 text-sm text-white bg-black">
            © <span>{{ year }}</span> . تمامی حقوق محفوظ است.
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const year = ref(new Date().getFullYear())

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}
</script>

<style scoped>
a {
    color: black;
}
</style>
