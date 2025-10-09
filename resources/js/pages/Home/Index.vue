<template>
  <Layout>
    <section class="relative bg-white py-16 text-center">
      <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold text-[#ffa800]-600 mb-4">
          تغذیه سالم، زندگی سالم
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto mb-6">
          اوا با ارائه غذاهای رژیمی و پکیج‌های متنوع به شما کمک می‌کند تا تناسب اندام و
          سلامتی خود را حفظ کنید.
        </p>
        <Link
          href="/menu"
          class="bg-[#ffa800]-500 text-white px-6 py-3 rounded-xl hover:bg-[#ffa800]-600 transition"
        >
          مشاهده منو
        </Link>
      </div>
    </section>

    <!-- Slideshow: uses meals prop -->
    <section class="container mx-auto px-6 py-10">
      <SlideShow :items="meals" image-key="image" title-key="title" />
    </section>

    <section class="container mx-auto px-6 py-16">
      <h2 class="text-3xl font-bold text-center mb-10">محبوب‌ترین غذاها</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <MealCard v-for="meal in meals" :key="meal.id" :meal="meal" />
      </div>
    </section>
  </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import MealCard from '@/components/MealCard.vue'
import { Link } from '@inertiajs/vue3'
import SlideShow from '@/components/Slideshow.vue'

defineProps({ meals: Array })
</script>
