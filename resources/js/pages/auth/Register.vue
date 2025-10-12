<template>
  <AuthBase>
    <div
      class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[400px] border border-white/20"
    >
      <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
        ثبت‌نام در ایوا
      </h1>

      <form @submit.prevent="register" class="space-y-5">
        <div>
          <label class="text-gray-300 text-sm mb-1 block">نام کامل</label>
          <input
            type="text"
            v-model="name"
            placeholder="مثلاً علی رضایی"
            class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
          />
        </div>

        <div>
          <label class="text-gray-300 text-sm mb-1 block">شماره همراه</label>
          <input
            type="text"
            v-model="phone"
            placeholder="09xxxxxxxxx"
            class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
          />
        </div>

        <div>
          <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
          <input
            type="password"
            v-model="password"
            placeholder="رمز خود را انتخاب کنید"
            class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
          />
        </div>

        <button
          type="submit"
          class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition"
        >
          ثبت‌نام
        </button>

        <div class="text-center text-sm mt-3 text-gray-400">
          قبلاً حساب دارید؟
          <a href="/login" class="hover:text-lime-400">ورود</a>
        </div>
      </form>
    </div>
  </AuthBase>
</template>

<script setup>
import { ref } from 'vue'
import AuthBase from '@/layouts/AuthLayout.vue';

const name = ref('')
const phone = ref('')
const password = ref('')

function register() {
  alert(`Welcome, ${name.value}!`)
}
</script>
