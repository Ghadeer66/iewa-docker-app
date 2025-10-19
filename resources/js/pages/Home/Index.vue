<template>
    <Layout>
        <!-- IF USER NOT AUTHENTICATED -->
        <div v-if="!$page.props.auth.user"
            class="fixed inset-0 flex justify-center items-center bg-black/50 backdrop-blur-lg z-50">

            <!-- Registration Form (Responsive & Scrollable) -->
<div
  v-if="!showLoginForm"
  class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20
         w-full max-w-md mx-auto py-12 p-6 sm:p-8 relative flex flex-col"
  style="max-height: 90vh;"
>
  <h1 class="text-2xl text-center text-lime-300 font-semibold mb-4 sm:mb-6 leading-snug">
    فرم ثبت‌نام پرسنل انتخاب<br>در ایوا
  </h1>

  <!-- Scrollable Form Area -->
  <div class="overflow-y-auto flex-1 pr-1" style="scrollbar-width: thin;">
    <form @submit.prevent="register" class="space-y-4 sm:space-y-5">
      <!-- Name -->
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

      <!-- Personal Code -->
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

      <!-- Phone -->
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

      <!-- Position -->
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

      <!-- Email
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
      </div> -->

      <!-- Password -->
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

      <!-- Password Confirmation -->
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

      <!-- Terms -->
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

      <!-- Error -->
      <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl text-sm text-center">
        {{ error }}
      </div>
    </form>
  </div>

  <!-- Sticky Submit -->
  <div class="pt-4">
    <button
      type="submit"
      :disabled="loading"
      class="w-full py-3 rounded-xl bg-lime-400 text-gray-900 font-semibold hover:bg-lime-300 transition disabled:opacity-50 disabled:cursor-not-allowed"
      @click="register"
    >
      <span v-if="loading">در حال ثبت‌نام...</span>
      <span v-else>ثبت‌نام</span>
    </button>

    <div class="text-center text-sm mt-3 text-gray-400">
      قبلاً حساب دارید؟
      <a href="#" @click.prevent="showLoginForm = true" class="hover:text-lime-400 transition">ورود</a>
    </div>
  </div>
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

        <!-- IF USER AUTHENTICATED -->
        <div v-else>
            <!-- User Info Bar -->
            <div class="bg-[#4e3356] text-white py-3 px-6">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <img
                            :src="$page.props.auth.user.avatar || '/images/default-avatar.png'"
                            alt="avatar"
                            class="w-8 h-8 rounded-full object-cover"
                        />
                        <span class="font-medium">خوش آمدید، {{ $page.props.auth.user.name }}</span>
                    </div>

                </div>
            </div>

            <!-- Rest of your authenticated content remains exactly the same -->
            <section class="container mx-auto px-6 py-5">
                <SlideShow :items="meals" image-key="image_url" title-key="title" />
            </section>

            <!-- Categories -->
            <section class="container mx-auto px- py-10">
                <div>
                    <StaticCategoriesList :items="packagesCategories" />
                </div>
            </section>

            <section class="container mx-auto px-6 py-10">
                <h2 class="text-3xl font-bold text-right mb-6">منوی ایوا</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <CategoriesList :items="menuCategories" />
                </div>
            </section>

            <QuestionCategory :items="problemsCategories" cta="به دنبال رفع کدام مشکل؟" gradient-from="#e9f1ff"
                gradient-to="#f6f8e9" />

            <div class="flex justify-center my-8">
                <BaseButton @click="handleClick">درخواست مشاوره رایگان</BaseButton>
            </div>

            <section class="container mx-auto px-6 py-10 text-right">
                <h2 class="text-3xl font-bold mb-6">چرا ایوا؟</h2>
                <div class="mt-8">
                    <CircleBorderCategoriesList :items="specificationsCategories" />
                </div>

                <div class="relative transition-all duration-500 overflow-hidden" :class="{ 'max-h-40': !expanded }">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-3"> غذای رژیمی و سلامت ایوا در ایوا،
                        باور ما این است که سلامتی باید برای همه قابل دسترس، ساده و لذت‌بخش باشد. ما غذا را فقط به عنوان
                        وعده‌ای برای سیر شدن نمی‌بینیم، بلکه آن را ابزاری برای مراقبت از بدن، ذهن و روح می‌دانیم. هر
                        وعده غذایی فرصتی است برای بازسازی بدن، بازیابی انرژی و افزایش نشاط روزانه. </p>
                    <p class="mb-3"> تیم تغذیه و آشپزی ایوا با بهره‌گیری از جدیدترین دستاوردهای علم تغذیه، بسته‌های
                        غذایی متنوعی طراحی کرده‌اند که متناسب با نیازهای گوناگون است — از کاهش وزن و تنظیم قند خون گرفته
                        تا رژیم‌های گیاه‌خواری و برنامه‌های ویژه ورزشکاران. ما اعتقاد داریم که هر فرد، بدن و نیاز
                        منحصربه‌فرد خود را دارد؛ بنابراین هیچ رژیم عمومی و از پیش‌تعیین‌شده‌ای نمی‌تواند پاسخ‌گوی همه
                        باشد. به همین دلیل، در ایوا هر بسته غذایی با مشاوره تخصصی طراحی می‌شود. </p>
                    <p class="mb-3"> مأموریت ما تنها ارائه غذای سالم نیست، بلکه ایجاد عادت‌های پایدار سلامتی است. ایوا
                        تلاش می‌کند تا مفهوم رژیم را از محدودیت و اجبار، به تجربه‌ای لذت‌بخش و هوشمندانه تبدیل کند. از
                        انتخاب مواد اولیه تا نحوه پخت، همه‌چیز با دقت و وسواس علمی انجام می‌شود تا بدن شما به شکل طبیعی
                        تغذیه شود و ذهن‌تان احساس آرامش کند. در ایوا، مشاوران تغذیه ما همیشه آماده‌اند تا به صورت رایگان
                        وضعیت شما را بررسی کرده و بسته مناسب را پیشنهاد دهند. هر بسته شامل غذاهای تازه و متنوع برای
                        وعده‌های مختلف روزانه است — صبحانه‌هایی انرژی‌زا، ناهارهای متعادل و شام‌هایی سبک و مغذی. هدف ما
                        این است که شما بدون احساس گرسنگی یا خستگی، سبک زندگی سالم را ادامه دهید. </p>
                    <p class="mb-3"> علاوه بر این، ایوا خدمات مشاوره اختصاصی برای مادران باردار، بیماران دیابتی، افرادی
                        با کلسترول یا فشار خون بالا و ورزشکاران حرفه‌ای ارائه می‌دهد. تمام غذاهای ما بر اساس
                        استانداردهای علمی و با نظارت متخصصان تهیه می‌شوند. ما به‌جای افزودنی‌های مصنوعی از ادویه‌های
                        طبیعی، روغن‌های سالم و سبزیجات تازه استفاده می‌کنیم تا طعم اصیل غذاها حفظ شود. </p>
                    <p> در نهایت، ایوا به دنبال ساختن فرهنگی نو در تغذیه ایرانی است — فرهنگی که در آن غذا به‌جای تهدیدی
                        برای سلامتی، به فرصتی برای بهبود کیفیت زندگی تبدیل شود. اگر شما نیز به سبک زندگی سالم باور
                        دارید، ایوا همراهی مطمئن برای این مسیر است. </p>

                    <div v-if="!expanded"
                        class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-white to-transparent pointer-events-none">
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <button v-if="!expanded" @click="expanded = true"
                        class="text-[#3e4095] font-semibold hover:underline cursor-pointer">
                        پیشتر
                    </button>
                    <button v-else @click="expanded = false"
                        class="text-[#3e4095] font-semibold hover:underline cursor-pointer">
                        بستن
                    </button>
                </div>
            </section>

            <section class="container mb-12 mx-auto px-6 py-10">
                <h2 class="text-3xl font-bold text-right mb-6">به ما اعتماد کرده‌اند</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <CompaniesCategoriesList :items="clientsCategories" />
                </div>
            </section>

            <RulesButton />
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import SlideShow from '@/components/Slideshow.vue'
import CategoriesList from '@/components/CategoriesList.vue'
import QuestionCategory from '@/components/QuestionCategory.vue'
import BaseButton from '@/components/BaseButton.vue'
import CircleBorderCategoriesList from '@/components/CircleBorderCategoriesList.vue'
import RulesButton from '@/components/RulesButton.vue'
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

