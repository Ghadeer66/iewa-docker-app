<template>
    <Layout>
        <!-- IF USER NOT AUTHENTICATED -->
        <!-- <div
      v-if="!isAuthenticated"
      class="fixed inset-0 flex justify-center items-center bg-black/50 backdrop-blur-lg z-50"
    >
      <div
        class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 w-[400px] border border-white/20"
      >
        <h1 class="text-2xl text-center text-lime-300 font-semibold mb-6">
          فرم ثبت‌نام پرسنل انتخاب<br>در ایوا
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
            <label class="text-gray-300 text-sm mb-1 block">کد پرسنلی</label>
            <input
              type="text"
              v-model="code"
              placeholder="کد خود را وارد کنید"
              class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
            />
          </div>

          <div>
            <label class="text-gray-300 text-sm mb-1 block">شماره تماس</label>
            <input
              type="text"
              v-model="phone"
              placeholder="09xxxxxxxxx"
              class="w-full px-4 py-2 bg-gray-800 text-white rounded-xl border border-gray-700 focus:ring-2 focus:ring-lime-400 outline-none"
            />
          </div>

          <div>
            <label class="text-gray-300 text-sm mb-1 block">پوزیشن سازمان</label>
            <input
              type="text"
              v-model="position"
              placeholder="مثلاً مدیر بخش فروش"
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
    </div> -->

        <!-- IF USER AUTHENTICATED -->
        <div>
            <!-- Slideshow -->
            <section class="container mx-auto px-6 py-5">
                <SlideShow :items="meals" image-key="image_url" title-key="title" />
            </section>

            <!-- Categories -->
            <section class="container mx-auto px- py-10">
                <h2 class="text-3xl font-bold text-right mb-6">منوی ایوا</h2>
                <div>
                    <StaticCategoriesList :items="categories" />
                </div>
            </section>
            <section class="container mx-auto px-6 py-10">
                <h2 class="text-3xl font-bold text-right mb-6">منوی ایوا</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <CategoriesList :items="categories2" />
                </div>
            </section>

            <QuestionCategory :items="questionCategories" cta="به دنبال رفع کدام مشکل؟" gradient-from="#e9f1ff"
                gradient-to="#f6f8e9" />

            <div class="flex justify-center my-8">
                <BaseButton @click="handleClick">درخواست مشاوره رایگان</BaseButton>
            </div>

            <section class="container mx-auto px-6 py-10 text-right">
                <h2 class="text-3xl font-bold mb-6">چرا ایوا؟</h2>
                <div class="mt-8">
                    <CircleBorderCategoriesList :items="categories3" />
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
                    <CompaniesCategoriesList :items="companiesCategories" />
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
import CompaniesCategoriesList from '@/components/CompaniesCategoriesList.vue'
import CircleBorderCategoriesList from '@/components/CircleBorderCategoriesList.vue'
import RulesButton from '@/components/RulesButton.vue'

defineProps({ meals: Array })

// state
const isAuthenticated = ref(false) // change later when auth implemented
const name = ref('')
const code = ref('')
const phone = ref('')
const position = ref('')
const expanded = ref(false)

// fake register
function register() {
    console.log('Registering:', {
        name: name.value,
        code: code.value,
        phone: phone.value,
        position: position.value,
    })
    isAuthenticated.value = true // simulate login success
}


const categories2 = [
    { title: 'لاین غذای اقتصادی', image: '/storage/images/food-categories/eco.png' },
    { title: 'پک میانوعده', image: 'storage/images/food-types/package.png' },
    { title: 'سالاد', image: 'storage/images/food-types/salad.png' },
    { title: 'ساندویچ', image: 'storage/images/food-types/sandwich.png' },
    { title: 'کیک و نان', image: 'storage/images/food-types/cake.png' },
    { title: 'دمنوش و قهوه', image: 'storage/images/food-types/coffee.png' },
    { title: 'نوشیدنی', image: 'storage/images/food-types/drinks.png' },
    { title: 'اوتمیل', image: 'storage/images/food-types/ot-meal.png' },
    { title: 'صبحانه', image: 'storage/images/food-types/breakfast.png' },
    { title: 'دسیرت‌ها', image: 'storage/images/food-types/dessert.png' },
]

const questionCategories = [
    { title: 'چربی خون', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: 'قند', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: 'مشکلات ارتوپدی', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: 'ذهن سالم', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: 'خواب', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
]

const companiesCategories = [{ image: 'http://iewato.ir/wp-content/uploads/2025/05/photo14524743455-1-e1748438251468.jpg' }, { image: 'http://iewato.ir/wp-content/uploads/2025/05/%D9%84%D9%88%DA%AF%D9%88-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B5%D8%A7%D8%AF%D8%B1%D8%A7%D8%AA.png' }, { image: 'http://iewato.ir/wp-content/uploads/2025/05/%D8%AF%D8%A7%D9%86%D9%84%D9%88%D8%AF-%D8%B1%D8%A7%DB%8C%DA%AF%D8%A7%D9%86-%D9%84%D9%88%DA%AF%D9%88-%D8%A2%D8%B1%D9%85-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B3%D9%BE%D9%87-%D8%A7%DB%8C%D8%B1%D8%A7%D9%86.png' }, { image: 'http://iewato.ir/wp-content/uploads/2025/05/complexLogo-8df3-1583173540.png' },]

const categories3 = [
    { title: 'افزایش آگاهی بر بدن', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'نمود انرژی در طول روز', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'حفظ سلامت بلندمدت', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'تجربه حس شادابی', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
]

function handleClick() {
    alert('درخواست شما ثبت شد!')
}

import { ref, onMounted } from 'vue'
import axios from 'axios'
import StaticCategoriesList from '@/components/StaticCategoriesList.vue'

const categories = ref([])
onMounted(async () => {
    try {
        const { data } = await axios.get('/api/section-elements')
        categories.value = data.map(item => ({
            title: item.title,
            image: item.image // make sure this matches your DB column
        }))
        console.log(categories);

    } catch (error) {
        console.error('Error fetching section elements:', error)
    }

})
</script>
