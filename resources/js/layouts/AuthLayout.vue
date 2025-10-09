<script setup lang="ts">
// وارد کردن اجزا و تعریف props
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
  <!-- راست‌چین و زبان فارسی برای صفحات احراز هویت -->
  <div dir="rtl" lang="fa" class="font-vazir">
    <Navbar />

    <!-- پس‌زمینه سفید برای صفحات ثبت‌نام/ورود و رنگ برند برای متن -->
    <AuthLayout :title="title" :description="description" class="bg-white text-[#ffa800]">
      <slot />
    </AuthLayout>

    <Footer />
  </div>
</template>
