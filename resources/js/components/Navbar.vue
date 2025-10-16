<template>
    <nav class=" shadow-md bg-white py-7">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- logo + nav links grouped together -->
            <div class="flex items-center gap-6">
                <!-- logo image instead of text; uses storage path -->
                <Link href="/" class="inline-flex items-center gap-3">
                <img src="/storage/images/icon.png" alt="اوا" class="h-10 w-10 object-contain" />
                </Link>

                <ul class="hidden md:flex gap-6 text-black text-sm items-center">
                    <li>
                        <Link href="/" class="hover:text-blue-300"> خانه </Link>
                    </li>
                    <li>
                        <Link href="/menu" class="hover:text-blue-300">محصولات</Link>
                    </li>
                    <li>
                        <Link href="#" class="hover:text-blue-300">درباره ما</Link>
                    </li>
                    <li>
                        <Link href="#" class="hover:text-blue-300"> بلاگ </Link>
                    </li>
                    <li>
                        <Link href="#" class="hover:text-blue-300">تماس با ما</Link>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 3h1.5l2.25 12.75a1.5 1.5 0 001.5 1.25h9a1.5 1.5 0 001.5-1.25L21.75 6H5.25" />
                        <circle cx="9" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>



                    </Link>

                    <Link href="/profile"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#3e4095] shadow-md hover:bg-yellow-400 transform hover:-translate-y-0.5 hover:text-black transition"
                        aria-label="ثبت نام">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM4 20c0-2.21 3.58-4 8-4s8 1.79 8 4" />
                    </svg>

                    ایوا من </Link>
                </template>

                <!-- User panel when authenticated -->
                <template v-else>
                    <div class="flex items-center gap-3">
                        <Link href="/dashboard" class="text-sm text-black hover:underline">سلام، <span
                            class="font-medium text-[#ffa800]">{{ user.name }}</span></Link>
                        <button @click.prevent="logout"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-white bg-black shadow hover:bg-[#222] transform hover:-translate-y-0.5 transition">
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
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

// guard against undefined props during initial render / SSR
const page = usePage()
const user = computed(() => page.props?.value?.auth?.user ?? null)

const logout = () => {
    router.post('/logout')
}
</script>
