<template>
    <BusinessAuthLayout>
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[400px] border border-white/20">
            <h1 class="text-2xl text-center text-blue-400 font-semibold mb-6">
                ورود به پنل کسب‌وکار
            </h1>

            <form @submit.prevent="login" class="space-y-5">
                <div>
                    <label class="text-gray-300 text-sm mb-1 block">شماره تماس</label>
                    <input
                        type="pkone"
                        v-model="form.phone"
                        placeholder="شماره تماس خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-blue-400 outline-none"
                        :class="{ 'border-red-500': errors.phone }"
                    />
                    <p v-if="errors.phone" class="text-red-400 text-xs mt-1">{{ errors.phone[0] }}</p>
                </div>

                <div>
                    <label class="text-gray-300 text-sm mb-1 block">رمز عبور</label>
                    <input
                        type="password"
                        v-model="form.password"
                        placeholder="رمز عبور خود را وارد کنید"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-blue-400 outline-none"
                        :class="{ 'border-red-500': errors.password }"
                    />
                    <p v-if="errors.password" class="text-red-400 text-xs mt-1">{{ errors.password[0] }}</p>
                </div>

                <div class="flex items-center">
                    <input
                        id="remember"
                        v-model="form.remember"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="remember" class="mr-2 block text-sm text-gray-300">
                        مرا به خاطر بسپار
                    </label>
                </div>

                <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
                    {{ error }}
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full py-3 rounded-xl bg-blue-500 text-white font-semibold hover:bg-blue-400 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="loading">در حال ورود...</span>
                    <span v-else>ورود به پنل</span>
                </button>

                <div class="text-center text-sm mt-3 text-gray-400">
                    حساب کسب‌وکار ندارید؟
                </div>
            </form>
        </div>
    </BusinessAuthLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import BusinessAuthLayout from '@/Layouts/BusinessAuthLayout.vue'

const form = reactive({
    email: '',
    password: '',
    remember: false
})

const loading = ref(false)
const error = ref('')
const errors = ref({})

const login = async () => {
    loading.value = true
    error.value = ''
    errors.value = {}

    try {
        await router.post('/business/login', form, {
            onSuccess: () => {
                console.log('Business login successful')
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
