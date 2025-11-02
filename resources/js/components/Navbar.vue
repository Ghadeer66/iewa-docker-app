<template>
    <nav class=" shadow-md bg-white py-7">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- logo + nav links grouped together -->
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

            <div class="flex items-center gap-3 rtl:gap-reverse">
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
                            <span v-if="cartCount > 0" class="absolute -top-2 -left-2 bg-red-600 text-white text-[10px] leading-none px-2 py-1 rounded-full">
                                {{ cartCountFormatted }}
                            </span>
                        </button>
                        <Link href="/profile"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-[#3e4095] bg-white border border-[#3e4095] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition hover:bg-[#3e4095] hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                            <path d="M2 20a10 10 0 1120 0H2z" />
                        </svg>
                        ایوا من
                        </Link>

                        <button @click.prevent="logout"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-white bg-black text-center shadow hover:bg-[#222] transform hover:-translate-y-0.5 transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            خروج
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </nav>
    <CartModal v-if="showCart" @close="showCart = false" />
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import { useCartStore } from '@/stores/cart'
import CartModal from '@/components/CartModal.vue'

const props = defineProps({
  cartIsOpen: {
    type: Boolean,
    default: false
  }
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
  set: (val) => emit('update:cartIsOpen', val)
})

const logout = () => {
    router.post('/logout')
}

</script>
