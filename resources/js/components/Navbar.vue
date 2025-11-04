<template>
    <nav class="relative shadow-md bg-white py-7">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <!-- Left: logo + desktop nav -->
                <div class="flex items-center gap-6">
                    <!-- logo image instead of text; uses storage path -->
                    <Link href="/" class="inline-flex items-center gap-3">
                    <img src="icon.png" alt="لوگوی ایوا - سفارش غذای سالم" class="h-10 w-10 object-contain" />
                    </Link>

                    <ul class="hidden md:flex gap-6 text-black text-sm items-center">
                        <li>
                            <Link href="/" class="hover:text-blue-300"> خانه </Link>
                        </li>
                        <li>
                            <Link href="/menu" class="hover:text-blue-300">محصولات</Link>
                        </li>
                        <li>
                            <Link href="/about-us" class="hover:text-blue-300">درباره ما</Link>
                        </li>

                        <li>
                            <Link href="#" class="hover:text-blue-300"> بلاگ </Link>
                        </li>
                        <li>
                            <Link href="/contact" class="hover:text-blue-300">تماس با ما</Link>
                        </li>
                        <li>
                            <Link href="#" class="hover:text-blue-300"> مشاوره </Link>
                        </li>
                    </ul>
                </div>

                <!-- Right: mobile hamburger + desktop auth/user -->
                <div class="flex items-center gap-3">
                    <!-- Mobile menu button -->
                    <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#3e4095] focus:ring-offset-2"
                        aria-label="Toggle mobile menu">
                        <!-- Simple hamburger SVG icon (you can replace with a more styled one) -->
                        <svg v-if="!mobileOpen" class="h-6 w-6 text-[#3e4095]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg v-else class="h-6 w-6 text-[#3e4095]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Desktop auth/user panel -->
                    <div class="hidden md:flex items-center gap-3 rtl:gap-reverse">
                        <!-- Auth buttons for guests -->
                        <template v-if="!user">
                            <Link href="/login"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-[#3e4095] bg-white border border-[#3e4095] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition transform"
                                aria-label="ورود">
                            ورود
                            </Link>

                            <Link href="/register"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#3e4095] shadow-md hover:bg-yellow-400 transform hover:-translate-y-0.5 hover:text-black transition"
                                aria-label="ثبت نام">
                            ثبت نام
                            </Link>
                        </template>

                        <!-- User panel when authenticated -->
                        <template v-else>
                            <div class="flex items-center gap-3">
                                <button @click.prevent="showCart = true"
                                    class="relative inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-[#3e4095] bg-purple border border-purple-500 shadow-sm hover:bg-purple-500 hover:text-white hover:shadow-md hover:-translate-y-0.5 transition cursor-pointer"
                                    aria-label="سبد خرید">
                                    <!-- License: MIT. Made by phosphor: https://github.com/phosphor-icons/phosphor-icons -->
                                    <svg fill="purple" width="20px" height="20px" viewBox="0 0 256 256" id="Flat"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M215.64941,133.00879l12.15723-66.86231A12.00043,12.00043,0,0,0,216,52H58.01514L53.72852,28.42285A19.99033,19.99033,0,0,0,34.05078,12H16a12,12,0,0,0,0,24H30.71289l26.4707,145.59229A31.98171,31.98171,0,1,0,110.9873,196h42.0254A32.00193,32.00193,0,1,0,184,172H79.833l-2.90918-16H188.10156A27.98561,27.98561,0,0,0,215.64941,133.00879ZM88,204a8,8,0,1,1-8-8A8.00917,8.00917,0,0,1,88,204Zm96,8a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,184,212ZM62.37891,76H201.62109l-9.585,52.71631A3.99708,3.99708,0,0,1,188.10156,132H72.56055Z" />
                                    </svg>
                                    <span v-if="cartCount > 0"
                                        class="absolute -top-2 -left-2 bg-red-600 text-white text-[10px] leading-none px-2 py-1 rounded-full">
                                        {{ cartCountFormatted }}
                                    </span>
                                </button>
                                <Link href="/profile"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-[#3e4095] bg-white border border-[#3e4095] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition hover:bg-[#3e4095] hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                                    <path d="M2 20a10 10 0 1120 0H2z" />
                                </svg>
                                ایوا من
                                </Link>

                                <button @click.prevent="logout"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-white bg-black text-center shadow hover:bg-[#222] transform hover:-translate-y-0.5 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                    </svg>
                                    خروج
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile dropdown menu -->
        <div v-if="mobileOpen"
            class="md:hidden absolute top-full left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-50">
            <ul class="flex flex-col gap-0 py-2 text-black text-sm">
                <li>
                    <Link href="/" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    خانه
                    </Link>
                </li>
                <li>
                    <Link href="/menu" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    محصولات
                    </Link>
                </li>
                <li>
                    <Link href="/about-us" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    درباره ما
                    </Link>
                </li>
                <li>
                    <Link href="#" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    بلاگ
                    </Link>
                </li>
                <li>
                    <Link href="/contact" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    تماس با ما
                    </Link>
                </li>
                <li>
                    <Link href="#" @click="mobileOpen = false"
                        class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                    مشاوره
                    </Link>
                </li>
            </ul>
            <div v-if="!user || user" class="border-t border-gray-200 mt-2 pt-2">
                <template v-if="!user">
                    <li>
                        <Link href="/login" @click="mobileOpen = false"
                            class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                        ورود
                        </Link>
                    </li>
                    <li>
                        <Link href="/register" @click="mobileOpen = false"
                            class="block px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                        ثبت نام
                        </Link>
                    </li>
                </template>
                <template v-else>
                    <li>
                        <button @click="() => { logout(); mobileOpen = false; }"
                            class="block w-full text-left px-6 py-3 hover:bg-gray-50 hover:text-blue-300 transition-colors">
                            خروج
                        </button>
                    </li>
                </template>
            </div>
        </div>
    </nav>

    <!-- Mobile bottom navigation bar -->
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="flex justify-around items-center py-3">

            <!-- Home -->
            <Link href="/"
                class="flex flex-col items-center gap-1 text-xs text-gray-600 hover:text-[#3e4095] transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>خانه</span>
            </Link>

            <!-- Products (first in HTML for RTL order) -->
            <Link href="/menu"
                class="flex flex-col items-center gap-1 text-xs text-gray-600 hover:text-[#3e4095] transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span>محصولات</span>
            </Link>



            <!-- Profile / Login -->
            <Link :href="user ? '/profile' : '/login'"
                class="flex flex-col items-center gap-1 text-xs text-gray-600 hover:text-[#3e4095] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                <path d="M2 20a10 10 0 1120 0H2z" />
            </svg>
            <span>ایوا من</span>
            </Link>

            <!-- Cart -->
            <button @click.prevent="showCart = true"
                class="relative flex flex-col items-center gap-1 text-xs text-gray-600 hover:text-[#3e4095] transition-colors"
                aria-label="سبد خرید">
                <svg fill="currentColor" width="20px" height="20px" viewBox="0 0 256 256"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M215.64941,133.00879l12.15723-66.86231A12.00043,12.00043,0,0,0,216,52H58.01514L53.72852,28.42285A19.99033,19.99033,0,0,0,34.05078,12H16a12,12,0,0,0,0,24H30.71289l26.4707,145.59229A31.98171,31.98171,0,1,0,110.9873,196h42.0254A32.00193,32.00193,0,1,0,184,172H79.833l-2.90918-16H188.10156A27.98561,27.98561,0,0,0,215.64941,133.00879ZM88,204a8,8,0,1,1-8-8A8.00917,8.00917,0,0,1,88,204Zm96,8a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,184,212ZM62.37891,76H201.62109l-9.585,52.71631A3.99708,3.99708,0,0,1,188.10156,132H72.56055Z" />
                </svg>
                <span>سبد</span>
                <span v-if="cartCount > 0"
                    class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] leading-none px-1 py-0.5 rounded-full">
                    {{ cartCountFormatted }}
                </span>
            </button>
        </div>
    </div>

    <CartModal v-if="showCart" @close="showCart = false" />
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import { useCartStore } from '@/stores/cart'
import CartModal from '@/components/CartModal.vue'

const props = defineProps({
    cartIsOpen: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['update:cartIsOpen'])

// guard against undefined props during initial render / SSR
const page = usePage()
const user = computed(() => page.props.auth?.user ?? null)
const cart = useCartStore()
const cartCount = computed(() => cart.count)
const cartCountFormatted = computed(() => cartCount.value.toLocaleString('fa-IR'))

const showCart = computed({
    get: () => props.cartIsOpen,
    set: (val) => emit('update:cartIsOpen', val),
})

const mobileOpen = ref(false)

const logout = () => {
    router.post('/logout')
}
</script>
