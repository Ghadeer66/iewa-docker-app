<template>
    <AuthBase>
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[400px] border border-white/20">
            <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
                فرم ثبت‌نام پرسنل انتخاب<br>در ایوا</br>
            </h1>

            <form @submit.prevent="register" class="space-y-5">
                <!-- Name Field -->
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

                <!-- Email Field -->
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

                <!-- Personal Code Field (with one 'n') -->
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">کد پرسنلی</label>
                    <input
                        type="text"
                        v-model="form.personal_code"
                        placeholder="کد پرسنلی خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
                        :class="{ 'border-red-500': errors.personal_code }"
                    />
                    <p v-if="errors.personal_code" class="text-red-400 text-xs mt-1">{{ errors.personal_code[0] }}</p>
                </div>

                <!-- Phone Field -->
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

                <!-- Position Field -->
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

                <!-- Success Message -->
                <div v-if="$page.props.flash?.message" class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-xl text-sm text-center">
                    {{ $page.props.flash.message }}
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
                    <a href="/login" class="hover:text-lime-400 transition">ورود</a>
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
    name: '',
    email: '',
    phone: '',
    personal_code: '', // Changed to personal_code
    password: '',
    password_confirmation: '',
    position: '',
    terms: false
})

const loading = ref(false)
const error = ref('')
const errors = ref({})

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
</script>
