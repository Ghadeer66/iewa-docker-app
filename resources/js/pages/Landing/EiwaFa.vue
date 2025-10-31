<template>
    <Layout>
        <Head>
            <title>ایوا — وبسایت رسمی</title>
            <meta name="description" content="ایوا (Iewa) — صفحه فرود رسمی برای کلمه کلیدی ایوا." />
            <link rel="canonical" :href="canonical" />
            <meta property="og:title" content="ایوا — وبسایت رسمی" />
            <meta property="og:description" content="ایوا (Iewa) — صفحه فرود رسمی برای کلمه کلیدی ایوا." />
            <meta property="og:type" content="website" />
            <meta property="og:url" :content="canonical" />
        </Head>
        <section class="container mx-auto px-6 py-12 text-right">
            <h1 class="text-3xl font-bold mb-4">ایوا</h1>
            <p class="text-lg text-gray-700">صفحه فرود برای «ایوا» جهت بهبود سئو و دسترسی.</p>
        </section>
    </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const canonical = computed(() => typeof window !== 'undefined' ? window.location.href : '')
</script>


