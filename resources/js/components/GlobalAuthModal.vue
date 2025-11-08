<template>
  <!-- Global Auth Modal -->
  <div v-if="!$page.props.auth.user && showAuthModal"
       class="fixed inset-0 flex justify-center items-center bg-black/50 backdrop-blur-lg z-50 p-4">

    <!-- Registration Form -->
    <div v-if="!showLoginForm"
         class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 w-full max-w-[500px] md:max-w-[600px] lg:max-w-[700px] max-h-[90vh] overflow-y-auto p-6 no-scrollbar">

      <h1 class="text-2xl md:text-3xl text-center text-lime-300 font-semibold mb-6">
        فرم ثبت‌نام
      </h1>

      <form @submit.prevent="register" class="space-y-4">

        <!-- Full Name -->
        <div>
          <label class="text-gray-300 text-sm mb-1 block">نام کامل</label>
          <input type="text" v-model="form.name" placeholder="مثلاً علی رضایی"
                 pattern="^[\u0600-\u06FF\s]+$"
                 class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': errors.name || (form.name && !isValidName(form.name)) }" />
          <div class="text-xs mt-1">
            <p class="text-gray-400">فقط حروف فارسی مجاز است</p>
            <p v-if="form.name && !isValidName(form.name)" class="text-red-400">
              لطفاً فقط از حروف فارسی استفاده کنید (بدون اعداد و حروف انگلیسی)
            </p>
            <p v-if="errors.name" class="text-red-400">{{ errors.name[0] }}</p>
          </div>
        </div>

        <!-- Personal Code -->
        <div>
          <label class="text-gray-300 text-sm mb-1 block">کد پرسنلی</label>
          <input type="text" v-model="form.personal_code" placeholder="کد خود را وارد کنید"
                 class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': errors.personal_code }" />
          <p v-if="errors.personal_code" class="text-red-400 text-xs mt-1">{{ errors.personal_code[0] }}</p>
        </div>

        <!-- Phone -->
        <div>
          <label class="text-gray-300 text-sm mb-1 block">شماره تماس</label>
          <input type="tel" v-model="form.phone" placeholder="09123456789" pattern="09[0-9]{9}"
                 maxlength="11"
                 class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': errors.phone || (form.phone && !isValidPhone(form.phone)) }" />
          <div class="text-xs mt-1">
            <p class="text-gray-400">شماره تلفن باید ۱۱ رقم و با ۰۹ شروع شود</p>
            <p v-if="form.phone && !isValidPhone(form.phone)" class="text-red-400">
              لطفاً یک شماره معتبر وارد کنید (مثال: 09123456789)
            </p>
            <p v-if="errors.phone" class="text-red-400">{{ errors.phone[0] }}</p>
          </div>
        </div>

        <!-- Position -->
        <div>
          <label class="text-gray-300 text-sm mb-1 block">پوزیشن سازمان</label>
          <select v-model="form.position"
                  class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                  :class="{ 'border-red-500': errors.position }">
            <option value="" disabled selected>پوزیشن خود را انتخاب کنید</option>
            <option value="manager">مدیر</option>
            <option value="supervisor">سرپرست</option>
            <option value="employee">کارمند</option>
            <option value="operator">اپراتور</option>
          </select>
          <p v-if="errors.position" class="text-red-400 text-xs mt-1">{{ errors.position[0] }}</p>
        </div>

        <!-- Password -->
        <div class="relative">
          <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
          <input :type="showRegisterPassword ? 'text' : 'password'" v-model="form.password" placeholder="رمز عبور خود را وارد کنید"
                 class="w-full px-4 py-2 pr-10 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': errors.password || (form.password && !isValidPassword(form.password)) }" />
          <button
            type="button"
            @click="showRegisterPassword = !showRegisterPassword"
            class="absolute  left-3 top-8 pr-3 flex items-center text-gray-400 hover:text-white"
          >
            {{ showRegisterPassword ? '🙈' : '👁️' }}
          </button>
          <div class="text-xs mt-1">
            <p class="text-gray-400">رمز عبور باید شامل موارد زیر باشد:</p>
            <ul class="text-gray-400 mr-4 space-y-1">
              <li :class="{ 'text-lime-400': form.password && hasLetter(form.password) }">• حداقل یک حرف انگلیسی</li>
              <li :class="{ 'text-lime-400': form.password && hasNumber(form.password) }">• حداقل یک عدد</li>
              <li :class="{ 'text-lime-400': form.password && hasSpecialChar(form.password) }">• حداقل یک کاراکتر خاص (!@#$%^&*)</li>
              <li :class="{ 'text-lime-400': form.password && form.password.length >= 8 }">• حداقل ۸ کاراکتر</li>
            </ul>
            <p v-if="form.password && !isValidPassword(form.password)" class="text-red-400 mt-1">لطفاً یک رمز عبور معتبر وارد کنید</p>
            <p v-if="errors.password" class="text-red-400 mt-1">{{ errors.password[0] }}</p>
          </div>
        </div>

        <!-- Password Confirmation -->
        <div class="relative">
          <label class="text-gray-300 text-sm mb-1 block">تکرار رمز عبور</label>
          <input :type="showRegisterConfirmPassword ? 'text' : 'password'" v-model="form.password_confirmation"
                 placeholder="رمز عبور خود را مجدداً وارد کنید"
                 class="w-full px-4 py-2 pr-10 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': errors.password_confirmation || !passwordsMatch }" />
          <button
            type="button"
            @click="showRegisterConfirmPassword = !showRegisterConfirmPassword"
            class="absolute  left-3 top-8 pr-3 flex items-center text-gray-400 hover:text-white"
          >
            {{ showRegisterConfirmPassword ? '🙈' : '👁️' }}
          </button>
          <div class="text-xs mt-1">
            <p v-if="errors.password_confirmation" class="text-red-400">{{ errors.password_confirmation[0] }}</p>
            <p v-if="form.password && form.password_confirmation && !passwordsMatch" class="text-red-400">رمزهای عبور مطابقت ندارند</p>
            <p v-if="form.password && form.password_confirmation && passwordsMatch" class="text-green-400">رمزهای عبور مطابقت دارند</p>
          </div>
        </div>

        <!-- Terms -->
        <div class="flex items-center">
          <input id="terms" v-model="form.terms" type="checkbox"
                 class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
                 :class="{ 'border-red-500': errors.terms }" />
          <label for="terms" class="mr-2 block text-sm text-gray-300">
            با <a href="#" class="text-lime-400 hover:text-lime-300">قوانین و مقررات</a> موافقم
          </label>
        </div>
        <p v-if="errors.terms" class="text-red-400 text-xs mt-1">{{ errors.terms[0] }}</p>

        <!-- Error Message -->
        <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
          {{ error }}
        </div>

        <!-- Success Message -->
        <div v-if="$page.props.flash?.message" class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-xl text-sm text-center">
          {{ $page.props.flash.message }}
        </div>

        <!-- Submit -->
        <button type="submit" :disabled="loading || !passwordsMatch"
                class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
          <span v-if="loading">در حال ثبت‌نام...</span>
          <span v-else>ثبت‌نام</span>
        </button>

        <div class="text-center text-sm mt-2 text-gray-400">
          قبلاً حساب دارید؟
          <a href="#" @click.prevent="showLoginForm = true" class="hover:text-lime-400 transition">ورود</a>
        </div>
      </form>
    </div>

    <!-- Login Form -->
    <div v-else
         class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 w-full max-w-[400px] md:max-w-[500px] lg:max-w-[600px] max-h-[80vh] overflow-y-auto p-6 no-scrollbar">

      <h1 class="text-2xl md:text-3xl text-center text-lime-300 font-semibold mb-6">
        ورود به حساب ایوا
      </h1>

      <form @submit.prevent="login" class="space-y-4">

        <!-- Phone or Personal Code -->
        <div>
          <label class="text-gray-300 text-sm mb-1 block">شماره همراه یا کد پرسنلی</label>
          <input type="text" v-model="loginForm.phone" placeholder="09xxxxxxxxx یا کد پرسنلی"
                 class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': loginErrors.phone }" />
          <p v-if="loginErrors.phone" class="text-red-400 text-xs mt-1">{{ loginErrors.phone[0] }}</p>
        </div>

        <!-- Password -->
        <div class="relative">
          <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
          <input :type="showLoginPassword ? 'text' : 'password'" v-model="loginForm.password" placeholder="رمز خود را وارد کنید"
                 class="w-full px-4 py-2 pr-10 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                 :class="{ 'border-red-500': loginErrors.password }" />
          <button
            type="button"
            @click="showLoginPassword = !showLoginPassword"
            class="absolute inset-y-0 left-3 top-7 pr-3 flex items-center text-gray-400 hover:text-white"
          >
            {{ showLoginPassword ? '🙈' : '👁️' }}
          </button>
          <p v-if="loginErrors.password" class="text-red-400 text-xs mt-1">{{ loginErrors.password[0] }}</p>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
          <input
            id="remember"
            v-model="loginForm.remember"
            type="checkbox"
            class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
          />
          <label for="remember" class="mr-2 block text-sm text-gray-300">
            مرا به خاطر بسپار
          </label>
        </div>

        <!-- Error Message for Login -->
        <div v-if="loginError" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
          {{ loginError }}
        </div>

        <!-- Success Message -->
        <div v-if="$page.props.flash?.message" class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-xl text-sm text-center">
          {{ $page.props.flash.message }}
        </div>

        <!-- Login Submit -->
        <button type="submit" :disabled="loginLoading"
                class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
          <span v-if="loginLoading">در حال ورود...</span>
          <span v-else>ورود</span>
        </button>

        <div class="flex justify-between text-sm mt-3 text-gray-400">
          <a href="/forgot-password" class="hover:text-lime-400 transition">رمز عبور را فراموش کرده‌اید؟</a>
          <a href="#" @click.prevent="showLoginForm = false" class="hover:text-lime-400 transition">ثبت‌نام کنید</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { useCartStore } from '@/stores/cart'

const showAuthModal = computed(() => {
  const currentPath = window.location.pathname
  const excludedPaths = ['/login', '/register', '/forgot-password']
  return !excludedPaths.includes(currentPath)
})

const showLoginForm = ref(false)
const loading = ref(false)
const loginLoading = ref(false)
const error = ref('')
const loginError = ref('')
const errors = ref({})
const loginErrors = ref({})

const form = reactive({
  name: '',
  personal_code: '',
  phone: '',
  position: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
})

const loginForm = reactive({
  phone: '',
  password: '',
  remember: false
})

const showLoginPassword = ref(false)
const showRegisterPassword = ref(false)
const showRegisterConfirmPassword = ref(false)

const passwordsMatch = computed(() => {
  return form.password === form.password_confirmation
})

// Validation helpers
const isValidName = (name) => /^[\u0600-\u06FF\s]+$/.test(name) && name.trim().length > 0
const isValidPhone = (phone) => /^09\d{9}$/.test(phone)
const hasLetter = (password) => /[A-Za-z]/.test(password)
const hasNumber = (password) => /\d/.test(password)
const hasSpecialChar = (password) => /[!@#$%^&*]/.test(password)
const isValidPassword = (password) =>
  password.length >= 8 && hasLetter(password) && hasNumber(password) && hasSpecialChar(password)

// Register function
const register = async () => {
  if (form.name && !isValidName(form.name)) {
    errors.value = { name: ['لطفاً نام را به صورت صحیح و فقط با حروف فارسی وارد کنید'] };
    return
  }
  if (form.phone && !isValidPhone(form.phone)) {
    errors.value = { phone: ['لطفاً یک شماره تلفن معتبر وارد کنید'] };
    return
  }
  if (form.password !== form.password_confirmation) {
    error.value = 'رمزهای عبور مطابقت ندارند'
    return
  }

  loading.value = true
  error.value = ''
  errors.value = {}

  try {
    await router.post('/register', form, {
      onSuccess: () => console.log('Registration successful'),
      onError: (err) => {
        if (err.errors) errors.value = err.errors;
        error.value = err.message || 'خطا در ثبت‌نام. لطفا مجددا تلاش کنید.'
      },
      onFinish: () => loading.value = false
    })
  } catch {
    error.value = 'خطا در ارتباط با سرور';
    loading.value = false
  }
}

// Login function
const login = async () => {
  loginLoading.value = true
  loginError.value = ''

  try {
    await router.post('/login', loginForm, {
      onSuccess: async () => {
        // ensure cart store is loaded and then reload Inertia page props so all components get fresh auth/cart data
        try {
          const cart = useCartStore()
          // prefer canonical loader (falls back to initialize if needed)
          if (cart.loadCart) {
            await cart.loadCart()
          } else if (cart.initialize) {
            const res = await fetch('/cart', { headers: { Accept: 'application/json' } })
            const data = await res.json()
            cart.initialize(data.items || [])
          }
        } catch (e) {
          // eslint-disable-next-line no-console
          console.error('Failed to load cart after login', e)
        }

        // Force Inertia to reload page props so components relying on $page.props update immediately
        try {
          await router.reload()
        } catch (e) {
          // eslint-disable-next-line no-console
          console.error('Failed to reload page after login', e)
        }
      },
      onError: (err) => {
        loginError.value = err.message || 'خطا در ورود'
      },
      onFinish: () => loginLoading.value = false
    })
  } catch {
    loginError.value = 'خطا در ارتباط با سرور'
    loginLoading.value = false
  }
}

</script>

<style>
/* Hide scrollbars but allow scrolling */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
