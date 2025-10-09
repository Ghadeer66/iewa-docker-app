<template>
  <nav class="bg-black shadow-md py-4">
    <div class="container mx-auto flex justify-between items-center px-6">
      <!-- logo + nav links grouped together -->
      <div class="flex items-center gap-6">
        <!-- logo image instead of text; uses storage path -->
        <Link href="/" class="inline-flex items-center gap-3">
          <img src="/storage/images/icone.png" alt="اوا" class="h-10 w-10 object-contain" />
        </Link>

        <ul class="hidden md:flex gap-6 text-white text-sm items-center">
          <li><Link href="/" class="hover:text-[#ffa800]">صفحه اصلی</Link></li>
          <li><Link href="/menu" class="hover:text-[#ffa800]">منو</Link></li>
          <li><Link href="/packages" class="hover:text-[#ffa800]">پکیج‌ها</Link></li>
          <li><Link href="/about" class="hover:text-[#ffa800]">درباره ما</Link></li>
          <li><Link href="/contact" class="hover:text-[#ffa800]">تماس با ما</Link></li>
        </ul>
      </div>

      <div class="flex items-center gap-3 rtl:gap-reverse">
        <!-- Auth buttons for guests -->
        <template v-if="!user">
          <Link
            href="/login"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-[#ffa800] bg-white border border-[#ffd58a] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition transform"
            aria-label="ورود"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0l-4-4m4 4l-4 4M21 12v7a2 2 0 01-2 2H7" />
            </svg>
            ورود
          </Link>

          <Link
            href="/register"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#ffa800] shadow-md hover:bg-[#e08f00] transform hover:-translate-y-0.5 transition"
            aria-label="ثبت نام"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14v7" />
            </svg>
            ثبت نام
          </Link>
        </template>

        <!-- User panel when authenticated -->
        <template v-else>
          <div class="flex items-center gap-3">
            <Link href="/dashboard" class="text-sm text-black hover:underline">سلام، <span class="font-medium text-[#ffa800]">{{ user.name }}</span></Link>
            <button
              @click.prevent="logout"
              class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-white bg-black shadow hover:bg-[#222] transform hover:-translate-y-0.5 transition"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
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