defineProps({
    meals: Array,
})

// State
const expanded = ref(false)
const loading = ref(false)
const error = ref('')
const errors = ref({})

// NEW: Login form state
const showLoginForm = ref(false)
const loginLoading = ref(false)
const loginError = ref('')
const loginErrors = ref({})

// Registration form
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

// NEW: Login form
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

// NEW: Login function
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

// Logout function
const logout = () => {
    router.post('/logout')
}

// Other functions and data remain exactly the same
function handleClick() {
    alert('درخواست شما ثبت شد!')
}


const packagesCategories = ref([])
const menuCategories = ref([])
const problemsCategories = ref([])
const specificationsCategories = ref([])
const clientsCategories = ref([])



// Data fetching for categories
import { onMounted } from 'vue'
import axios from 'axios'
import StaticCategoriesList from '@/components/StaticCategoriesList.vue'
import CompaniesCategoriesList from '@/components/CompaniesCategoriesList.vue'

const categories = ref([])
onMounted(async () => {
    try {
        const { data } = await axios.get('/api/section-elements')
        categories.value = data

        // Group by type
        const byType = data.reduce((acc, item) => {
            const t = item.type || 'unknown'
            if (!acc[t]) acc[t] = []
            acc[t].push({ title: item.title, image: item.image })
            return acc
        }, {})

        packagesCategories.value = byType.package || []
        menuCategories.value = byType.menu || []
        problemsCategories.value = byType.problem || []
        specificationsCategories.value = byType.specification || []
        // Clients may not have title; ensure shape expected by CompaniesCategoriesList
        clientsCategories.value = (byType.client || []).map(it => ({ image: it.image, title: it.title }))
    } catch (error) {
        console.error('Error fetching section elements:', error)
    }
})
</script>
