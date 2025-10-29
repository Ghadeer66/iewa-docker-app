<template>
    <Layout>
      <section class="container mx-auto px-6 py-12 text-right rtl">
        <!-- Header -->
        <div class="text-center mb-12">
          <h1 class="text-4xl font-extrabold text-gray-900 mb-3">تماس با ما</h1>
          <p class="text-gray-600 text-sm">در هر زمان آماده پاسخ‌گویی به سوالات و درخواست‌های شما هستیم.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Contact Cards -->
          <div class="lg:col-span-1 flex flex-col gap-4">
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
              <h2 class="text-lg font-semibold mb-4 text-gray-900">راه‌های ارتباطی</h2>
              <ul class="space-y-3 text-gray-700 text-sm">
                <li class="flex items-center justify-between">
                  <span>پشتیبانی:</span>
                  <a href="tel:+989027383170" class="text-blue-600 hover:underline "> 3170 738 902 (98+)   </a>
                </li>
                <li class="flex items-center justify-between">
                  <span>تلفن ثابت:</span>
                  <a href="tel:03136517007" class="text-blue-600 hover:underline">031-36517007</a>
                </li>
                <li class="flex items-center justify-between">
                  <span>واتس‌اپ:</span>
                  <a href="https://wa.me/989027383170" target="_blank" rel="noopener" class="text-green-600 hover:underline">چت در واتس‌اپ</a>
                </li>
                <li class="flex items-center justify-between">
                  <span>ایمیل:</span>
                  <a href="mailto:info@iewato.ir" class="text-blue-600 hover:underline">info@iewato.ir</a>
                </li>
              </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
              <h2 class="text-lg font-semibold mb-4 text-gray-900">آدرس ما</h2>
              <p class="text-gray-700 text-sm leading-relaxed">
                ایران، اصفهان، خیابان کهندژ، کوچه ۱۱۹، بلاک ۱۴
              </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap gap-2 justify-end">
              <a href="tel:+989027383170" class="px-4 py-2 rounded-xl bg-black text-white hover:bg-gray-800 transition">تماس</a>
              <a href="https://wa.me/989027383170" target="_blank" rel="noopener" class="px-4 py-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition">واتس‌اپ</a>
              <a href="mailto:info@iewato.ir" class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">ایمیل</a>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-8 space-y-6 hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">ارسال پیام</h2>
            <form class="space-y-4" @submit.prevent="submit">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <input v-model="form.name" type="text" placeholder="نام کامل" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                  <p v-if="form.errors.name" class="mt-1 text-red-600 text-xs">{{ form.errors.name }}</p>
                </div>
                <div>
                  <input v-model="form.email" type="email" placeholder="ایمیل" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                  <p v-if="form.errors.email" class="mt-1 text-red-600 text-xs">{{ form.errors.email }}</p>
                </div>
              </div>
              <div>
                <textarea v-model="form.message" placeholder="پیام شما..." rows="5" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
                <p v-if="form.errors.message" class="mt-1 text-red-600 text-xs">{{ form.errors.message }}</p>
              </div>
              <button type="submit" :disabled="form.processing" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-60">
                ارسال پیام
              </button>
              <p v-if="$page.props.flash?.success" class="text-green-700 text-sm text-center">{{$page.props.flash.success}}</p>
            </form>
          </div>
        </div>

        <!-- Map -->
        <div class="mt-12 rounded-2xl overflow-hidden shadow-lg h-96">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d209.89423530844766!2d51.601605714878474!3d32.6778606181484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1760458930088!5m2!1sen!2s"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </section>
    </Layout>
  </template>

  <script setup>
  import Layout from '@/layouts/AppLayout.vue'
  import { useForm, router } from '@inertiajs/vue3'

  const form = useForm({
    name: '',
    email: '',
    message: '',
  })

  const submit = () => {
    form.post('/contact', {
      onSuccess: () => {
        form.reset('name', 'email', 'message')
      },
    })
  }
  </script>

  <style scoped>
  .rtl {
    direction: rtl;
  }
  </style>
