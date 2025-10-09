<template>
  <footer class="bg-black text-white">
    <div class="container mx-auto px-6 py-10 flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="flex items-center gap-3">
        <img src="/storage/images/icone.png" alt="اوا" class="h-10 w-10 object-contain" />
        <div>
          <p class="text-sm text-gray-300">تغذیه سالم برای زندگی بهتر</p>
        </div>
      </div>

      <ul class="flex flex-wrap gap-6 text-sm">
        <li><Link href="/" class="text-[#ffa800] hover:underline">صفحه اصلی</Link></li>
        <li><Link href="/menu" class="text-[#ffa800] hover:underline">منو</Link></li>
        <li><Link href="/packages" class="text-[#ffa800] hover:underline">پکیج‌ها</Link></li>
        <li><Link href="/about" class="text-[#ffa800] hover:underline">درباره ما</Link></li>
        <li><Link href="/contact" class="text-[#ffa800] hover:underline">تماس با ما</Link></li>
      </ul>

      <div class="text-sm text-gray-300">
        <p>تماس: <a href="tel:+98XXXXXXXXXX" class="text-[#ffa800] hover:underline">+98XXXXXXXXXX</a></p>
        <p class="mt-1">آدرس: اصفهان، ایران</p>
      </div>
    </div>

    <div class="border-t border-white/10 text-center py-4 text-sm text-gray-400">
      © <span>{{ year }}</span> . تمامی حقوق محفوظ است.
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const year = ref(new Date().getFullYear())
</script>

<style scoped>
/* ensure links use the brand color where needed */
a { color: #ffa800; }
</style>
