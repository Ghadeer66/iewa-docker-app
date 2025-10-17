<template>
    <!-- Global Auth Modal -->
    <div v-if="!$page.props.auth.user && showAuthModal"
        class="fixed inset-0 flex justify-center items-center bg-black/50 backdrop-blur-lg z-50">

        <!-- Registration Form -->
        <div v-if="!showLoginForm" class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[400px] border border-white/20">
            <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
                فرم ثبت‌نام پرسنل انتخاب<br>در ایوا
            </h1>

            <form @submit.prevent="register" class="space-y-5">
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">نام کامل</label>
                    <input
                        type="text"
                        v-model="form.name"
                        placeholder="مثلاً علی رضایی"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.name }"
                    />
                    <p v-if="errors.name" class="text-red-400 text-xs mt-1">{{ errors.name[0] }}</p>
                </div>

                <div>
                    <label class="text-gray-300 text-sm mb-1 block">کد پرسنلی</label>
                    <input
                        type="text"
                        v-model="form.personal_code"
                        placeholder="کد خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.personal_code }"
                    />
                    <p v-if="errors.personal_code" class="text-red-400 text-xs mt-1">{{ errors.personal_code[0] }}</p>
                </div>

                <div>
                    <label class="text-gray-300 text-sm mb-1 block">شماره تماس</label>
                    <input
                        type="text"
                        v-model="form.phone"
                        placeholder="09xxxxxxxxx"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.phone }"
                    />
                    <p v-if="errors.phone" class="text-red-400 text-xs mt-1">{{ errors.phone[0] }}</p>
                </div>

                <div>
                    <label class="text-gray-300 text-sm mb-1 block">پوزیشن سازمان</label>
                    <select
                        v-model="form.position"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.position }"
                    >
                        <option value="" disabled selected>پوزیشن خود را انتخاب کنید</option>
                        <option value="manager">مدیر</option>
                        <option value="supervisor">سرپرست</option>
                        <option value="employee">کارمند</option>
                        <option value="operator">اپراتور</option>
                    </select>
                    <p v-if="errors.position" class="text-red-400 text-xs mt-1">{{ errors.position[0] }}</p>
                </div>

                <!-- Email Field (Optional) -->
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">ایمیل (اختیاری)</label>
                    <input
                        type="email"
                        v-model="form.email"
                        placeholder="example@domain.com"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.email }"
                    />
                    <p v-if="errors.email" class="text-red-400 text-xs mt-1">{{ errors.email[0] }}</p>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
                    <input
                        type="password"
                        v-model="form.password"
                        placeholder="رمز عبور خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.password }"
                    />
                    <p v-if="errors.password" class="text-red-400 text-xs mt-1">{{ errors.password[0] }}</p>
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">تکرار رمز عبور</label>
                    <input
                        type="password"
                        v-model="form.password_confirmation"
                        placeholder="رمز عبور خود را مجدداً وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.password_confirmation }"
                    />
                    <p v-if="errors.password_confirmation" class="text-red-400 text-xs mt-1">{{ errors.password_confirmation[0] }}</p>
                </div>

                <!-- Terms Agreement -->
                <div class="flex items-center">
                    <input
                        id="terms"
                        v-model="form.terms"
                        type="checkbox"
                        class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
                        :class="{ 'border-red-500': errors.terms }"
                    />
                    <label for="terms" class="mr-2 block text-sm text-gray-300">
                        با <a href="#" class="text-lime-400 hover:text-lime-300">قوانین و مقررات</a> موافقم
                    </label>
                </div>
                <p v-if="errors.terms" class="text-red-400 text-xs mt-1">{{ errors.terms[0] }}</p>

                <!-- Error Message -->
                <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
                    {{ error }}
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="loading">در حال ثبت‌نام...</span>
                    <span v-else>ثبت‌نام</span>
                </button>

                <div class="text-center text-sm mt-3 text-gray-400">
                    قبلاً حساب دارید؟
                    <a href="#" @click.prevent="showLoginForm = true" class="hover:text-lime-400 transition">ورود</a>
                </div>
            </form>
        </div>

        <!-- Login Form -->
        <div v-else class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[380px] border border-white/20">
            <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
                ورود به حساب ایوا
            </h1>

            <form @submit.prevent="login" class="space-y-5">
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">شماره همراه یا کد پرسنلی</label>
                    <input
                        type="text"
                        v-model="loginForm.phone"
                        placeholder="09xxxxxxxxx یا کد پرسنلی"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': loginErrors.phone }"
                    />
                    <p v-if="loginErrors.phone" class="text-red-400 text-xs mt-1">{{ loginErrors.phone[0] }}</p>
                </div>

                <div>
                    <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
                    <input
                        type="password"
                        v-model="loginForm.password"
                        placeholder="رمز خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': loginErrors.password }"
                    />
                    <p v-if="loginErrors.password" class="text-red-400 text-xs mt-1">{{ loginErrors.password[0] }}</p>
                </div>

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

                <!-- Login Error Message -->
                <div v-if="loginError" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
                    {{ loginError }}
                </div>

                <button
                    type="submit"
                    :disabled="loginLoading"
                    class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
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

// Show modal on all pages except auth pages
const showAuthModal = computed(() => {
    const currentPath = window.location.pathname
    const excludedPaths = ['/login', '/register', '/forgot-password']
    return !excludedPaths.includes(currentPath)
})

// State
const showLoginForm = ref(false)
const loading = ref(false)
const loginLoading = ref(false)
const error = ref('')
const loginError = ref('')
const errors = ref({})
const loginErrors = ref({})

// Forms
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

// Register function
const register = async () => {
    loading.value = true
    error.value = ''
    errors.value = {}

    try {
        await router.post('/register', form, {
            onSuccess: () => {
                console.log('Registration successful')
            },
            onError: (err) => {
                if (err.errors) {
                    errors.value = err.errors
                }
                error.value = err.message || 'خطا در ثبت‌نام. لطفا مجددا تلاش کنید.'
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

// Login function
const login = async () => {
    loginLoading.value = true
    loginError.value = ''
    loginErrors.value = {}

    try {
        await router.post('/login', loginForm, {
            onSuccess: () => {
                console.log('Login successful')
            },
            onError: (err) => {
                if (err.errors) {
                    loginErrors.value = err.errors
                }
                loginError.value = err.message || 'خطا در ورود. لطفا مجددا تلاش کنید.'
            },
            onFinish: () => {
                loginLoading.value = false
            }
        })
    } catch (err) {
        loginError.value = 'خطا در ارتباط با سرور'
        loginLoading.value = false
    }
}
</script>
