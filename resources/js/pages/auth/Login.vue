<template>
  <AuthBase>
    <div
      class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[380px] border border-white/20"
    >
      <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
        ورود به حساب ایوا
      </h1>

      <form @submit.prevent="login" class="space-y-5">
        <div>
          <label class="text-gray-300 text-sm mb-1 block">شماره همراه یا کد پرسنلی</label>
          <input
            type="text"
            v-model="form.phone"
            placeholder="09xxxxxxxxx یا کد پرسنلی"
            class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
            :class="{ 'border-red-500': errors.phone }"
          />
          <p v-if="errors.phone" class="text-red-400 text-xs mt-1">{{ errors.phone[0] }}</p>
        </div>

        <div class="relative">
          <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            placeholder="رمز خود را وارد کنید"
            class="w-full px-4 py-2 pr-10 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
            :class="{ 'border-red-500': errors.password }"
          />
          <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white"
          >
            {{ showPassword ? '🙈' : '👁️' }}
          </button>
          <p v-if="errors.password" class="text-red-400 text-xs mt-1">{{ errors.password[0] }}</p>
        </div>

        <div class="flex items-center">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
          />
          <label for="remember" class="mr-2 block text-sm text-gray-300">
            مرا به خاطر بسپار
          </label>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
          {{ error }}
        </div>

        <!-- Success Message - Fixed with safe navigation -->
        <div v-if="$page.props.flash?.message" class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-xl text-sm text-center">
          {{ $page.props.flash.message }}
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
        >
          <span v-if="loading">در حال ورود...</span>
          <span v-else>ورود</span>
        </button>

        <div class="flex justify-between text-sm mt-3 text-gray-400">
          <a href="/forgot-password" class="hover:text-lime-400 transition">رمز عبور را فراموش کرده‌اید؟</a>
          <a href="/register" class="hover:text-lime-400 transition">ثبت‌نام کنید</a>
        </div>
      </form>
    </div>
  </AuthBase>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthBase from '@/layouts/AuthLayout.vue'

const form = reactive({
  phone: '',
  password: '',
  remember: false
})

const loading = ref(false)
const error = ref('')
const errors = ref({})
const showPassword = ref(false)

const login = async () => {
  loading.value = true
  error.value = ''
  errors.value = {}

  try {
    await router.post('/login', form, {
      onSuccess: () => {
        // Login successful
        console.log('Login successful')
      },
      onError: (err) => {
        if (err.errors) {
          errors.value = err.errors
        }
        error.value = err.message || 'خطا در ورود. لطفا مجددا تلاش کنید.'
      },
      onFinish: () => {
        loading.value = false
      }
    })
  } catch (err) {
    error.value = 'خطا در ارتباط با سرور'
    loading.value = false
  }
}
</script>
