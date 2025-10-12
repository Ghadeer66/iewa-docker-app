<template>
    <Layout>
        <!-- Slideshow: uses meals prop -->
        <section class="container mx-auto px-6 py-5">
            <SlideShow :items="meals" image-key="image" title-key="title" />
        </section>

        <!-- Categories component (static row) -->
        <CategoriesList :items="categories" />

        <section class="container mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold text-center mb-6"> منوی ایوا </h2>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- replace second list with horizontal scroller -->
                <CategoriesList :items="categories2" />
            </div>
        </section>

        <!-- Question category (below the ScrollCategories) -->
        <QuestionCategory :items="questionCategories" cta=' چی مشکل داری؟ ' gradient-from="#e9f1ff"
            gradient-to="#f6f8e9" />

        <div class="flex justify-center my-8">
            <BaseButton @click="handleClick">
                درخواست مشاوره رایگان
            </BaseButton>
        </div>

        <section class="container mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold text-center mb-6"> چرا ایوا؟ </h2>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- replace second list with horizontal scroller -->
                <CircleBorderCategoriesList :items="categories3" />
            </div>
        </section>

        <section class="container mb-12 mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold text-center mb-6"> مشتریان ما </h2>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- replace second list with horizontal scroller -->
                <CompaniesCategoriesList :items="companiesCategories" />
            </div>
        </section>
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

defineProps({ meals: Array })

const categories = [
    { title: 'لایت', image: 'storage/images/food-categories/light.png' },
    { title: 'رژیمی', image: '/storage/images/food-categories/diet.png' },
    { title: 'انرژیک', image: '/storage/images/food-categories/energy.png' },
    { title: 'کافئین', image: '/storage/images/food-categories/caffien.png' },
    { title: 'اکونومی', image: '/storage/images/food-categories/eco.png' },
    { title: 'مدرسه', image: '/storage/images/food-categories/school.png' }

]

const categories2 = [
    { title: 'پک میانوعده', image: 'storage/images/food-types/package.png' },
    { title: 'ساندویچ', image: 'storage/images/food-types/sandwich.png' },
    { title: 'سالاد', image: 'storage/images/food-types/salad.png' },
    { title: 'نوشیدنی', image: 'storage/images/food-types/drinks.png' },
    { title: 'صبحانه', image: 'storage/images/food-types/breakfast.png' },
    { title: 'کیک', image: 'storage/images/food-types/cake.png' },
    { title: 'اوتمیل', image: 'storage/images/food-types/ot-meal.png' },
]

// data for question category (optional override)
const questionCategories = [
    { title: ' چربی خون ', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: '  قند', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: ' مشکلات ارتوپدی ', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: ' ذهن سالم ', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
    { title: ' خواب ', image: 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png' },
]

const companiesCategories = [
    { image: 'http://iewato.ir/wp-content/uploads/2025/05/photo14524743455-1-e1748438251468.jpg' },
    { image: 'http://iewato.ir/wp-content/uploads/2025/05/%D9%84%D9%88%DA%AF%D9%88-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B5%D8%A7%D8%AF%D8%B1%D8%A7%D8%AA.png' },
    { image: 'http://iewato.ir/wp-content/uploads/2025/05/%D8%AF%D8%A7%D9%86%D9%84%D9%88%D8%AF-%D8%B1%D8%A7%DB%8C%DA%AF%D8%A7%D9%86-%D9%84%D9%88%DA%AF%D9%88-%D8%A2%D8%B1%D9%85-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B3%D9%BE%D9%87-%D8%A7%DB%8C%D8%B1%D8%A7%D9%86.png' },
    { image: 'http://iewato.ir/wp-content/uploads/2025/05/complexLogo-8df3-1583173540.png' }
]

const categories3 = [
    { title: 'بسته غذایی با کالری مشخص روزانه', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'مدیریت کاهش وزن و تناسب اندام', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'مشاوره تغذیه', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
    { title: 'پشتیبانی ویژه در طول روز', image: 'https://getjoule.co/assets/images/home_icon/3.png' },
]
</script>
