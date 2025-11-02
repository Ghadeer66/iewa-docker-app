<template>
    <Layout>
        <Head>
            <title>ایوا | سفارش غذای سالم و باکیفیت</title>
            <meta name="description" content="ایوا - سفارش آنلاین غذای سالم، تازه و باکیفیت برای سازمان‌ها و شركت‌ها. منوی متنوع، قیمت مناسب و ارسال سریع." />
            <meta name="keywords" content="ایوا, سفارش غذا, غذای سالم, کترینگ سازمانی, منوی غذا, اصفهان, غذای تازه" />
            <link rel="canonical" :href="canonical" />

            <!-- Open Graph -->
            <meta property="og:title" content="ایوا | سفارش غذای سالم و باکیفیت" />
            <meta property="og:description" content="ایوا - سفارش آنلاین غذای سالم، تازه و باکیفیت برای سازمان‌ها و شركت‌ها. منوی متنوع، قیمت مناسب و ارسال سریع." />
            <meta property="og:type" content="website" />
            <meta property="og:url" :content="canonical" />
            <meta property="og:image" :content="ogImage" />

            <!-- Twitter -->
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" content="ایوا | سفارش غذای سالم و باکیفیت" />
            <meta name="twitter:description" content="ایوا - سفارش آنلاین غذای سالم، تازه و باکیفیت برای سازمان‌ها و شركت‌ها." />
            <meta name="twitter:image" :content="ogImage" />
        </Head>

        <!-- IF USER NOT AUTHENTICATED -->
        <div v-if="!$page.props.auth.user"
            class="fixed inset-0 flex justify-center items-center bg-black/50 backdrop-blur-lg z-50">
            <!-- ... your existing login/register forms ... -->
        </div>

        <!-- IF USER AUTHENTICATED -->
        <div v-else>
            <!-- User Info Bar -->
            <div class="bg-[#4e3356] text-white py-3 px-6">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <img :src="$page.props.auth.user.avatar || '/images/default-avatar.png'" alt="avatar"
                            class="w-8 h-8 rounded-full object-cover" />
                        <span class="font-medium">خوش آمدید، {{ $page.props.auth.user.name }}</span>
                    </div>
                </div>
            </div>

            <!-- Rest of your authenticated content -->
            <section class="container mx-auto px-6 py-5">
                <SlideShow :items="slideshowItems" image-key="image_url" title-key="title" />
            </section>

            <!-- Categories -->
            <section class="container mx-auto px- py-10">
                <div>
                    <StaticCategoriesList :items="packagesCategories" @category-click="handleCategoryClick" />
                </div>
            </section>

            <section class="container mx-auto px-6 py-10">
                <h2 class="text-3xl font-bold text-right mb-6">منوی ایوا</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <CategoriesList :items="menuCategories" @category-click="handleCategoryClick"
                        @type-click="handleTypeClick" />
                </div>
            </section>

            <QuestionCategory :items="problemsCategories" cta="به دنبال رفع کدام مشکل؟" gradient-from="#e9f1ff"
                gradient-to="#f6f8e9" @category-click="handleCategoryClick" @type-click="handleTypeClick" />

            <div class="flex justify-center my-8">
                <BaseButton @click="handleClick">درخواست مشاوره رایگان</BaseButton>
            </div>

            <section class="container mx-auto px-6 py-10 text-right">
                <h2 class="text-3xl font-bold mb-6">چرا ایوا؟</h2>
                <div class="mt-8">
                    <CircleBorderCategoriesList :items="specificationsCategories"
                        @category-click="handleCategoryClick" />
                </div>

                <!-- ... your existing content ... -->
            </section>

            <section class="container mb-12 mx-auto px-6 py-10">
                <h2 class="text-3xl font-bold text-right mb-6">به ما اعتماد کرده‌اند</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <CompaniesCategoriesList :items="clientsCategories" />
                </div>
            </section>

            <RulesButton v-if="!cartIsOpen" />
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
import { Head } from '@inertiajs/vue3'
import { ref, reactive, computed, inject } from 'vue'
import { router } from '@inertiajs/vue3'

const cartIsOpenRef = inject('cartIsOpen', ref(false))
const cartIsOpen = computed(() => cartIsOpenRef.value)

const canonical = computed(() => typeof window !== 'undefined' ? window.location.href : '')
const ogImage = computed(() => typeof window !== 'undefined' ? `${window.location.origin}/images/icon.png` : '')

defineProps({
    meals: Array,
    categories: Array,
    types: Array,
})

// State
const expanded = ref(false)
const loading = ref(false)
const error = ref('')
const errors = ref({})
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

// Login form
const loginForm = reactive({
    phone: '',
    password: '',
    remember: false
})

// Handle category click - navigate to menu with filter
const handleCategoryClick = (categoryTitle) => {
    router.get('/menu', { category: categoryTitle });
}

// Handle type click - navigate to menu with filter
const handleTypeClick = (typeTitle) => {
    // You might want to map type titles to your filter system
    // For now, we'll use the same approach as categories
    router.get('/menu', { type: typeTitle });
}

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

function handleClick() {
    alert('درخواست شما ثبت شد!')
}

const packagesCategories = ref([])
const menuCategories = ref([])
const problemsCategories = ref([])
const specificationsCategories = ref([])
// const clientsCategories = ref([])

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
            acc[t].push({
                title: item.title,
                image: item.image,
                // Add click handler data
                onClick: () => handleCategoryClick(item.title)
            })
            return acc
        }, {})

        packagesCategories.value = byType.package || []
        menuCategories.value = byType.menu || []
        problemsCategories.value = byType.problem || []
        specificationsCategories.value = byType.specification || []
        // clientsCategories.value = (byType.client || []).map(it => ({
        //     image: it.image,
        //     title: it.title
        // }))
    } catch (error) {
        console.error('Error fetching section elements:', error)
    }
})

const slideshowItems = ref([
    { image_url: '/images/slide-show/01.png', title: 'عنوان ۱' },
    { image_url: '/images/slide-show/02.png', title: 'عنوان ۲' },
    { image_url: '/images/slide-show/03.png', title: 'عنوان ۳' },
    { image_url: '/images/slide-show/04.png', title: 'عنوان ۴' },
])

const clientsCategories = ref([
    { image: '/images/customers/entikhab.png', title: 'عنوان ۱' },
    { image: '/images/customers/irisa.jpg', title: 'عنوان ۲' },
    { image: '/images/customers/saderat.png', title: 'عنوان ۳' },
    { image: '/images/customers/sepah.png', title: 'عنوان ۴' },
])
</script>
